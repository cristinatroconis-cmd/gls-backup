<?php
/*
Template Name: Luxury Section Demo
Description: Demo page for the luxury section components (GLS – Phase 1 vertical slice).
             Shows: Page Hero + Intro Editorial + Split Section, all editable via ACF.
*/

get_header();
?>

<main class="site-main gls-luxury-demo">

    <?php
    /* 1. Page Hero (shared across non-home pages) */
    get_template_part('template-parts/gls-page-hero');

    /* 2. Intro Editorial Section */
    get_template_part('template-parts/gls-section-intro');

    /* 3. Luxury Split Section – default variant (image right) */
    get_template_part( 'template-parts/gls-section-split', null, [
        'layout' => 'image-right',
    ] );

    /* 3b. Luxury Split Section – reversed variant (image left, light background) */
    get_template_part( 'template-parts/gls-section-split', null, [
        'layout'     => 'image-left',
        'prefix'     => 'gls_split_b',
    ] );

    /* 4. Publics Slides – reads ACF from this page; shows fallback when ACF is empty */
    get_template_part( 'template-parts/home-publics-slides', null, [
        'object_id' => get_the_ID(),
        'fallback'  => [
            [
                'title'  => 'Para Propietarios',
                'text'   => '<p>Gestión integral de tu apartamento turístico: reservas, limpieza, mantenimiento y atención al huésped. Tú descansas, nosotros trabajamos.</p>',
                'button' => [ 'url' => '/propietarios/', 'title' => 'Soy propietario', 'target' => '_self' ],
            ],
            [
                'title'  => 'Para Viajeros',
                'text'   => '<p>Apartamentos de lujo en el corazón de Granada. Estancias únicas con el confort de un hotel y la libertad de tu propio espacio.</p>',
                'button' => [ 'url' => '/apartamentos/', 'title' => 'Ver apartamentos', 'target' => '_self' ],
            ],
        ],
    ] );
    ?>

</main><!-- /.site-main -->

<?php get_footer(); ?>
