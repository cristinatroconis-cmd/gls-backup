<?php get_header(); 
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$titulooculto = get_field('titulooculto');
?>

<main class="contenido">
    <div class="page-pred container">
        <header class="row header-box d-none">
            <div class="col-12">
                <?php if($titulooculto): ?>
                <h1 class="text-center"><?php echo $titulooculto; ?></h1>
                <?php else: ?>
                <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>
    </div>
</main>

<main id="main" class="site-main">
    <article <?php post_class('single-blog-page'); ?>>
		<section class="cabecera page-pred">
			<div class="container">
				<div class="row">
					<div class="col-md-8 offset-md-2 col-12 blog-single-content">
						<?php if(has_post_thumbnail()): ?>
							<div class="thumbnail-single-block"><?php the_post_thumbnail('large'); ?></div>
						<?php endif; ?>
                        <div class="_description_box">
                            <div class="_description">
                            	<?php if($titulo): ?>
                        		<h2 class="title h1 white"><?php echo $titulo; ?></h2>
                        		<?php else: ?>
                                <h2 class="title h1 white"><?php the_title(); ?></h2>
                                <?php endif; ?>
                                <?php if($subtitulo): ?>
                        		<h4 class="title h1 white"><?php echo $subtitulo; ?></h4>
                                <?php endif; ?>
                                <span class="pretitle"><div class="date"><?php idento_posted_on(); ?></div></span>
                            </div>
                        </div>
						<div class="content the-content">
							<?php the_content(); ?>
						</div>
						<div class="footer-content-blog">
						    <?php if(has_category() || has_tag()): ?>
                        		<div class="cat-blog-nav">
									<?php if(has_category()): ?>
										<div class="elem">
											<?php _e( 'Categorías: ', 'identofmk' );
											  // to display categories without a link
											  foreach ( ( get_the_category() ) as $category ) {
											    $cat_names[] = $category->cat_name;
											    //echo $category->cat_name . ' ';
											  }
											  echo implode( ', ', $cat_names );
											?>
										</div>
									<?php endif; ?>
									<?php if(has_tag()): ?>
										<div class="elem">
											<?php 
											$posttags = get_the_tags(null, ', ');
											if ($posttags) {
												echo '<span>Etiquetas: </span>';
											  foreach($posttags as $tag) {
											  	$tag_names[] = $tag->name;
											    //echo '<span class="mr-2">' .$tag->name. '</span>'; 
											  }
											  echo implode( ', ', $tag_names );
											}?>
										</div>
									<?php endif; ?>
								</div>
                    		<?php endif; ?>
						</div>
						<!--<?php //if(have_comments() || comments_open()): ?>
							<div class="comment-wrap">
								<?php //comments_template(); ?>
							</div>
						<?php //endif; ?>-->
					</div>
				</div>
			</div>
		</section>
	</article>
</main>

<?php get_footer(); ?>