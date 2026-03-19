<?php
/**
 * GLS – Migración temporal: poblar campo icnea_id desde boton_de_reserva.
 *
 * Uso: acceder como administrador a cualquier URL del WordPress con ?migrate_icnea_ids=1
 *
 * NOTA: Este archivo es temporal. Una vez completada la migración y verificado
 *       que todos los apartamentos tienen icnea_id, elimínalo y retira su
 *       require_once de functions.php.
 *
 * Seguridad:
 * - Solo se ejecuta si el usuario está autenticado como administrador.
 * - Se activa únicamente mediante el parámetro ?migrate_icnea_ids=1.
 * - No modifica posts que ya tengan icnea_id.
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('init', 'gls_maybe_run_icnea_migration');

function gls_maybe_run_icnea_migration() {
	// Solo cuando se solicita explícitamente y solo para admins.
	$param = isset($_GET['migrate_icnea_ids']) // phpcs:ignore WordPress.Security.NonceVerification
		? sanitize_key($_GET['migrate_icnea_ids']) // phpcs:ignore WordPress.Security.NonceVerification
		: '';

	if ('1' !== $param || !current_user_can('manage_options')) {
		return;
	}

	// Necesitamos ACF y la función extractora.
	if (!function_exists('get_field') || !function_exists('gls_icnea_extract_id_from_url')) {
		wp_die('Dependencias no cargadas (ACF o gls-icnea.php). Abortar.');
	}

	// Cabecera de diagnóstico (solo si los headers aún no se han enviado).
	if (!headers_sent()) {
		header('Content-Type: text/plain; charset=utf-8');
	}
	echo "=== GLS ICNEA ID Migration ===\n\n";

	// Obtener todos los apartamentos.
	$query = new WP_Query([
		'post_type'      => 'apartamentos',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	]);

	$posts    = $query->posts;
	$total    = count($posts);
	$migrated = 0;
	$skipped  = 0;
	$no_url   = 0;
	$no_id    = 0;

	echo "Posts encontrados: {$total}\n\n";

	foreach ($posts as $post_id) {
		$post_id = (int) $post_id;

		// No sobrescribir si ya tiene valor.
		$existing = get_field('icnea_id', $post_id);
		if (!empty($existing)) {
			echo "[SKIP]     Post {$post_id} — ya tiene icnea_id: " . esc_html((string) $existing) . "\n";
			$skipped++;
			continue;
		}

		// Leer URL del botón de reserva.
		$btn = get_field('boton_de_reserva', $post_id);
		$url = is_array($btn) ? ($btn['url'] ?? '') : (string) $btn;
		$url = trim($url);

		if (empty($url)) {
			echo "[NO_URL]   Post {$post_id} — sin URL en boton_de_reserva\n";
			$no_url++;
			continue;
		}

		// Extraer ID con regex (-h123).
		$icnea_id = gls_icnea_extract_id_from_url($url);

		if (!$icnea_id) {
			echo "[NO_ID]    Post {$post_id} — URL sin ID extraíble: " . esc_html($url) . "\n";
			$no_id++;
			continue;
		}

		// Guardar en el campo ACF técnico.
		update_field('icnea_id', $icnea_id, $post_id);

		echo "[MIGRATED] Post {$post_id} — icnea_id guardado: {$icnea_id}\n";
		$migrated++;
	}

	echo "\n=== Resumen ===\n";
	echo "Total:         {$total}\n";
	echo "Migrado:       {$migrated}\n";
	echo "Omitido:       {$skipped} (ya tenían valor)\n";
	echo "Sin URL:       {$no_url}\n";
	echo "Sin ID en URL: {$no_id}\n";
	echo "\nMigración completada.\n";

	exit;
}
