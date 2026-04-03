<?php
/**
 * Template Name: Propietarios
 * Template Post Type: page
 *
 * GLS – Página Propietarios
 * Renderiza: hero + sección split luxury editable por ACF + contenido de página.
 */

get_header();

get_template_part( 'template-parts/gls-page-hero' );
?>

<main class="site-main site-main--propietarios">

	<?php
	get_template_part( 'template-parts/gls-section-split', null, [
		'prefix'    => 'gls_prop_split',
		'object_id' => false,
		'layout'    => 'image-right',
		'fallback'  => [
			'eyebrow'       => __( 'Para propietarios', 'identofmk' ),
			'titulo'        => __( 'Gestión Profesional de tu Propiedad', 'identofmk' ),
			'texto'         => __( 'En Granada Luxury Suites nos encargamos de todo: desde la gestión de reservas hasta el mantenimiento, para que tú solo disfrutes de tus ingresos con total tranquilidad.', 'identofmk' ),
			'btn_primary'   => [ 'title' => __( 'Más información', 'identofmk' ), 'url' => '#contacto', 'target' => '' ],
			'btn_secondary' => [ 'title' => __( 'Contáctanos',    'identofmk' ), 'url' => '#contacto', 'target' => '' ],
			'imagen_url'    => '',
			'bg'            => 'light',
		],
	] );
	?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
