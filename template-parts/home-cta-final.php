<?php
/**
 * Template Part: Home CTA Final
 * Proyecto: Granada Luxury Suites
 * Fecha: 18/02/2026
 */

$cta_title     = get_field('cta_title');
$cta_subtitle  = get_field('cta_subtitle');
$cta_primary   = get_field('cta_button_primary');
$cta_secondary = get_field('cta_button_secondary');

?>

<section class="gls-cta">

    <div class="gls-cta__container">

        <?php if($cta_title): ?>
            <h2 class="gls-cta__title">
                <?php echo esc_html($cta_title); ?>
            </h2>
        <?php endif; ?>

        <?php if($cta_subtitle): ?>
            <div class="gls-cta__subtitle">
                <?php echo esc_html($cta_subtitle); ?>
            </div>
        <?php endif; ?>

        <?php if($cta_primary || $cta_secondary): ?>
            <div class="gls-cta__buttons">

                <?php if($cta_primary): ?>
                    <a href="<?php echo esc_url($cta_primary['url']); ?>"
                       class="gls-cta__btn gls-cta__btn--primary"
                       target="<?php echo esc_attr($cta_primary['target']); ?>">
                        <?php echo esc_html($cta_primary['title']); ?>
                    </a>
                <?php endif; ?>

                <?php if($cta_secondary): ?>
                    <a href="<?php echo esc_url($cta_secondary['url']); ?>"
                       class="gls-cta__btn gls-cta__btn--secondary"
                       target="<?php echo esc_attr($cta_secondary['target']); ?>">
                        <?php echo esc_html($cta_secondary['title']); ?>
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

</section>
