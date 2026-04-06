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

	/*
	 * 5. Contacto Section – legacy Bootstrap layout restored.
	 *
	 * Field priority:
	 *   1. gls_contact_* fields (group_gls_lead_contact_01, assigned to this template).
	 *   2. titulo / subtitulo / formulario / video fields (group_602a0f8454873,
	 *      assigned to page 3438 / acf/contacto block) – fallback for existing installs.
	 *
	 * The section ID is kept verbatim to preserve CSS selectors, JS anchors,
	 * and tracking references (ACF block suffix: block_183f14bd8cd37e7c607d2bd9cf0118a6).
	 */

	/* -- Title & body text -- */
	$ct_titulo    = get_field( 'gls_contact_title' ) ?: get_field( 'titulo' );
	$ct_subtitulo = get_field( 'gls_contact_text' )  ?: get_field( 'subtitulo' );

	/* -- Form shortcode -- */
	$ct_form_sc = '';
	$ct_form_shortcode = get_field( 'gls_contact_form_shortcode' );
	if ( $ct_form_shortcode ) {
		$ct_form_sc = $ct_form_shortcode;
	} else {
		$ct_formulario = get_field( 'formulario' );
		if ( $ct_formulario ) {
			$form_id = is_array( $ct_formulario )
				? ( isset( $ct_formulario['id'] ) ? intval( $ct_formulario['id'] ) : 0 )
				: intval( $ct_formulario );
			if ( $form_id > 0 ) {
				$ct_form_sc = '[gravityforms id="' . $form_id . '" title="false" description="false" ajax="true"]';
			}
		}
	}

	/* -- Video URL: prefer gls_contact_video_mp4 (file field), fallback to video (url field) -- */
	$ct_video = '';
	$media_type = get_field( 'gls_contact_media_type' );
	$video_mp4  = get_field( 'gls_contact_video_mp4' );
	if ( $media_type === 'video' && is_array( $video_mp4 ) && ! empty( $video_mp4['url'] ) ) {
		$ct_video = esc_url( $video_mp4['url'] );
	} else {
		$video_legacy = get_field( 'video' );
		if ( $video_legacy ) {
			$ct_video = esc_url( $video_legacy );
		}
	}
	?>

	<section id="contacto-home-block_183f14bd8cd37e7c607d2bd9cf0118a6" class="contacto-home">
		<div class="container-fluid">
			<div class="row reverse-movil">

				<div class="col-lg-6 col-12 col-md-6 d-flex justify-content-center align-items-center faq">
					<div class="col-12 col-md-10 col-lg-8 formulario-container">

						<?php if ( $ct_titulo ) : ?>
							<h2 class="mb-3 bellmt"><?php echo esc_html( $ct_titulo ); ?></h2>
						<?php endif; ?>

						<?php if ( $ct_subtitulo ) : ?>
							<div class="mb-3"><?php echo wp_kses_post( $ct_subtitulo ); ?></div>
						<?php endif; ?>

						<div id="form-container" class="form-container">
							<a id="gform"></a>
							<?php if ( $ct_form_sc ) : ?>
								<?php echo do_shortcode( $ct_form_sc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php endif; ?>
						</div>

					</div>
				</div><!-- /.col faq -->

				<div class="col-md-6">
					<?php if ( $ct_video ) : ?>
						<div class="video-background">
							<video autoplay muted playsinline loop aria-hidden="true">
								<source src="<?php echo esc_url( $ct_video ); ?>" type="video/mp4">
							</video>
						</div>
					<?php endif; ?>
				</div><!-- /.col video -->

			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
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
