<?php
/*
Template Name: Home Nueva Fase 1
Description: Template exclusivo para la página "Home - Nueva (Fase 1)"
Fecha: 19-02-2026
*/

get_header();
?>

<main class="site-main gls-home-nueva">

    <?php
    /*
    ======================================================
    HOME – FASE 1 (MODULAR ACF)
    Orden estratégico:
    1. Hero
    2. Intro Marca
    3. Públicos (Slider)
    4. Experiencias
    5. Modalidades
    6. CTA Final
    ======================================================
    */

    get_template_part('template-parts/home-hero');
    get_template_part('template-parts/home-intro-marca');
    get_template_part('template-parts/home-publics-slides');
    get_template_part('template-parts/home-experiencias');
    get_template_part('template-parts/home-modalidades');
    get_template_part('template-parts/gls-section-stack-cta');
    ?>

</main>

<?php
get_footer();
