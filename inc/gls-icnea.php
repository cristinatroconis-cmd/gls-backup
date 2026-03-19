<?php
// inc/gls-icnea.php
if (!defined('ABSPATH')) exit;

if (!defined('GLS_ICNEA_BASE')) {
  define('GLS_ICNEA_BASE', 'https://granadaluxurysuites.icnea.net');
}

function gls_icnea_normalize_date($date_raw) {
  $date_raw = trim((string) $date_raw);

  // dd/mm/YYYY
  if (preg_match('#^\d{2}/\d{2}/\d{4}$#', $date_raw)) return $date_raw;

  // YYYY-mm-dd -> dd/mm/YYYY
  if (preg_match('#^\d{4}-\d{2}-\d{2}$#', $date_raw)) {
    $dt = DateTime::createFromFormat('Y-m-d', $date_raw);
    return $dt ? $dt->format('d/m/Y') : '';
  }

  return '';
}

function gls_icnea_nights($arrival_ddmmyyyy, $departure_ddmmyyyy) {
  $a = DateTime::createFromFormat('d/m/Y', $arrival_ddmmyyyy);
  $d = DateTime::createFromFormat('d/m/Y', $departure_ddmmyyyy);
  if (!$a || !$d) return 0;
  $diff = (int) $a->diff($d)->format('%a');
  return max(0, $diff);
}

function gls_icnea_extract_id_from_url($url) {
  $url = (string) $url;
  if (preg_match('#-h(\d+)(?:[/?]|$)#i', $url, $m)) {
    return (int) $m[1];
  }
  return 0;
}

/**
 * Llama a ICNEA WebService.asmx/DailyRates
 * Devuelve array parseado (interno) o WP_Error
 */
function gls_icnea_daily_rates($icnea_id, $arrival, $departure, $people = 2, $language = 'es') {
  $icnea_id  = (int) $icnea_id;
  $people    = max(1, (int) $people);
  $arrival   = gls_icnea_normalize_date($arrival);
  $departure = gls_icnea_normalize_date($departure);

  if (!$icnea_id || !$arrival || !$departure) {
    return new WP_Error('gls_icnea_bad_args', 'Parámetros incompletos para ICNEA.');
  }

  $cache_key = 'gls_icnea_dr_' . md5($icnea_id . '|' . $arrival . '|' . $departure . '|' . $people . '|' . $language);
  $cached = get_transient($cache_key);
  if ($cached !== false) return $cached;

  $url = GLS_ICNEA_BASE . '/WebService.asmx/DailyRates';
  $payload = wp_json_encode([
    'id' => $icnea_id,
    'arrival' => $arrival,
    'departure' => $departure,
    'people' => $people,
    'language' => $language,
  ]);

  $resp = wp_remote_post($url, [
    'headers' => [
      'Content-Type' => 'application/json; charset=utf-8',
      'X-Requested-With' => 'XMLHttpRequest',
      'Accept' => 'application/json, text/javascript, */*; q=0.01',
    ],
    'body' => $payload,
    'timeout' => 12,
  ]);

  if (is_wp_error($resp)) return $resp;

  $code = wp_remote_retrieve_response_code($resp);
  $body = wp_remote_retrieve_body($resp);

  if ($code < 200 || $code >= 300 || !$body) {
    return new WP_Error('gls_icnea_http', 'Respuesta no válida de ICNEA.', ['status' => $code]);
  }

  $json = json_decode($body, true);
  if (!is_array($json)) {
    return new WP_Error('gls_icnea_bad_json', 'ICNEA devolvió JSON inválido.');
  }

  // {"d":"{...json string...}"}
  if (isset($json['d']) && is_string($json['d'])) {
    $inner = json_decode($json['d'], true);
    if (is_array($inner)) $json = $inner;
  }

  set_transient($cache_key, $json, 10 * MINUTE_IN_SECONDS);
  return $json;
}

/**
 * Regla de disponibilidad basada en tu respuesta real:
 * - DailyRates >= 1
 * - closed_to_arrival/departure == false
 * - minimum_stay <= noches
 */
function gls_icnea_is_available($daily_rates_json, $nights) {
  if (!is_array($daily_rates_json)) return false;

  $rates = $daily_rates_json['DailyRates'] ?? null;
  if (!is_array($rates) || count($rates) < 1) return false;

  foreach ($rates as $rate) {
    $cta = (string) ($rate['closed_to_arrival'] ?? 'false');
    $ctd = (string) ($rate['closed_to_departure'] ?? 'false');
    $min = (int) ($rate['minimum_stay'] ?? 0);

    if ($cta === 'false' && $ctd === 'false' && $min <= (int)$nights) {
      return true;
    }
  }

  return false;
}

/**
 * Devuelve el ID ICNEA para un post:
 * 1. Lee el campo técnico `icnea_id` (ACF).
 * 2. Si no existe o está vacío, extrae el ID desde la URL del campo `boton_de_reserva`.
 *
 * @param int $post_id
 * @return int  El ID ICNEA, o 0 si no se puede determinar.
 */
function gls_icnea_get_id_for_post($post_id) {
  $post_id = (int) $post_id;

  // Prioridad: campo técnico dedicado.
  $icnea_id = (int) get_field('icnea_id', $post_id);
  if ($icnea_id > 0) {
    return $icnea_id;
  }

  // Fallback: extraer desde la URL del botón de reserva.
  $btn = get_field('boton_de_reserva', $post_id);
  $url = is_array($btn) ? ($btn['url'] ?? '') : (string) $btn;
  return gls_icnea_extract_id_from_url($url);
}

/**
 * Devuelve IDs disponibles para esas fechas+huéspedes.
 * Cachea el listado para paginar correctamente.
 *
 * Fallback:
 * - Si ICNEA falla "demasiado", devolvemos null (para no filtrar).
 */
function gls_icnea_get_available_post_ids($arrival, $departure, $guests = 2, $lang = 'es') {
  $arrival   = gls_icnea_normalize_date($arrival);
  $departure = gls_icnea_normalize_date($departure);
  $guests    = max(1, (int) $guests);

  if (!$arrival || !$departure) return null;

  $nights = gls_icnea_nights($arrival, $departure);
  if ($nights < 2) {
    // tu regla: minimum stay 2 (y en ICNEA viene minimum_stay=2)
    return []; // fuerza "0 resultados"
  }

  $list_key = 'gls_icnea_available_' . md5($arrival . '|' . $departure . '|' . $guests . '|' . $lang);
  $cached = get_transient($list_key);
  if (is_array($cached)) return $cached;

  // Sacamos todos los apartamentos (IDs) en el orden que tú quieras mantener.
  // Aquí uso menu_order + date como criterio estable.
  $all = new WP_Query([
    'post_type' => 'apartamentos',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'orderby' => ['menu_order' => 'ASC', 'date' => 'DESC'],
    'no_found_rows' => true,
  ]);

  $available_ids = [];
  $errors = 0;

  foreach ($all->posts as $post_id) {
    // Primero intenta el campo técnico dedicado; fallback a extracción desde URL.
    $icnea_id = gls_icnea_get_id_for_post($post_id);
    if (!$icnea_id) continue;

    $dr = gls_icnea_daily_rates($icnea_id, $arrival, $departure, $guests, $lang);

    if (is_wp_error($dr)) {
      $errors++;
      // Si falla demasiado, no filtramos para no romper UX
      if ($errors >= 3) {
        delete_transient($list_key);
        return null;
      }
      continue;
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
 */
function gls_icnea_get_query_var($keys) {
  $keys = (array) $keys;

  foreach ($keys as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
      return sanitize_text_field(wp_unslash($_GET[$key]));
    }
  }

  return '';
}

/**
 * Normaliza los parámetros del buscador para aceptar ambas nomenclaturas:
 * - arrival / departure
 * - checkin / checkout
 */
function gls_icnea_get_search_args_from_request() {
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
