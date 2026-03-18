<?php
/**
 * ======================================================
 * HOME HERO
 * Proyecto: Granada Luxury Suites
 * Fecha: 24/02/2026
 * Objetivo:
 * - Hero estructural limpio
 * - Buscador integrado
 * - Sin dependencia de Elementor
 * ======================================================
 */

$bg        = get_field('hero_background');
$title1    = get_field('hero_title_line_1');
$title2    = get_field('hero_title_line_2');
$subtitle  = get_field('hero_subtitle');
$cta_text  = get_field('hero_cta_text');
$cta_link  = get_field('hero_cta_link');

$bg_url = !empty($bg['url']) ? esc_url($bg['url']) : '';
?>

<section class="home-hero"
    <?php if($bg_url): ?>
        style="background-image: url('<?php echo $bg_url; ?>');"
    <?php endif; ?>
>

    <div class="home-hero__overlay"></div>

    <div class="home-hero__inner container">

        <div class="home-hero__content">

            <?php if($title1): ?>
                <h1 class="home-hero__title">
                    <?php echo esc_html($title1); ?>
                </h1>
            <?php endif; ?>

            <?php if($title2): ?>
                <h2 class="home-hero__title home-hero__title--small">
                    <?php echo esc_html($title2); ?>
                </h2>
            <?php endif; ?>

            <?php if($subtitle): ?>
                <p class="home-hero__subtitle">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <!-- ======================================================
                 HOME SEARCH – HERO INTEGRADO
                 Fecha: 24/02/2026
            ====================================================== -->

            <div class="gls-home-search">

                <form id="gls-search-form">

                    <div class="gls-search-field">
                        <input 
                            type="text"
                            id="gls-dates"
                            placeholder="Check-in – Check-out"
                            readonly
                            required
                        >
                    </div>

                    <div class="gls-search-field">
                        <select id="gls-guests" required>
                            <option value="1">1 huésped</option>
                            <option value="2" selected>2 huéspedes</option>
                            <option value="3">3 huéspedes</option>
                            <option value="4">4 huéspedes</option>
                            <option value="5">5 huéspedes</option>
							<option value="6">6 huéspedes</option>
							<option value="7">7 huéspedes</option>
							<option value="8">8 huéspedes</option>
                        </select>
                    </div>

                    <button type="submit" id="gls-search-submit">
                        Consultar disponibilidad
                    </button>

                </form>

            </div>

            <?php if($cta_text && $cta_link): ?>
                <a href="<?php echo esc_url($cta_link); ?>" 
                   class="btn-primary">
                   <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>

        </div>

    </div>

</section>