<?php
/**
 * GLS – Section Split (Luxury)
 * Template Part: gls-section-split.php
 *
 * Renders a 2-column luxury split section.
 * Reads ACF fields from the current page; falls back to example
 * content so the section renders immediately in local/dev even
 * without saved values.
 *
 * ACF fields used (all optional):
 *   gls_split_eyebrow          – text   (small label above H2)
 *   gls_split_title            – text   (H2 heading)
 *   gls_split_text             – textarea (body paragraph)
 *   gls_split_link_primary     – link   (primary CTA, uses .btn-fix)
 *   gls_split_link_secondary   – link   (secondary link, uses .btn-fix-outline)
 *   gls_split_image            – image  (array with 'url' and 'alt')
 *   gls_split_bg_variant       – select ('' | 'light' | 'dark')
 *   gls_split_image_position   – select ('right' | 'left')
 */

/* ---- ACF fields with safe fallbacks ---- */
$eyebrow     = get_field('gls_split_eyebrow')       ?: __('Luxury Experience', 'gls-backup');
$title       = get_field('gls_split_title')         ?: __('Discover Granada Luxury Suites', 'gls-backup');
$text        = get_field('gls_split_text')          ?: __('Experience the finest accommodations in the heart of Granada. Our suites blend contemporary design with Andalusian heritage, offering an unparalleled stay in one of Spain\'s most captivating cities.', 'gls-backup');
$link_prim   = get_field('gls_split_link_primary');
$link_sec    = get_field('gls_split_link_secondary');
$image       = get_field('gls_split_image');
$bg_variant  = get_field('gls_split_bg_variant')    ?: '';
$img_pos     = get_field('gls_split_image_position') ?: 'right';

/* ---- Fallback primary link ---- */
if ( empty($link_prim) ) {
    $link_prim = [
        'url'    => get_permalink(),
        'title'  => __('Explore More', 'gls-backup'),
        'target' => '',
    ];
}

/* ---- Image ---- */
$img_url = '';
$img_alt = '';
if ( is_array($image) && !empty($image['url']) ) {
    $img_url = esc_url($image['url']);
    $img_alt = esc_attr($image['alt'] ?? '');
} else {
    /* Fallback: placeholder image */
    $img_url = esc_url(get_stylesheet_directory_uri() . '/img/gls-split-placeholder.jpg');
    $img_alt = esc_attr__('Granada Luxury Suites', 'gls-backup');
}

/* ---- CSS modifier classes ---- */
$section_classes = 'gls-split';
if ( $bg_variant ) {
    $section_classes .= ' gls-split--' . sanitize_html_class($bg_variant);
}
if ( $img_pos === 'left' ) {
    $section_classes .= ' gls-split--img-left';
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">

    <div class="gls-split__inner gls-container">

        <!-- Text column -->
        <div class="gls-split__content">

            <?php if ( $eyebrow ) : ?>
                <p class="gls-split__eyebrow">
                    <?php echo esc_html($eyebrow); ?>
                </p>
            <?php endif; ?>

            <h2 class="gls-split__title">
                <?php echo esc_html($title); ?>
            </h2>

            <?php if ( $text ) : ?>
                <p class="gls-split__text">
                    <?php echo wp_kses_post($text); ?>
                </p>
            <?php endif; ?>

            <?php if ( !empty($link_prim['url']) ) :
                $prim_target = !empty($link_prim['target']) ? ' target="' . esc_attr($link_prim['target']) . '" rel="noopener"' : '';
            ?>
                <div class="gls-split__cta">
                    <a href="<?php echo esc_url($link_prim['url']); ?>"
                       class="btn-fix"<?php echo $prim_target; ?>>
                        <?php echo esc_html($link_prim['title']); ?>
                    </a>

                    <?php if ( !empty($link_sec['url']) ) :
                        $sec_target = !empty($link_sec['target']) ? ' target="' . esc_attr($link_sec['target']) . '" rel="noopener"' : '';
                    ?>
                        <a href="<?php echo esc_url($link_sec['url']); ?>"
                           class="btn-fix-outline"<?php echo $sec_target; ?>>
                            <?php echo esc_html($link_sec['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div><!-- /.gls-split__content -->

        <!-- Image column -->
        <div class="gls-split__media">
            <div class="gls-split__img-wrap">
                <img
                    src="<?php echo $img_url; ?>"
                    alt="<?php echo $img_alt; ?>"
                    class="gls-split__img"
                    loading="lazy"
                />
            </div>
        </div><!-- /.gls-split__media -->

    </div><!-- /.gls-split__inner -->

</section><!-- /.gls-split -->
