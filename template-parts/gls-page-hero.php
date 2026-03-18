<?php
/**
 * GLS – Page Hero (except Home)
 * Template Part: gls-page-hero.php
 */

// Defaults (páginas normales)
$imagen    = get_field('gls_hero_imagen');
$titulo    = get_field('gls_hero_titulo');
$subtitulo = get_field('gls_hero_subtitulo');

// ✅ ARCHIVE APARTAMENTOS → siempre Options
if ( is_post_type_archive('apartamentos') ) {
  $imagen    = get_field('cabecera_apartamentos', 'option');
  $titulo    = get_field('titulo_apartamentos', 'option');
  $subtitulo = get_field('subtitulo_apartamentos', 'option');
}

// ✅ ARCHIVE EXPERIENCIAS → Options (si ya los creaste)
if ( is_post_type_archive('experiencias') ) {
  $imagen    = get_field('cabecera_experiencias', 'option');
  $titulo    = get_field('titulo_experiencias', 'option');
  $subtitulo = get_field('subtitulo_experiencias', 'option');
}

// Fallback legacy (por si usabas "titulooculto" antes)
if ( !$titulo ) {
    $titulooculto = get_field('titulooculto');
    $titulo = $titulooculto ? $titulooculto : get_the_title();
}

// Background (si no hay imagen, no ponemos inline style)
$background_url = '';
if ( is_array($imagen) && !empty($imagen['url']) ) {
    $background_url = esc_url($imagen['url']);
}

$style_attr = $background_url ? 'style="background-image:url(' . $background_url . ');"' : '';
?>
<section class="gls-page-hero" <?php echo $style_attr; ?>>

    <div class="gls-page-hero__overlay"></div>

    <div class="gls-page-hero__inner container">

        <div class="gls-page-hero__content">

            <h1 class="gls-page-hero__title">
                <?php echo esc_html($titulo); ?>
            </h1>

            <?php if ( $subtitulo ) : ?>
                <p class="gls-page-hero__subtitle">
                    <?php echo esc_html($subtitulo); ?>
                </p>
            <?php endif; ?>

        </div>

    </div>

</section>