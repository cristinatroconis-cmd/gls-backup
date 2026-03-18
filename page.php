<?php
get_header();

$titulooculto = get_field('titulooculto');
?>

<main class="container-fluid p-0">

    <?php
    /**
     * HERO GLS para páginas internas (no Home)
     * Si quieres que el hero use "titulooculto" cuando no haya gls_hero_titulo,
     * lo controlamos desde el template-part.
     */
    if ( !is_front_page() ) {
        get_template_part('template-parts/gls-page-hero');
    }
    ?>

    <div class="page-pred">

        <!-- Header viejo (lo dejamos por compatibilidad, pero sigue oculto) -->
        <header class="row header-box d-none">
            <div class="col-12">
                <?php if ( $titulooculto ) : ?>
                    <h1 class="text-center"><?php echo esc_html($titulooculto); ?></h1>
                <?php else : ?>
                    <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>

        <div class="row content-box">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>

    </div>

</main>

<?php get_footer(); ?>