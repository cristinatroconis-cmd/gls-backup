<?php

/**
 * Front Page – Granada Luxury Suites
 * Delegamos en page-home-nueva.php (home modular ACF)
 * para asegurar que la portada siempre use el diseño nuevo.
 */

$home_tpl = get_stylesheet_directory() . '/page-home-nueva.php';

if (file_exists($home_tpl)) {
    // page-home-nueva.php ya llama a get_header() y get_footer().
    include $home_tpl;
    return;
}

// Fallback seguro (si algún día falta el template)
get_header();
?>
<main class="site-main">
    <div class="site-content">
        <?php the_content(); ?>
    </div>
</main>
<?php
get_footer();
