<?php
/**
 * GLS – Section Lead / Contact
 * Template Part: template-parts/gls-section-lead-contact.php
 *
 * Renders a 2-column lead/contact section:
 *   left  – title (H2), rich text, gravity-forms shortcode area.
 *   right – background media: video (mp4) preferred, image fallback.
 *
 * Reads ACF fields from the current page; falls back to example
 * content so the section renders immediately in local/dev even
 * without saved values.
 *
 * ACF fields used (all optional):
 *   gls_contact_title          – text     (H2 heading)
 *   gls_contact_text           – wysiwyg  (rich text body)
 *   gls_contact_form_shortcode – text     (GF shortcode, e.g. [gravityforms id="1" …])
 *   gls_contact_media_type     – select   ('video' | 'image')
 *   gls_contact_video_mp4      – file     (returns array with 'url')
 *   gls_contact_image          – image    (returns array with 'url' and 'alt')
 *   gls_contact_bg_variant     – select   ('' | 'light' | 'accent' | 'dark')
 */

/* ---- ACF fields with safe fallbacks ---- */
$title          = get_field('gls_contact_title')          ?: __('Confía tu apartamento a los expertos', 'gls-backup');
$text           = get_field('gls_contact_text')           ?: '<p>' . __('En Granada Luxury Suites nos encargamos de la gestión integral de tu apartamento turístico: reservas, limpieza, mantenimiento y atención personalizada al huésped las 24 horas. Tú descansas; nosotros trabajamos.', 'gls-backup') . '</p>';
$form_shortcode = get_field('gls_contact_form_shortcode') ?: '';
$media_type     = get_field('gls_contact_media_type')     ?: 'image';
$video_mp4      = get_field('gls_contact_video_mp4');
$image          = get_field('gls_contact_image');
$bg_variant     = get_field('gls_contact_bg_variant')     ?: '';

/* ---- Resolve media ---- */
$video_url = '';
if ( $media_type === 'video' && is_array($video_mp4) && !empty($video_mp4['url']) ) {
	$video_url = esc_url($video_mp4['url']);
}

$img_url = '';
$img_alt = '';
if ( is_array($image) && !empty($image['url']) ) {
	$img_url = esc_url($image['url']);
	$img_alt = esc_attr($image['alt'] ?? '');
} else {
	/* Fallback: theme placeholder */
	$img_url = esc_url(get_stylesheet_directory_uri() . '/img/placeholder.jpg');
	$img_alt = esc_attr__('Granada Luxury Suites', 'gls-backup');
}

/* ---- CSS modifier classes ---- */
$section_classes = 'gls-lead-contact';
if ( $bg_variant ) {
	$section_classes .= ' gls-lead-contact--' . sanitize_html_class($bg_variant);
}
?>
<section class="<?php echo esc_attr($section_classes); ?>">

	<div class="gls-lead-contact__inner gls-container">

		<!-- Left: content + form -->
		<div class="gls-lead-contact__content">

			<h2 class="gls-lead-contact__title">
				<?php echo esc_html($title); ?>
			</h2>

			<?php if ( $text ) : ?>
				<div class="gls-lead-contact__text">
					<?php echo wp_kses_post($text); ?>
				</div>
			<?php endif; ?>

			<?php if ( $form_shortcode ) : ?>
				<div class="gls-lead-contact__form">
					<?php echo do_shortcode(wp_kses_post($form_shortcode)); ?>
				</div>
			<?php else : ?>
				<div class="gls-lead-contact__form gls-lead-contact__form--placeholder">
					<p class="gls-lead-contact__form-note">
						<?php esc_html_e('Formulario de contacto (añade el shortcode de Gravity Forms en ACF).', 'gls-backup'); ?>
					</p>
				</div>
			<?php endif; ?>

		</div><!-- /.gls-lead-contact__content -->

		<!-- Right: media (video preferred, image fallback) -->
		<div class="gls-lead-contact__media">
			<div class="gls-lead-contact__media-wrap">

				<?php if ( $video_url ) : ?>
					<video
						class="gls-lead-contact__video"
						src="<?php echo $video_url; ?>"
						autoplay
						muted
						loop
						playsinline
						aria-hidden="true"
					></video>
					<?php if ( $img_url ) : ?>
						<!-- Fallback poster image -->
						<img
							src="<?php echo $img_url; ?>"
							alt="<?php echo $img_alt; ?>"
							class="gls-lead-contact__img gls-lead-contact__img--poster"
							loading="lazy"
						/>
					<?php endif; ?>
				<?php else : ?>
					<img
						src="<?php echo $img_url; ?>"
						alt="<?php echo $img_alt; ?>"
						class="gls-lead-contact__img"
						loading="lazy"
					/>
				<?php endif; ?>

			</div><!-- /.gls-lead-contact__media-wrap -->
		</div><!-- /.gls-lead-contact__media -->

	</div><!-- /.gls-lead-contact__inner -->

</section><!-- /.gls-lead-contact -->
