<?php
/**
 * GLS – Seed ACF (Solo en entorno dev/local)
 *
 * Autopuebla campos ACF con contenido de ejemplo en:
 *   - Options page "Experiencias (Página)" (prefix gls_exp_split_*)
 *   - Página "Propietarios" (slug propietarios, prefix gls_prop_split_*)
 *   - Página "Sobre Nosotros" (slug sobre-nosotros, prefix gls_sn_split_*)
 *
 * También crea las páginas si no existen y les asigna el template correcto.
 *
 * CONDICIÓN DE EJECUCIÓN:
 *   Solo cuando WP_DEBUG = true O GLS_SEED_ACF = true (ver functions.php).
 *   Usa un flag de WordPress (option) para no ejecutarse dos veces.
 *   Para forzar un nuevo seed, elimina la opción:
 *     delete_option( 'gls_seed_acf_done' );
 *
 * NO MODIFICA datos existentes si ya tienen contenido.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Registrar el hook de seed al arrancar WordPress.
 * Se ejecuta en 'init' para que ACF y WP estén completamente cargados.
 */
add_action( 'init', 'gls_seed_acf_run', 99 );

function gls_seed_acf_run() {

    // Evitar ejecución repetida (persiste entre peticiones)
    if ( get_option( 'gls_seed_acf_done' ) ) {
        return;
    }

    // Solo ejecutar si ACF está activo
    if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
        return;
    }

    // --------------------------------------------------------
    // 1) PÁGINA PROPIETARIOS
    // --------------------------------------------------------
    $prop_id = gls_seed_get_or_create_page(
        __( 'Propietarios', 'identofmk' ),
        'propietarios',
        'page-propietarios.php'
    );

    if ( $prop_id ) {
        gls_seed_fields( $prop_id, 'gls_prop_split', [
            'eyebrow'       => __( 'Para propietarios', 'identofmk' ),
            'titulo'        => __( 'Gestión Profesional de tu Propiedad', 'identofmk' ),
            'texto'         => __( 'En Granada Luxury Suites nos encargamos de todo: desde la gestión de reservas hasta el mantenimiento, para que tú solo disfrutes de tus ingresos con total tranquilidad.', 'identofmk' ),
            'btn_primary'   => [ 'title' => __( 'Más información', 'identofmk' ), 'url' => '#contacto', 'target' => '' ],
            'btn_secondary' => [ 'title' => __( 'Contáctanos',    'identofmk' ), 'url' => '#contacto', 'target' => '' ],
            'imagen'        => null,
            'bg'            => 'light',
        ] );
    }

    // --------------------------------------------------------
    // 2) PÁGINA SOBRE NOSOTROS
    // --------------------------------------------------------
    $sn_id = gls_seed_get_or_create_page(
        __( 'Sobre nosotros', 'identofmk' ),
        'sobre-nosotros',
        'page-sobre-nosotros.php'
    );

    if ( $sn_id ) {
        gls_seed_fields( $sn_id, 'gls_sn_split', [
            'eyebrow'       => __( 'Quiénes somos', 'identofmk' ),
            'titulo'        => __( 'Una experiencia única en Granada', 'identofmk' ),
            'texto'         => __( 'Granada Luxury Suites nació del deseo de ofrecer una alternativa diferente al alojamiento convencional. Apostamos por el lujo discreto, la atención personalizada y la conexión auténtica con el espíritu de Granada.', 'identofmk' ),
            'btn_primary'   => [ 'title' => __( 'Nuestras suites', 'identofmk' ), 'url' => '/apartamentos/', 'target' => '' ],
            'btn_secondary' => null,
            'imagen'        => null,
            'bg'            => 'accent',
        ] );
    }

    // --------------------------------------------------------
    // 3) OPTIONS PAGE – EXPERIENCIAS
    // --------------------------------------------------------
    gls_seed_fields( 'option', 'gls_exp_split', [
        'eyebrow'       => __( 'Descubre Granada', 'identofmk' ),
        'titulo'        => __( 'Experiencias que recordarás', 'identofmk' ),
        'texto'         => __( 'Desde rutas gastronómicas hasta visitas culturales únicas, diseñamos experiencias a medida para que tu estancia en Granada sea verdaderamente inolvidable.', 'identofmk' ),
        'btn_primary'   => null,
        'btn_secondary' => null,
        'imagen'        => null,
        'bg'            => 'accent',
    ] );

    // Marcar seed como ejecutado (no se repite)
    update_option( 'gls_seed_acf_done', true );
}

/**
 * Obtiene o crea una página por slug.
 * Si la página existe, se actualiza su template si aún no lo tiene asignado.
 * Nunca modifica páginas existentes de forma destructiva.
 *
 * @param  string $title    Título de la página.
 * @param  string $slug     Slug deseado.
 * @param  string $template Nombre del archivo de template (ej. page-propietarios.php).
 * @return int|null         Post ID o null en caso de error.
 */
function gls_seed_get_or_create_page( $title, $slug, $template ) {

    // Buscar por slug
    $existing = get_page_by_path( $slug, OBJECT, 'page' );

    if ( $existing ) {
        // Si ya existe pero no tiene template asignado, asignarlo
        $current_template = get_post_meta( $existing->ID, '_wp_page_template', true );
        if ( empty( $current_template ) || $current_template === 'default' ) {
            update_post_meta( $existing->ID, '_wp_page_template', $template );
        }
        return $existing->ID;
    }

    // Verificar que el template existe en el tema hijo
    $template_path = get_stylesheet_directory() . '/' . $template;
    if ( ! file_exists( $template_path ) ) {
        return null;
    }

    // Crear la página
    $page_id = wp_insert_post( [
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => get_current_user_id() ?: 1,
    ] );

    if ( is_wp_error( $page_id ) || ! $page_id ) {
        return null;
    }

    update_post_meta( $page_id, '_wp_page_template', $template );

    return $page_id;
}

/**
 * Rellena los campos ACF con los valores de seed.
 * Solo escribe si el campo está vacío (no sobrescribe datos reales del cliente).
 *
 * @param  int|string $object_id  Post ID o 'option'.
 * @param  string     $prefix     Prefijo de campos (ej. 'gls_prop_split').
 * @param  array      $data       Datos de seed indexados por sufijo de campo.
 */
function gls_seed_fields( $object_id, $prefix, $data ) {

    $suffix_map = [
        'eyebrow',
        'titulo',
        'texto',
        'btn_primary',
        'btn_secondary',
        'imagen',
        'bg',
    ];

    foreach ( $suffix_map as $suffix ) {
        if ( ! array_key_exists( $suffix, $data ) ) {
            continue;
        }

        $field_name  = $prefix . '_' . $suffix;
        $seed_value  = $data[ $suffix ];

        // No sobrescribir si ya hay contenido
        $current = get_field( $field_name, $object_id );
        if ( ! empty( $current ) ) {
            continue;
        }

        // No guardar valores null (campo opcional no rellenado en seed)
        if ( is_null( $seed_value ) ) {
            continue;
        }

        update_field( $field_name, $seed_value, $object_id );
    }
}
