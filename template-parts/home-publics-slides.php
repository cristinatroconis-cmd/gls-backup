<?php

/**
 * Template Part: Home Publics Slides
 * Proyecto: Granada Luxury Suites
 * Fecha: 18/02/2026
 *
 * Reusable: accepts $args via get_template_part( ..., null, $args ).
 *
 * @param string          $args['field']      ACF repeater field name. Default: 'publics_slides'.
 * @param int|string|false $args['object_id'] Post/page ID, 'option', or false for current post. Default: false.
 * @param array           $args['fallback']   Optional fallback slides shown only when ACF has no rows.
 *                                            Each slide: [ 'title', 'text', 'button' => ['url','title','target'], 'background' => ['url'] ]
 *
 * Usage from any page template:
 *   get_template_part( 'template-parts/home-publics-slides', null, [ 'object_id' => get_the_ID() ] );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$field     = isset( $args['field'] )     ? (string) $args['field']  : 'publics_slides';
$object_id = isset( $args['object_id'] ) ? $args['object_id']       : false;
$fallback  = ( isset( $args['fallback'] ) && is_array( $args['fallback'] ) ) ? $args['fallback'] : [];

/* ----------------------------------------------------------
   Check whether real ACF rows exist.
   have_rows() resets its internal pointer each time it is
   called outside a loop, so calling it here and then again
   in the while() below is the standard ACF pattern.
---------------------------------------------------------- */
$has_rows = false;
if ( function_exists( 'have_rows' ) ) {
	$has_rows = ( $object_id !== false )
		? have_rows( $field, $object_id )
		: have_rows( $field );
}

/* Nothing to render: no ACF rows and no fallback provided. */
if ( ! $has_rows && empty( $fallback ) ) {
	return;
}

/**
 * Helper: advances the ACF repeater loop, respecting object_id.
 * Declared inline so it's scoped to this template include.
 *
 * @return bool
 */
$gls_have_rows = static function () use ( $field, $object_id ) {
	return ( $object_id !== false )
		? have_rows( $field, $object_id )
		: have_rows( $field );
};

?>

<section class="publics-home-slides">

	<?php if ( $has_rows ) : ?>

		<?php while ( $gls_have_rows() ) : the_row();

			$background = get_sub_field( 'slide_background' );
			$title      = get_sub_field( 'slide_title' );
			$text       = get_sub_field( 'slide_text' );
			$button     = get_sub_field( 'slide_button' );

		?>

			<div class="publics-slide">

				<?php if ( $background ) : ?>
					<div class="publics-slide-bg"
						style="background-image: url('<?php echo esc_url( $background['url'] ); ?>');">
					</div>
				<?php endif; ?>

				<div class="publics-slide-inner">

					<?php if ( $title ) : ?>
						<h2 class="gls-home-prop-title">
							<?php echo esc_html( $title ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<div class="gls-home-prop-text">
							<?php echo wp_kses_post( $text ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $button ) : ?>
						<a href="<?php echo esc_url( $button['url'] ); ?>"
							class="gls-intro__cta btn-fix-outline"
							target="<?php echo esc_attr( $button['target'] ); ?>">
							<?php echo esc_html( $button['title'] ); ?>
						</a>
					<?php endif; ?>

				</div>

			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<?php foreach ( $fallback as $slide ) :
			$bg_url = ( ! empty( $slide['background']['url'] ) ) ? esc_url( $slide['background']['url'] ) : '';
			$title  = ! empty( $slide['title'] )  ? $slide['title']  : '';
			$text   = ! empty( $slide['text'] )   ? $slide['text']   : '';
			$button = ! empty( $slide['button'] ) ? $slide['button'] : [];
		?>

			<div class="publics-slide">

				<?php if ( $bg_url ) : ?>
					<div class="publics-slide-bg"
						style="background-image: url('<?php echo $bg_url; ?>');">
					</div>
				<?php endif; ?>

				<div class="publics-slide-inner">

					<?php if ( $title ) : ?>
						<h2 class="gls-home-prop-title">
							<?php echo esc_html( $title ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<div class="gls-home-prop-text">
							<?php echo wp_kses_post( $text ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $button['url'] ) ) : ?>
						<a href="<?php echo esc_url( $button['url'] ); ?>"
							class="gls-intro__cta btn-fix-outline"
							target="<?php echo esc_attr( ! empty( $button['target'] ) ? $button['target'] : '_self' ); ?>">
							<?php echo esc_html( ! empty( $button['title'] ) ? $button['title'] : 'Ver más' ); ?>
						</a>
					<?php endif; ?>

				</div>

			</div>

		<?php endforeach; ?>

	<?php endif; ?>

</section>