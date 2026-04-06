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
 * Template args (via get_template_part $args):
 *   prefix  – string  ACF field prefix (default: 'gls_split')
 *   layout  – string  'image-right' (default) | 'image-left'
 *             Overrides the ACF image-position field when provided.
 *
 * ACF fields used (all optional, resolved via $prefix):
 *   {prefix}_eyebrow          – text   (small label above H2)
 *   {prefix}_title            – text   (H2 heading)
 *   {prefix}_text             – textarea (body paragraph)
 *   {prefix}_link_primary     – link   (primary CTA, uses .btn-fix)
 *   {prefix}_link_secondary   – link   (secondary CTA, uses .btn-fix-outline)
 *   {prefix}_image            – image  (array with 'url' and 'alt')
 *   {prefix}_bg_variant       – select ('' | 'light' | 'dark')
 *   {prefix}_image_position   – select ('right' | 'left')
 */

/* ---- Template args ---- */
$args   = $args ?? [];
$prefix = isset( $args['prefix'] ) ? sanitize_key( $args['prefix'] ) : 'gls_split';

/* ---- ACF fields with safe fallbacks ---- */
$eyebrow    = get_field( $prefix . '_eyebrow' )        ?: __( 'Luxury Experience', 'gls-backup' );
$title      = get_field( $prefix . '_title' )          ?: __( 'Discover Granada Luxury Suites', 'gls-backup' );
$text       = get_field( $prefix . '_text' )           ?: __( 'Experience the finest accommodations in the heart of Granada. Our suites blend contemporary design with Andalusian heritage, offering an unparalleled stay in one of Spain\'s most captivating cities.', 'gls-backup' );
$link_prim  = get_field( $prefix . '_link_primary' );
$link_sec   = get_field( $prefix . '_link_secondary' );
$image      = get_field( $prefix . '_image' );
$bg_variant = get_field( $prefix . '_bg_variant' )     ?: '';
$acf_pos    = get_field( $prefix . '_image_position' ) ?: '';

/* ---- Layout: $args['layout'] overrides ACF field ---- */
$layout_arg = isset( $args['layout'] ) ? $args['layout'] : '';
if ( $layout_arg === 'image-left' ) {
    $img_pos = 'left';
} elseif ( $layout_arg === 'image-right' ) {
    $img_pos = 'right';
} else {
    $img_pos = ( $acf_pos === 'left' ) ? 'left' : 'right';
}

/* ---- Image ---- */
$img_url = '';
$img_alt = '';
if ( is_array( $image ) && ! empty( $image['url'] ) ) {
    $img_url = esc_url( $image['url'] );
    $img_alt = esc_attr( $image['alt'] ?? '' );
} else {
    /* Fallback: placeholder image */
    $img_url = esc_url( get_stylesheet_directory_uri() . '/img/placeholder.jpg' );
    $img_alt = esc_attr__( 'Granada Luxury Suites', 'gls-backup' );
}

/* ---- CSS modifier classes ---- */
$section_classes = 'gls-split';
if ( $bg_variant ) {
    $section_classes .= ' gls-split--' . sanitize_html_class( $bg_variant );
}
if ( $img_pos === 'left' ) {
    $section_classes .= ' gls-split--img-left';
}
?>
<section class="<?php echo esc_attr( $section_classes ); ?>">

    <div class="gls-split__inner gls-container">

        <!-- Text column -->
        <div class="gls-split__content">

            <?php if ( $eyebrow ) : ?>
                <p class="gls-split__eyebrow">
                    <?php echo esc_html( $eyebrow ); ?>
                </p>
            <?php endif; ?>

            <h2 class="gls-split__title">
                <?php echo esc_html( $title ); ?>
            </h2>

            <?php if ( $text ) : ?>
                <p class="gls-split__text">
                    <?php echo wp_kses_post( $text ); ?>
                </p>
            <?php endif; ?>

            <?php if ( ! empty( $link_prim['url'] ) ) :
                $prim_target = ! empty( $link_prim['target'] ) ? ' target="' . esc_attr( $link_prim['target'] ) . '" rel="noopener"' : '';
            ?>
                <div class="gls-split__cta">
                    <a href="<?php echo esc_url( $link_prim['url'] ); ?>"
                       class="btn-fix"<?php echo $prim_target; ?>>
                        <?php echo esc_html( $link_prim['title'] ); ?>
                    </a>

                    <?php if ( ! empty( $link_sec['url'] ) ) :
                        $sec_target = ! empty( $link_sec['target'] ) ? ' target="' . esc_attr( $link_sec['target'] ) . '" rel="noopener"' : '';
                    ?>
                        <a href="<?php echo esc_url( $link_sec['url'] ); ?>"
                           class="btn-fix-outline"<?php echo $sec_target; ?>>
                            <?php echo esc_html( $link_sec['title'] ); ?>
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
