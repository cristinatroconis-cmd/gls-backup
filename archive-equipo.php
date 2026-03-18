<?php
/**
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="main" class="site-main">
	<header class="header-page container">
		<div class="row">
			<div class="col-12">
				<h1 class="title"><?php echo get_queried_object()->name;?></h1>
			</div>
		</div>
	</header>
	
	<section class="page-pred">
		<div class="container">
			<div class="row">
				<div class="col-12 blog-loop">
					<div class="row">
						<?php if(have_posts()): while ( have_posts() ) : the_post(); ?>
							<div class="elem col-md-6">
								<?php
									// Por defecto, hemos definido la maquetación interna de los cards en content-card.php;
									// Si deseamos un diseño diferente para un CPT, creamos content-nombredelCPT.php
									if (locate_template( array( 'content-' . get_post_type() . '.php' ) ) != '') {
										get_template_part( 'content', get_post_type() );
									} else {
										get_template_part( 'content', 'card' );
									} 
								?>
							</div>
						<?php endwhile; endif; ?>
					</div>
					<div class="row">
					    <div class="blog-pagination col-12">
                            <?php echo paginate_links(); ?>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();