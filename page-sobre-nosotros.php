<?php
/**
 * Template Name: Sobre Nosotros
 * Template Post Type: page
 *
 * GLS – Página Sobre Nosotros
 * Renderiza: hero + sección split luxury editable por ACF + contenido de página.
 */

get_header();

get_template_part( 'template-parts/gls-page-hero' );
?>

<main class="site-main site-main--sobre-nosotros">

	<?php
	get_template_part( 'template-parts/gls-section-split', null, [
		'prefix'    => 'gls_sn_split',
		'object_id' => false,
		'layout'    => 'image-right',
		'fallback'  => [
			'eyebrow'       => __( 'Quiénes somos', 'identofmk' ),
			'titulo'        => __( 'Una experiencia única en Granada', 'identofmk' ),
			'texto'         => __( 'Granada Luxury Suites nació del deseo de ofrecer una alternativa diferente al alojamiento convencional. Apostamos por el lujo discreto, la atención personalizada y la conexión auténtica con el espíritu de Granada.', 'identofmk' ),
			'btn_primary'   => [ 'title' => __( 'Nuestras suites', 'identofmk' ), 'url' => '/apartamentos/', 'target' => '' ],
			'btn_secondary' => null,
			'imagen_url'    => '',
			'bg'            => 'accent',
		],
	] );
	?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
