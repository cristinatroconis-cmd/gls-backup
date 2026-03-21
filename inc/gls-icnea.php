<?php
// inc/gls-icnea.php
if (!defined('ABSPATH')) exit;

if (!defined('GLS_ICNEA_BASE')) {
  define('GLS_ICNEA_BASE', 'https://granadaluxurysuites.icnea.net');
}

/**
 * Marca el estado de fallback para el request actual.
 *
 * @param bool $enabled
 * @return void
 */
function gls_icnea_set_fallback_mode($enabled)
{
  $GLOBALS['gls_icnea_fallback_mode'] = (bool) $enabled;
}

/**
 * Detecta si la respuesta actual implica modo fallback
 * o devuelve el estado global actual si no recibe argumento.
 *
 * @param mixed $response
 * @return bool
 */
function gls_icnea_is_fallback_mode($response = null)
{
  if (is_wp_error($response)) {
    $error_code = (string) $response->get_error_code();

    $fallback_codes = [
      'http_request_failed',
      'http_request_timeout',
      'gls_icnea_http',
      'gls_icnea_empty_response',
      'gls_icnea_bad_json',
    ];

    if (in_array($error_code, $fallback_codes, true)) {
      return true;
    }

    $message = strtolower((string) $response->get_error_message());

    return (strpos($message, 'timed out') !== false)
      || (strpos($message, 'timeout') !== false);
  }

  if ($response === null) {
    return !empty($GLOBALS['gls_icnea_fallback_mode']);
  }

  return false;
}

/**
 * Límite de apartamentos a mostrar cuando ICNEA entra en fallback.
 *
 * @return int
 */
function gls_icnea_get_fallback_posts_limit()
{
  return 6;
}

function gls_icnea_normalize_date($date_raw)
{
  $date_raw = trim((string) $date_raw);

  // dd/mm/YYYY
  if (preg_match('#^\d{2}/\d{2}/\d{4}$#', $date_raw)) {
    return $date_raw;
  }

  // YYYY-mm-dd -> dd/mm/YYYY
  if (preg_match('#^\d{4}-\d{2}-\d{2}$#', $date_raw)) {
    $dt = DateTime::createFromFormat('Y-m-d', $date_raw);
    return $dt ? $dt->format('d/m/Y') : '';
  }

  return '';
}

function gls_icnea_nights($arrival_ddmmyyyy, $departure_ddmmyyyy)
{
  $a = DateTime::createFromFormat('d/m/Y', $arrival_ddmmyyyy);
  $d = DateTime::createFromFormat('d/m/Y', $departure_ddmmyyyy);

  if (!$a || !$d) {
    return 0;
  }

  $diff = (int) $a->diff($d)->format('%a');

  return max(0, $diff);
}

function gls_icnea_extract_id_from_url($url)
{
  $url = (string) $url;

  if (preg_match('#-h(\d+)(?:[/?]|$)#i', $url, $m)) {
    return (int) $m[1];
  }

  return 0;
}

/**
 * Llama a ICNEA WebService.asmx/DailyRates
 * Devuelve array parseado (interno) o WP_Error.
 *
 * @param int    $icnea_id
 * @param string $arrival
 * @param string $departure
 * @param int    $people
 * @param string $language
 * @return array|WP_Error
 */
function gls_icnea_daily_rates($icnea_id, $arrival, $departure, $people = 2, $language = 'es')
{
  $icnea_id  = (int) $icnea_id;
  $people    = max(1, (int) $people);
  $arrival   = gls_icnea_normalize_date($arrival);
  $departure = gls_icnea_normalize_date($departure);

  if (!$icnea_id || !$arrival || !$departure) {
    return new WP_Error('gls_icnea_bad_args', 'Parámetros incompletos para ICNEA.');
  }

  $cache_key = 'gls_icnea_dr_' . md5($icnea_id . '|' . $arrival . '|' . $departure . '|' . $people . '|' . $language);
  $cached = get_transient($cache_key);

  if ($cached !== false) {
    return $cached;
  }

  $url = GLS_ICNEA_BASE . '/WebService.asmx/DailyRates';

  $payload = wp_json_encode([
    'id'        => $icnea_id,
    'arrival'   => $arrival,
    'departure' => $departure,
    'people'    => $people,
    'language'  => $language,
  ]);

  $resp = wp_remote_post($url, [
    'headers' => [
      'Content-Type'     => 'application/json; charset=utf-8',
      'X-Requested-With' => 'XMLHttpRequest',
      'Accept'           => 'application/json, text/javascript, */*; q=0.01',
    ],
    'body'    => $payload,
    'timeout' => 12,
  ]);

  if (is_wp_error($resp)) {
    return $resp;
  }

  $code = wp_remote_retrieve_response_code($resp);
  $body = wp_remote_retrieve_body($resp);

  if ($code < 200 || $code >= 300) {
    return new WP_Error('gls_icnea_http', 'Respuesta no válida de ICNEA.', ['status' => $code]);
  }

  if (!is_string($body) || trim($body) === '') {
    return new WP_Error('gls_icnea_empty_response', 'ICNEA devolvió una respuesta vacía.');
  }

  $json = json_decode($body, true);

  if (!is_array($json) || json_last_error() !== JSON_ERROR_NONE) {
    return new WP_Error('gls_icnea_bad_json', 'ICNEA devolvió JSON inválido.');
  }

  // Formato habitual: {"d":"{...json string...}"}
  if (isset($json['d']) && is_string($json['d'])) {
    $inner = json_decode($json['d'], true);

    if (!is_array($inner) || json_last_error() !== JSON_ERROR_NONE) {
      return new WP_Error('gls_icnea_bad_json', 'ICNEA devolvió JSON interno inválido.');
    }

    $json = $inner;
  }

  set_transient($cache_key, $json, 10 * MINUTE_IN_SECONDS);

  return $json;
}

/**
 * Regla de disponibilidad:
 * - DailyRates >= 1
 * - closed_to_arrival/departure == false
 * - minimum_stay <= noches
 *
 * @param array $daily_rates_json
 * @param int   $nights
 * @return bool
 */
function gls_icnea_is_available($daily_rates_json, $nights)
{
  if (!is_array($daily_rates_json)) {
    return false;
  }

  $rates = $daily_rates_json['DailyRates'] ?? null;

  if (!is_array($rates) || count($rates) < 1) {
    return false;
  }

  foreach ($rates as $rate) {
    $cta = (string) ($rate['closed_to_arrival'] ?? 'false');
    $ctd = (string) ($rate['closed_to_departure'] ?? 'false');
    $min = (int) ($rate['minimum_stay'] ?? 0);

    if ($cta === 'false' && $ctd === 'false' && $min <= (int) $nights) {
      return true;
    }
  }

  return false;
}

/**
 * Cache local de `icnea_id` por post para evitar llamadas repetidas a ACF.
 *
 * @param int $post_id
 * @return int
 */
function gls_get_icnea_id($post_id)
{
  static $cache = [];

  $post_id = (int) $post_id;

  if ($post_id <= 0) {
    return 0;
  }

  if (array_key_exists($post_id, $cache)) {
    return (int) $cache[$post_id];
  }

  $cache[$post_id] = (int) get_field('icnea_id', $post_id);

  return (int) $cache[$post_id];
}

/**
 * Devuelve el ID ICNEA para un post:
 * 1. Campo técnico `icnea_id`
 * 2. Fallback: extracción desde `boton_de_reserva`
 *
 * @param int $post_id
 * @return int
 */
function gls_icnea_get_id_for_post($post_id)
{
  $post_id = (int) $post_id;

  $icnea_id = gls_get_icnea_id($post_id);
  if ($icnea_id > 0) {
    return $icnea_id;
  }

  $btn = get_field('boton_de_reserva', $post_id);
  $url = is_array($btn) ? ($btn['url'] ?? '') : (string) $btn;

  return gls_icnea_extract_id_from_url($url);
}

/**
 * Devuelve IDs disponibles para esas fechas y huéspedes.
 *
 * Retornos:
 * - null  => fallback (ICNEA falló)
 * - []    => 0 resultados válidos
 * - [ids] => resultados disponibles
 *
 * @param string $arrival
 * @param string $departure
 * @param int    $guests
 * @param string $lang
 * @return array|null
 */
function gls_icnea_get_available_post_ids($arrival, $departure, $guests = 2, $lang = 'es')
{
  gls_icnea_set_fallback_mode(false);

  $arrival   = gls_icnea_normalize_date($arrival);
  $departure = gls_icnea_normalize_date($departure);
  $guests    = max(1, (int) $guests);

  if (!$arrival || !$departure) {
    return null;
  }

  $nights = gls_icnea_nights($arrival, $departure);

  if ($nights < 2) {
    return [];
  }

  $list_key = 'gls_icnea_available_' . md5($arrival . '|' . $departure . '|' . $guests . '|' . $lang);
  $cached = get_transient($list_key);

  if (is_array($cached)) {
    return $cached;
  }

  $all = new WP_Query([
    'post_type'      => 'apartamentos',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'orderby'        => [
      'menu_order' => 'ASC',
      'date'       => 'DESC',
    ],
    'no_found_rows'  => true,
  ]);

  $available_ids = [];

  foreach ($all->posts as $post_id) {
    $icnea_id = gls_icnea_get_id_for_post($post_id);

    if (!$icnea_id) {
      continue;
    }

    $dr = gls_icnea_daily_rates($icnea_id, $arrival, $departure, $guests, $lang);

    if (gls_icnea_is_fallback_mode($dr)) {
      gls_icnea_set_fallback_mode(true);
      delete_transient($list_key);
      return null;
    }

    if (gls_icnea_is_available($dr, $nights)) {
      $available_ids[] = (int) $post_id;
    }
  }

  set_transient($list_key, $available_ids, 10 * MINUTE_IN_SECONDS);

  return $available_ids;
}

/**
 * Devuelve un valor GET saneado.
 *
 * @param string|array $keys
 * @return string
 */
function gls_icnea_get_query_var($keys)
{
  $keys = (array) $keys;

  foreach ($keys as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
      return sanitize_text_field(wp_unslash($_GET[$key]));
    }
  }

  return '';
}

/**
 * Normaliza parámetros del buscador para aceptar:
 * - arrival / departure
 * - checkin / checkout
 *
 * @return array
 */
function gls_icnea_get_search_args_from_request()
{
  $arrival_raw   = gls_icnea_get_query_var(['arrival', 'checkin']);
  $departure_raw = gls_icnea_get_query_var(['departure', 'checkout']);
  $guests_raw    = gls_icnea_get_query_var(['guests', 'people', 'persons']);

  $arrival   = gls_icnea_normalize_date($arrival_raw);
  $departure = gls_icnea_normalize_date($departure_raw);
  $guests    = max(1, (int) $guests_raw ?: 2);

  return [
    'arrival'   => $arrival,
    'departure' => $departure,
    'guests'    => $guests,
    'has_dates' => !empty($arrival) && !empty($departure),
  ];
}
