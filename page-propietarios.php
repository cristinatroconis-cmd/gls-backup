<?php
/*
Template Name: Propietarios
Description: Página para propietarios de apartamentos turísticos (GLS).
             Muestra: Page Hero + Intro Editorial + Split A + Split B + Lead/Contact Section (ACF-driven) + contenido de página.
             También carga automáticamente vía jerarquía de plantillas WP para el slug "propietarios".
*/

get_header();
?>

<main class="site-main gls-propietarios">

	<?php
	/* 1. Page Hero (shared across non-home pages) */
	get_template_part('template-parts/gls-page-hero');

	/* 2. Intro Editorial Section */
	get_template_part('template-parts/gls-section-intro');

	/* 3. Split Section A – image right (default variant) */
	get_template_part('template-parts/gls-section-split', null, [
		'layout' => 'image-right',
		'prefix' => 'gls_split',
	]);

	/* 4. Split Section B – image left (reversed variant) */
	get_template_part('template-parts/gls-section-split', null, [
		'layout' => 'image-left',
		'prefix' => 'gls_split_b',
	]);

	/* 5. Contacto Section – ACF fields from group_602a0f8454873 (page 3438 / acf/contacto block) */
	$ct_titulo     = get_field( 'titulo' );
	$ct_subtitulo  = get_field( 'subtitulo' );
	$ct_formulario = get_field( 'formulario' );
	$ct_video      = get_field( 'video' );

	/*
	 * gravity_forms_field returns the form ID (int|string) when allow_multiple = 0.
	 * Guard against array/object returns just in case (e.g. allow_multiple enabled).
	 */
	$ct_form_sc = '';
	if ( $ct_formulario ) {
		if ( is_array( $ct_formulario ) ) {
			$form_id = isset( $ct_formulario['id'] ) ? intval( $ct_formulario['id'] ) : 0;
		} else {
			$form_id = intval( $ct_formulario );
		}
		if ( $form_id > 0 ) {
			$ct_form_sc = '[gravityforms id="' . $form_id . '" title="false" description="false" ajax="true"]';
		}
	}

	/*
	 * The section ID below is the legacy block ID from the original page content
	 * (ACF block suffix: block_183f14bd8cd37e7c607d2bd9cf0118a6). It is kept
	 * verbatim to preserve existing CSS, JS anchors, and tracking references.
	 */
	?>

	<section id="contacto-home-block_183f14bd8cd37e7c607d2bd9cf0118a6" class="contacto-home">

		<div class="contacto-home__inner">

			<div class="contacto-home__content">

				<?php if ( $ct_titulo ) : ?>
					<h2 class="contacto-home__title">
						<?php echo esc_html( $ct_titulo ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $ct_subtitulo ) : ?>
					<div class="contacto-home__text">
						<?php echo wp_kses_post( $ct_subtitulo ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $ct_form_sc ) : ?>
					<div class="contacto-home__form">
						<?php echo do_shortcode( $ct_form_sc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>

			</div><!-- /.contacto-home__content -->

			<?php if ( $ct_video ) : ?>
				<div class="contacto-home__media video-background">
					<video
						src="<?php echo esc_url( $ct_video ); ?>"
						autoplay
						muted
						loop
						playsinline
						aria-hidden="true"
					></video>
				</div><!-- /.contacto-home__media -->
			<?php endif; ?>

		</div><!-- /.contacto-home__inner -->

	</section><!-- #contacto-home-block_183f14bd8cd37e7c607d2bd9cf0118a6 -->

	<?php

	/* 6. Page content (the_content) – preserves any existing editor content */
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$content = get_the_content();
			if ( !empty(trim($content)) ) :
	?>
			<div class="entry-content gls-propietarios__content">
				<?php the_content(); ?>
			</div>
	<?php
			endif;
		endwhile;
	endif;
	?>

</main><!-- /.site-main -->

<?php get_footer(); ?>
