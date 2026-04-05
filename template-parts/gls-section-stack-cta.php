<?php
/**
 * GLS – Section Stack CTA
 * Template Part: gls-section-stack-cta.php
 *
 * Renders a horizontal "stack header" section:
 *   – H2 title on the left (supports line breaks via ACF textarea).
 *   – Group of 3 secondary-style CTA buttons on the right.
 *
 * Falls back to example content so the section renders immediately
 * in local/dev even without saved ACF values.
 *
 * ACF fields (all optional — fallbacks applied when empty):
 *   gls_stack_title   – textarea  (H2; use line breaks to split lines)
 *   gls_stack_cta_1   – link      (url / title / target)
 *   gls_stack_cta_2   – link
 *   gls_stack_cta_3   – link
 */

/* ---- ACF fields with safe fallbacks ---- */
$title = function_exists( 'get_field' ) ? get_field( 'gls_stack_title' ) : '';
$title = $title ?: __( 'Descubre Granada Luxury Suites', 'gls-backup' );

$cta_1 = function_exists( 'get_field' ) ? get_field( 'gls_stack_cta_1' ) : [];
$cta_2 = function_exists( 'get_field' ) ? get_field( 'gls_stack_cta_2' ) : [];
$cta_3 = function_exists( 'get_field' ) ? get_field( 'gls_stack_cta_3' ) : [];

if ( empty( $cta_1 ) ) {
	$cta_1 = [ 'url' => '#', 'title' => __( 'turístico', 'gls-backup' ), 'target' => '' ];
}
if ( empty( $cta_2 ) ) {
	$cta_2 = [ 'url' => '#', 'title' => __( 'empresas', 'gls-backup' ), 'target' => '' ];
}
if ( empty( $cta_3 ) ) {
	$cta_3 = [ 'url' => '#', 'title' => __( 'propietarios', 'gls-backup' ), 'target' => '' ];
}

$buttons = [ $cta_1, $cta_2, $cta_3 ];

/**
 * Render one secondary CTA button.
 *
 * @param array $link  ACF link array with url / title / target.
 */
if ( ! function_exists( 'gls_stack_cta_button' ) ) {
	function gls_stack_cta_button( array $link ) {
		$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : '';
		printf(
			'<a href="%s" class="btn-fix-outline"%s>%s</a>',
			esc_url( $link['url'] ),
			$target,
			esc_html( $link['title'] )
		);
	}
}
?>
<section class="gls-stack-cta">

	<div class="gls-stack-cta__inner gls-container">

		<h2 class="gls-stack-cta__title">
			<?php echo wp_kses( nl2br( $title ), [ 'br' => [] ] ); ?>
		</h2>

		<div class="gls-stack-cta__cta-group">
			<?php foreach ( $buttons as $btn ) : ?>
				<?php gls_stack_cta_button( $btn ); ?>
			<?php endforeach; ?>
		</div><!-- /.gls-stack-cta__cta-group -->

	</div><!-- /.gls-stack-cta__inner -->

</section><!-- /.gls-stack-cta -->
