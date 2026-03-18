<?php
/**
 * GLS – ACF JSON
 * Guarda y carga grupos ACF desde el child theme
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Ruta de guardado de JSON
 */
add_filter('acf/settings/save_json', function ($path) {
	return get_stylesheet_directory() . '/acf-json';
});

/**
 * Rutas de carga de JSON
 */
add_filter('acf/settings/load_json', function ($paths) {
	unset($paths[0]);
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
});
