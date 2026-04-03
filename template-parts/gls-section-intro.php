<?php
/**
 * GLS – Section Intro (Editorial)
 * Template Part: template-parts/gls-section-intro.php
 *
 * Renders a centered editorial intro section:
 * optional eyebrow + H2 headline + body text + optional divider line.
 * Reads ACF fields from the current page; falls back to example
 * content so the section renders immediately in local/dev even
 * without saved values.
 *
 * ACF fields used (all optional):
 *   gls_intro_eyebrow  – text     (small uppercase label)
 *   gls_intro_title    – text     (H2 heading, centered)
 *   gls_intro_text     – textarea (body paragraph)
 *   gls_intro_variant  – select   ('light' | 'accent' | 'dark')
 *   gls_intro_align    – select   ('center' | 'left')
 */

/* ---- ACF fields with safe fallbacks ---- */
$eyebrow = get_field('gls_intro_eyebrow') ?: __('Granada Luxury Suites', 'gls-backup');
$title   = get_field('gls_intro_title')   ?: __('Where History Meets Luxury', 'gls-backup');
$text    = get_field('gls_intro_text')    ?: __('Nestled in the heart of Granada, our suites offer a rare blend of Andalusian heritage and contemporary luxury. Every stay is crafted to be memorable – from the moment you arrive to the moment you leave.', 'gls-backup');
$variant = get_field('gls_intro_variant') ?: 'light';
$align   = get_field('gls_intro_align')   ?: 'center';

/* ---- CSS modifier classes ---- */
$section_classes = 'gls-intro';
if ( $variant ) {
    $section_classes .= ' gls-intro--' . sanitize_html_class($variant);
}
if ( $align ) {
    $section_classes .= ' gls-intro--' . sanitize_html_class($align);
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">

    <div class="gls-intro__inner gls-container">

        <?php if ( $eyebrow ) : ?>
            <p class="gls-intro__eyebrow">
                <?php echo esc_html($eyebrow); ?>
            </p>
        <?php endif; ?>

        <h2 class="gls-intro__title">
            <?php echo esc_html($title); ?>
        </h2>

        <div class="gls-intro__divider" aria-hidden="true"></div>

        <?php if ( $text ) : ?>
            <div class="gls-intro__text">
                <?php echo wp_kses_post(wpautop($text)); ?>
            </div>
        <?php endif; ?>

    </div><!-- /.gls-intro__inner -->

</section><!-- /.gls-intro -->
