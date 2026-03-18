<?php
get_header();
$term = get_queried_object();
$titulo = get_field('titulo', $term);
$subtitulo = get_field('subtitulo', $term);
$titulooculto = get_field('titulooculto', $term);
?>

<main class="contenido">
    <div class="page-pred container">
        <header class="row header-box invisible">
            <div class="col-12">
                <?php if($titulooculto): ?>
                <h1 class="text-center"><?php echo $titulooculto; ?></h1>
                <?php else: ?>
                <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>
        <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> noticias cabecera w-100">
		    <div class="container">
		        <div class="row flex-column justify-content-center mb-4">

		            <?php if($titulo): ?>
		            <h2 class="text-center"><?php echo $titulo; ?></h2>
		            <?php endif; ?>

		            <?php if($subtitulo): ?>
		            <h4 class="text-center"><?php echo $subtitulo; ?></h4>
		            <?php endif; ?>

		        </div>
		        <div class="row row-reverse-movil">
		            <div class="col-md-10">
		            	<div class="blog-loop">
		            		<div class="row">
			                        <?php if(have_posts()): while ( have_posts() ) : the_post(); ?>
			                    <div class="elem col-md-6 mb-5">
			                        <div class="img-container">
			                            <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
			                                <?php the_post_thumbnail('card-thumbnail'); ?>
			                                <div class="card-body">
			                                    <p class="small"><?php echo get_the_date(); ?></p>
			                                    <h4 class="card-title"><?php the_title(); ?></h4>
			                                    <div class="excerpt">
			                                        <?php echo the_excerpt(); ?>
			                                    </div>

			                                    <a href="<?php the_permalink();?>" class="read_more plas">
			                                        <span><i class="fas fa-plus"></i></span>
			                                    </a>
			                                </div>
			                            </article>
			                        </div>                
			                    </div>
			                <?php /*}}
			                // Restore original post data.
			                wp_reset_postdata(); */?>
			                <?php endwhile; endif; ?>
			                </div>
		            	</div>
		                
		                <div class="row">
						    <div class="blog-pagination col-12">
	                            <?php 
	                            echo paginate_links(array(

								  'prev_text' => '<i class="fas fa-angle-double-left"></i>',
								  'next_text' => '<i class="fas fa-angle-double-right"></i>'

								)); ?>
	                        </div>
						</div>
		            </div>
		            <div class="col-md-2 col-12 sidebar">
		                <?php dynamic_sidebar( 'sidebar' ); ?>
		            </div>
		        </div>
		    </div>
		</section>
    </div>
</main>


<?php
get_footer();