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

	/* 5. Lead / Contact Section (ACF-driven, with fallback example content) */
	get_template_part('template-parts/gls-section-lead-contact');

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
