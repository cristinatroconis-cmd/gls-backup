<?php
get_header();
$categoria = get_query_var('cat');
$term = get_queried_object();
$titulo = get_field('titulo', $term);
$subtitulo = get_field('subtitulo', $term);
$cta = get_field('cta', $term);
$enlace_cta = get_field('enlace_cta', $term);
$titulooculto = get_field('titulooculto', $term);
?>

<main id="main" class="site-main">
	<header class="header-page container invisible">
		<div class="row">
			<div class="col-12">
				<?php if($titulooculto): ?>
				<h1 class="text-center"><?php echo $titulooculto; ?></h1>
				<?php else: ?>
				<h1 class="title"><?php echo get_queried_object()->name;?></h1>
				<?php endif; ?>
			</div>
		</div>
	</header>
	
	<section class="categoria-productos productos w-100">
	    <div class="container-fluid">
	        <div class="row flex-column justify-content-center mb-4">
	        	<?php if($titulo): ?>
	            <h2 class="h1 text-center"><?php echo $titulo; ?></h2>
				<?php else: ?>
	            <h2 class="h1 text-center"><?php echo single_term_title(); ?></h2>
	            <?php endif; ?>
	            <h4 class="text-center"><?php echo $subtitulo; ?></h4>
	        </div>
	        <div class="col-12 blog-loop">
	            <div class="row w-100 column justify-content-center">
	                <?php 
	                // The Query
	                $args = array(
	                    // Arguments for your query.
	                    'posts_per_page'  => -1,
	                    'cat'			  => $categoria,
	                    'post_type'       => 'productos',
	                    'orderby'         => 'post_date',
	                    'order'           => 'DES',
	                    'post_status'     => 'publish',
	                    'suppress_filters' => true ); 
	                 
	                // Custom query.
	                $query = new WP_Query( $args );
	                 
	                // Check that we have query results.
	                if ( $query->have_posts() ) {
	                     
	                // Start looping over the query results.
	                while ( $query->have_posts() ) {
	            
	                    $query->the_post();
	                    $id = get_the_ID();
	                    $imagen_del_listado_de_productos = get_field('imagen_del_listado_de_productos', $id);
	                    ?>
	                <div class="col-md-6 col-lg-3">
	                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
	                    <?php if($imagen_del_listado_de_productos): ?>
	                        <img class="card-img-top placeholder" src="<?php echo $imagen_del_listado_de_productos; ?>" alt="<?php the_title(); ?>" />
	                    <?php else: ?>
	                        <?php the_post_thumbnail('card-thumbnail'); ?>
	                        <?php endif; ?>
	                        <div class="card-body">

	                            <h4 class="card-title"><?php the_title(); ?></h4>
	                            <div class="back-card  d-none d-md-block">
	                                <?php echo the_excerpt(); ?>
	                            </div>

	                            <a href="<?php the_permalink();?>" class="read_more more-arrow d-md-block d-lg-none">
	                                <span>Ver más <i class="fas fa-arrow-right"></i></span>
	                            </a>
	                        </div>
	                    </article>
	                </div>
	                <?php
	                }
	                }
	                // Restore original post data.
	                wp_reset_postdata();
	                 ?>            
	            </div>
	        </div>
	        <?php if($cta): ?>
	        <div class="row boton justify-content-center">
	            <a href="<?php echo $enlace_cta; ?>" class="cta-button"><?php echo $cta; ?></a>
	        </div>
	        <?php endif; ?>
	    </div>
	</section>
</main>

<?php
get_footer();