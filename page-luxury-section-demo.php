<?php
/*
Template Name: Luxury Section Demo
Description: Demo page for the luxury split section component (GLS – Phase 1 vertical slice).
             Shows: Page Hero + Split Section, both editable via ACF.
*/

get_header();
?>

<main class="site-main gls-luxury-demo">

    <?php
    /* 1. Page Hero (shared across non-home pages) */
    get_template_part('template-parts/gls-page-hero');

    /* 2. Luxury Split Section */
    get_template_part('template-parts/gls-section-split');
    ?>

</main><!-- /.site-main -->

<?php get_footer(); ?>
