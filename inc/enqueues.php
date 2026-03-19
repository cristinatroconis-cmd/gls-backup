<?php
/**
 * GLS – Enqueues
 * Centraliza la carga de estilos y scripts del tema hijo
 */

if (!defined('ABSPATH')) {
	exit;
}

/* =========================================================
   ENQUEUE STYLES
========================================================= */
function gls_styles() {

	wp_enqueue_style(
		'gls-components',
		get_stylesheet_directory_uri() . '/css/gls-components.css',
		[],
		file_exists(get_stylesheet_directory() . '/css/gls-components.css')
			? filemtime(get_stylesheet_directory() . '/css/gls-components.css')
			: null
	);

	wp_enqueue_style(
		'style',
		get_stylesheet_uri(),
		[],
		file_exists(get_stylesheet_directory() . '/style.css')
			? filemtime(get_stylesheet_directory() . '/style.css')
			: null
	);

	wp_enqueue_style(
		'slick_theme_style',
		get_stylesheet_directory_uri() . '/css/slick-theme.css',
		[],
		file_exists(get_stylesheet_directory() . '/css/slick-theme.css')
			? filemtime(get_stylesheet_directory() . '/css/slick-theme.css')
			: null
	);

	wp_enqueue_style(
		'slick_style',
		get_stylesheet_directory_uri() . '/css/slick.css',
		[],
		file_exists(get_stylesheet_directory() . '/css/slick.css')
			? filemtime(get_stylesheet_directory() . '/css/slick.css')
			: null
	);

	wp_enqueue_style(
		'open-sans',
		'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i',
		[],
		null
	);
}
add_action('wp_enqueue_scripts', 'gls_styles');


/* =========================================================
   ENQUEUE SCRIPTS
========================================================= */
function gls_scripts() {

	wp_enqueue_script('jquery');

	wp_enqueue_script(
		'slick_js',
		get_stylesheet_directory_uri() . '/js/slick.min.js',
		['jquery'],
		file_exists(get_stylesheet_directory() . '/js/slick.min.js')
			? filemtime(get_stylesheet_directory() . '/js/slick.min.js')
			: null,
		true
	);

	wp_enqueue_script(
		'scripts_js',
		get_stylesheet_directory_uri() . '/js/scripts.js',
		['jquery', 'slick_js', 'gls-litepicker-js'],
		file_exists(get_stylesheet_directory() . '/js/scripts.js')
			? filemtime(get_stylesheet_directory() . '/js/scripts.js')
			: null,
		true
	);

	wp_enqueue_script(
		'cookies_js',
		get_stylesheet_directory_uri() . '/js/coookiesv0.64.js',
		['jquery'],
		file_exists(get_stylesheet_directory() . '/js/coookiesv0.64.js')
			? filemtime(get_stylesheet_directory() . '/js/coookiesv0.64.js')
			: null,
		true
	);
}
add_action('wp_enqueue_scripts', 'gls_scripts');


/* =========================================================
   FLEXSLIDER (APARTAMENTOS)
========================================================= */
function gls_enqueue_flexslider() {
	/*
	wp_enqueue_style(
		'flexslider-css',
		get_stylesheet_directory_uri() . '/modules/css/flexslider.css'
	);

	wp_enqueue_script(
		'flexslider-js',
		get_stylesheet_directory_uri() . '/modules/js/jquery.flexslider-min.js',
		array('jquery'),
		null,
		true
	);
	*/
}
add_action('wp_enqueue_scripts', 'gls_enqueue_flexslider');


/* =========================================================
   GLS – Enqueue page-home.css
========================================================= */
function gls_enqueue_page_home_css() {

	$rel_path = '/css/page-home.css';
	$file     = get_stylesheet_directory() . $rel_path;
	$url      = get_stylesheet_directory_uri() . $rel_path;

	if (!file_exists($file)) {
		return;
	}

	wp_enqueue_style(
		'gls-page-home',
		$url,
		['style'],
		filemtime($file)
	);
}
add_action('wp_enqueue_scripts', 'gls_enqueue_page_home_css', 20);
add_action('elementor/frontend/after_enqueue_styles', 'gls_enqueue_page_home_css', 20);
add_action('elementor/editor/after_enqueue_styles', 'gls_enqueue_page_home_css', 20);
add_action('elementor/preview/enqueue_styles', 'gls_enqueue_page_home_css', 20);


/* ======================================================
   LITEPICKER – page-home-nueva.php
====================================================== */
function gls_enqueue_litepicker_home() {

	if (!is_page_template('page-home-nueva.php')) {
		return;
	}

	$theme_uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'gls-litepicker-css',
		$theme_uri . '/css/vendor/litepicker.css',
		[],
		file_exists(get_stylesheet_directory() . '/css/vendor/litepicker.css')
			? filemtime(get_stylesheet_directory() . '/css/vendor/litepicker.css')
			: '2.0.12'
	);

	wp_enqueue_script(
		'gls-litepicker-disable-css',
		$theme_uri . '/js/vendor/litepicker-disable-css.js',
		[],
		file_exists(get_stylesheet_directory() . '/js/vendor/litepicker-disable-css.js')
			? filemtime(get_stylesheet_directory() . '/js/vendor/litepicker-disable-css.js')
			: '1.0',
		true
	);

	wp_enqueue_script(
		'gls-litepicker-js',
		$theme_uri . '/js/vendor/litepicker.js',
		[],
		file_exists(get_stylesheet_directory() . '/js/vendor/litepicker.js')
			? filemtime(get_stylesheet_directory() . '/js/vendor/litepicker.js')
			: '2.0.12',
		true
	);
}
add_action('wp_enqueue_scripts', 'gls_enqueue_litepicker_home', 30);


/* =====================================================
   ENQUEUE ARCHIVE APARTAMENTOS CSS
===================================================== */
function gls_enqueue_archive_apartamentos_css() {

	if (!is_post_type_archive('apartamentos')) {
		return;
	}

	$file = get_stylesheet_directory() . '/css/archive-apartamentos.css';

	if (!file_exists($file)) {
		return;
	}

	wp_enqueue_style(
		'gls-archive-apartamentos',
		get_stylesheet_directory_uri() . '/css/archive-apartamentos.css',
		[],
		filemtime($file)
	);
}
add_action('wp_enqueue_scripts', 'gls_enqueue_archive_apartamentos_css');
