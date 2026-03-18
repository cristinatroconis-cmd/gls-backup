<?php get_header();
/* Template Name: Template Luxury Exp*/ 
?>
<main id="main" class="site-main">
<section class="cabecera cabecera--mg0 ">
        <?php if (has_post_thumbnail()) : ?>
            <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
            <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title(); ?>" />
        <?php endif; ?>
		<div class="container centrar">        
			<div class="row position-relative">
				<div class="col-12 col-md-12 centrar">
					<h1 class="d-none"> <?php the_title(); ?></h1>			
					<span class="h1 strong bellmt white">  <?php the_title();?></span>
				</div>
			</div>
		</div>
	</section>
    <section class="page-pred page-pred-experiencias">
    <div class="TabHero-gradient-reverse"></div>
			<div class="container">
				<div class="row row-center">
					<div class="col-md-9 col-12 team-single-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="d-flex justify-content-center botton-experiencias">
                <a class="cta-button" href="/experiencias/" target="_self"><?= _e("Ver todas las experiencias", "experiencias"); ?></a>
                </div>
                </div>
               
            </div>
            
    <?php
    $enlaceDelMapa = get_field('enlace_del_mapa_en_google_maps');
    if (!empty($enlaceDelMapa)) {
        ?>
        <iframe style="border: 0; width: 100%;" src="<?php echo $enlaceDelMapa; ?>" width="100%" height="350"></iframe>
        <?php
    }
?>
    </section>
</main>
<?php get_footer(); ?>