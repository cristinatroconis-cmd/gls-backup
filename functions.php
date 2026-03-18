<?php
/**
 * Granada Luxury Suites - Theme functions (limpio)
 */

/* =========================================================
   EXCERPT
========================================================= */
function gls_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'gls_excerpt_more');

function gls_custom_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'gls_custom_excerpt_length', 999);


/* =========================================================
   ENQUEUE STYLES
========================================================= */
function gls_styles() {
	
	wp_enqueue_style('gls-components', get_stylesheet_directory_uri() . '/css/gls-components.css', [], null);
	
    wp_enqueue_style('style', get_stylesheet_uri(), [], null);

    wp_enqueue_style(
        'slick_theme_style',
        get_stylesheet_directory_uri() . '/css/slick-theme.css',
        [],
        null
    );

    wp_enqueue_style(
        'slick_style',
        get_stylesheet_directory_uri() . '/css/slick.css',
        [],
        null
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
   ENQUEUE SCRIPTS (IMPORTANTE: dependencias)
   - scripts.js usa jQuery
   - slick requiere jQuery
========================================================= */
function gls_scripts() {
    // Asegura jQuery (WordPress lo trae)
    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'slick_js',
        get_stylesheet_directory_uri() . '/js/slick.min.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'scripts_js',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        ['jquery', 'slick_js', 'gls-litepicker-js'],
        null,
        true
    );

    wp_enqueue_script(
        'cookies_js',
        get_stylesheet_directory_uri() . '/js/coookiesv0.64.js',
        ['jquery'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'gls_scripts');


/* =========================================================
   BOTÓN "SUBIR"
========================================================= */
function gls_add_scroll_button() {
    echo '<a href="#" id="topbutton"><i class="icon icon-ic-arrow-up"></i></a>';
}
add_action('wp_footer', 'gls_add_scroll_button');


/* =========================================================
   MENÚS (DESKTOP + OVERLAY)
========================================================= */
function gls_register_menus() {
    register_nav_menus([
        'menu-1'       => __('Menú Superior (Menú de la cabecera)', 'identofmk'),
        'menu-overlay' => __('Menú Overlay (Hamburguesa)', 'identofmk'),
    ]);
}
add_action('after_setup_theme', 'gls_register_menus');


/**
 * Nota:
 * - Ya estás hardcodeando el menú horizontal en header.php (ul manual),
 *   así que NO fuerzo clases globales aquí para no pisar el overlay.
 * - Si luego vuelves a wp_nav_menu para desktop, lo controlamos desde el template.
 */


/* =========================================================
   CATEGORÍA DE BLOQUES (WP moderno)
========================================================= */
function gls_block_category_all($categories, $post) {
    $custom = [
        [
            'slug'  => 'identoblocks',
            'title' => __('Bloques de Idento', 'identoblocks'),
            'icon'  => 'dashicons-images-alt2',
        ],
    ];
    return array_merge($custom, $categories);
}
add_filter('block_categories_all', 'gls_block_category_all', 10, 2);

// Fallback para WP antiguos
function gls_block_category_legacy($categories, $post) {
    return gls_block_category_all($categories, $post);
}
add_filter('block_categories', 'gls_block_category_legacy', 10, 2);


/* =========================================================
   ACF BLOCKS
========================================================= */
function my_acf_init_block_types() {
    if (!function_exists('acf_register_block_type')) return;

    acf_register_block_type([
        'name'            => 'cabecera-home',
        'title'           => __('Cabecera Home'),
        'description'     => __('Cabecera con puntos fuertes'),
        'render_template' => 'bloques/cabecera-home.php',
        'category'        => 'identoblocks',
        'icon'            => 'embed-photo',
    ]);

    acf_register_block_type([
        'name'            => 'puntos-fuertes',
        'title'           => __('Valores'),
        'description'     => __('Cajas con valores'),
        'render_template' => 'bloques/puntos-fuertes.php',
        'category'        => 'identoblocks',
        'icon'            => 'embed-photo',
    ]);

    acf_register_block_type([
        'name'            => 'puntos-fuertes2',
        'title'           => __('Valores2'),
        'description'     => __('Cajas con valores'),
        'render_template' => 'bloques/puntos-fuertes2.php',
        'category'        => 'identoblocks',
        'icon'            => 'embed-photo',
    ]);

    acf_register_block_type([
        'name'            => 'slider',
        'title'           => __('Slider'),
        'description'     => __('Slider'),
        'render_template' => 'bloques/slider.php',
        'category'        => 'identoblocks',
        'icon'            => 'slides',
    ]);

    acf_register_block_type([
        'name'            => 'productos',
        'title'           => __('Listado de productos'),
        'description'     => __('Listado de productos'),
        'render_template' => 'bloques/productos.php',
        'category'        => 'identoblocks',
        'icon'            => 'screenoptions',
    ]);

    acf_register_block_type([
        'name'            => 'banner-datos',
        'title'           => __('Banner con datos'),
        'description'     => __('Banner con datos'),
        'render_template' => 'bloques/banner-datos.php',
        'category'        => 'identoblocks',
        'icon'            => 'chart-area',
    ]);

    acf_register_block_type([
        'name'            => 'proceso',
        'title'           => __('Proceso'),
        'description'     => __('Proceso con pasos e imagen'),
        'render_template' => 'bloques/proceso.php',
        'category'        => 'identoblocks',
        'icon'            => 'menu-alt3',
    ]);

    acf_register_block_type([
        'name'            => 'texto-imagen',
        'title'           => __('Texto con imagen'),
        'description'     => __('Texto con imagen'),
        'render_template' => 'bloques/texto-imagen.php',
        'category'        => 'identoblocks',
        'icon'            => 'align-pull-right',
    ]);

    acf_register_block_type([
        'name'            => 'contacto',
        'title'           => __('Contacto'),
        'description'     => __('Formulario con texto de acompañamiento'),
        'render_template' => 'bloques/contacto.php',
        'category'        => 'identoblocks',
        'icon'            => 'welcome-widgets-menus',
    ]);

    acf_register_block_type([
        'name'            => 'noticias',
        'title'           => __('Últimas entradas del blog'),
        'description'     => __('Mostrar las últimas entradas del blog'),
        'render_template' => 'bloques/noticias.php',
        'category'        => 'identoblocks',
        'icon'            => 'excerpt-view',
    ]);

    acf_register_block_type([
        'name'            => 'faq',
        'title'           => __('Preguntas frecuentes'),
        'description'     => __('Mostrar un bloque con las preguntas frecuentes'),
        'render_template' => 'bloques/faq.php',
        'category'        => 'identoblocks',
        'icon'            => 'testimonial',
    ]);

    acf_register_block_type([
        'name'            => 'blog',
        'title'           => __('Feed de entradas'),
        'description'     => __('Mostrar todas las entradas con filtro lateral'),
        'render_template' => 'bloques/blog.php',
        'category'        => 'identoblocks',
        'icon'            => 'testimonial',
    ]);

    acf_register_block_type([
        'name'            => 'wising',
        'title'           => __('Bloque de contenido'),
        'description'     => __('Introducir contenido en la página'),
        'render_template' => 'bloques/wising.php',
        'category'        => 'identoblocks',
        'icon'            => 'media-document',
    ]);

    acf_register_block_type([
        'name'            => 'seleccionados',
        'title'           => __('Productos seleccionados'),
        'description'     => __('Selección de productos'),
        'render_template' => 'bloques/productos-seleccionados.php',
        'category'        => 'identoblocks',
        'icon'            => 'media-document',
    ]);

    acf_register_block_type([
        'name'            => 'tabs-hor',
        'title'           => __('Tabs horizontales'),
        'description'     => __('Bloques con Tabs de Boostrap horizontales'),
        'render_template' => 'bloques/tabs-hor.php',
        'category'        => 'identoblocks',
        'icon'            => 'table-row-after',
    ]);

    acf_register_block_type([
        'name'            => 'texto-imagen-repeater',
        'title'           => __('Texto con imagen con repeater'),
        'description'     => __('Texto con imagen con repeater y alternando entre imagen y texto'),
        'render_template' => 'bloques/texto-imagen-repeater.php',
        'category'        => 'identoblocks',
        'icon'            => 'controls-repeat',
    ]);

    acf_register_block_type([
        'name'            => 'testimonios',
        'title'           => __('Testimonios'),
        'description'     => __('Muestra los testimonios previamente añadidos desde Options'),
        'render_template' => 'bloques/testimonios.php',
        'category'        => 'identoblocks',
        'icon'            => 'format-status',
    ]);

    acf_register_block_type([
        'name'            => 'varias-columnas',
        'title'           => __('Contenido en varias columnas'),
        'description'     => __('Bloque para añadir contenido con varias columnas'),
        'render_template' => 'bloques/varias-columnas.php',
        'category'        => 'identoblocks',
        'icon'            => 'media-spreadsheet',
    ]);

    acf_register_block_type([
        'name'            => 'Equipo',
        'title'           => __('Bloque con todo el equipo'),
        'description'     => __('Bloque con todo el equipo'),
        'render_template' => 'bloques/equipo.php',
        'category'        => 'identoblocks',
        'icon'            => 'admin-users',
    ]);

    acf_register_block_type([
        'name'            => 'cabecera',
        'title'           => __('Cabecera'),
        'description'     => __('Cabecera para las páginas. No usar en home.'),
        'render_template' => 'bloques/cabecera.php',
        'category'        => 'identoblocks',
        'icon'            => 'reddit',
    ]);

    acf_register_block_type([
        'name'            => 'banner-slider',
        'title'           => __('Contenido con diapositivas'),
        'description'     => __('Bloque para añadir contenido en varias diapositivas'),
        'render_template' => 'bloques/banner-slider.php',
        'category'        => 'identoblocks',
        'icon'            => 'editor-insertmore',
    ]);

    acf_register_block_type([
        'name'            => 'servicios',
        'title'           => __('Bloque que muestra todos los servicios'),
        'description'     => __('Bloque para añadir servicios en varias columnas'),
        'render_template' => 'bloques/servicios.php',
        'category'        => 'identoblocks',
        'icon'            => 'star-filled',
    ]);

    acf_register_block_type([
        'name'            => 'boton_cta',
        'title'           => __('Botón'),
        'description'     => __('Bloque que añade un botón'),
        'render_template' => 'bloques/boton_cta.php',
        'category'        => 'identoblocks',
        'icon'            => 'admin-links',
    ]);
}
add_action('acf/init', 'my_acf_init_block_types');


/* =========================================================
   CPTs
========================================================= */
function custom_post_type_idento() {
    // Apartamentos
    $labels = [
        'name'          => _x('Apartamentos', 'Post Type General Name', 'identofmk'),
        'singular_name' => _x('Apartamento', 'Post Type Singular Name', 'identofmk'),
        'menu_name'     => __('Apartamentos', 'identofmk'),
    ];
    $args = [
        'label'               => __('Apartamentos', 'identofmk'),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['post_tag', 'category'],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-admin-home',
        'menu_position'       => 21,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    ];
    register_post_type('apartamentos', $args);

    // Alquiler Temporada
    $labels = [
        'name'          => _x('Alquiler Temporada', 'Post Type General Name', 'identofmk'),
        'singular_name' => _x('Alquiler Temporada', 'Post Type Singular Name', 'identofmk'),
        'menu_name'     => __('Alquiler Temporada', 'identofmk'),
    ];
    $args = [
        'label'               => __('Alquiler Temporada', 'identofmk'),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['post_tag', 'category'],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-admin-home',
        'menu_position'       => 23,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    ];
    register_post_type('alquiler-temporada', $args);

    // Experiencias
    $labels = [
        'name'          => _x('Experiencias', 'Post Type General Name', 'identofmk'),
        'singular_name' => _x('Experiencia', 'Post Type Singular Name', 'identofmk'),
        'menu_name'     => __('Experiencias', 'identofmk'),
    ];
    $args = [
        'label'               => __('Experiencias', 'identofmk'),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['post_tag', 'category'],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-admin-comments',
        'menu_position'       => 22,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    ];
    register_post_type('experiencias', $args);
}
add_action('init', 'custom_post_type_idento', 0);


/* =========================================================
   PAGINACIÓN CPT ARCHIVE
========================================================= */
function custom_post_type_pagination($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_post_type_archive('apartamentos') || is_tax('tu_taxonomy')) {
            $query->set('posts_per_page', 10);
            $query->set('paged', get_query_var('paged'));
        }
    }
}
add_action('pre_get_posts', 'custom_post_type_pagination');

function custom_post_type_pagination_links() {
    global $wp_query;
    $big = 999999999;

    echo paginate_links([
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<i class="fa-solid fa-angle-left"></i>',
        'next_text' => '<i class="fa-solid fa-angle-right"></i>',
    ]);
}


/* =========================================================
   ACF OPTIONS
========================================================= */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title'  => 'Opciones del Tema',
        'menu_title'  => 'Opciones del Tema',
        'menu_slug'   => 'opciones-tema',
        'capability'  => 'manage_options',
        'redirect'    => false,
    ]);
}

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
   GLS – Enqueue page-home.css (Home + Elementor Editor + Preview)
   Fecha: 09/02/2026
   ========================================================= */

function gls_enqueue_page_home_css() {

    $rel_path = '/css/page-home.css';
    $file     = get_stylesheet_directory() . $rel_path;
    $url      = get_stylesheet_directory_uri() . $rel_path;

    // Seguridad: si el archivo no existe, no hacemos nada
    if (!file_exists($file)) {
        return;
    }

    wp_enqueue_style(
        'gls-page-home',
        $url,
        array('style'),
        filemtime($file)
    );
}

/* 
 * Hooks necesarios para cubrir TODOS los contextos:
 * - Frontend normal
 * - Elementor editor
 * - Elementor preview
 * - Customizer
 */
add_action('wp_enqueue_scripts', 'gls_enqueue_page_home_css', 20);
add_action('elementor/frontend/after_enqueue_styles', 'gls_enqueue_page_home_css', 20);
add_action('elementor/editor/after_enqueue_styles', 'gls_enqueue_page_home_css', 20);
add_action('elementor/preview/enqueue_styles', 'gls_enqueue_page_home_css', 20);

/* ======================================================
   LITEPICKER – CALENDARIO BUSCADOR HOME
   Fecha: 24/02/2026
   Contexto: page-home-nueva.php
   ====================================================== */

function gls_enqueue_litepicker_home() {

    if ( ! is_page_template('page-home-nueva.php') ) {
        return;
    }

    $theme_uri = get_stylesheet_directory_uri();

    // CSS vendor
    wp_enqueue_style(
        'gls-litepicker-css',
        $theme_uri . '/css/vendor/litepicker.css',
        array(),
        '2.0.12'
    );

    // Flag para bloquear CSS inyectado
    wp_enqueue_script(
        'gls-litepicker-disable-css',
        $theme_uri . '/js/vendor/litepicker-disable-css.js',
        array(),
        '1.0',
        true
    );

    // Litepicker JS
    wp_enqueue_script(
        'gls-litepicker-js',
        $theme_uri . '/js/vendor/litepicker.js',
        array(),
        '2.0.12',
        true
    );

}
add_action('wp_enqueue_scripts', 'gls_enqueue_litepicker_home', 30);

/* =====================================================
   ENQUEUE ARCHIVE APARTAMENTOS CSS
   Fecha: 13-02-2026
   Objetivo:
   - Cargar CSS solo en el CPT apartamentos
   - Evitar sobrecarga global
   - Mantener arquitectura limpia
   ===================================================== */

function gls_enqueue_archive_apartamentos_css() {

    if ( is_post_type_archive('apartamentos') ) {

        wp_enqueue_style(
            'gls-archive-apartamentos',
            get_stylesheet_directory_uri() . '/css/archive-apartamentos.css',
            array(),
            filemtime( get_stylesheet_directory() . '/css/archive-apartamentos.css' )
        );

    }

}
add_action('wp_enqueue_scripts', 'gls_enqueue_archive_apartamentos_css');

/* =====================================================
   ICNEA – Availability helpers
   ===================================================== */

require_once get_stylesheet_directory() . '/inc/gls-icnea.php';
require_once get_stylesheet_directory() . '/inc/acf-json.php';
