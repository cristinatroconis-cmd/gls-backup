<?php get_header(); ?>

<main id="main" class="site-main">
    <article>
		<section class="page-pred">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-12 team-single-content">
						<?php if(has_post_thumbnail()): ?>
							<div class="thumbnail-single-block"><?php the_post_thumbnail('medium_large'); ?></div>
						<?php endif; ?>
                        <div class="_description_box">
                            <div class="_description">
                                <h1 class="title h1 white"><?php the_title(); ?></h1>
                                
                            </div>
                        </div>
						<div class="content the-content">
							<ul>
                                    <li>Puesto de trabajo: <?php the_field('puesto_de_trabajo');?></li>
                                    <li>Formación profesional: <?php the_field('formacion');?> </li>
                                    <li>Teléfono:  <a href="tel:<?php the_field('telefono');?>"><?php the_field('telefono');?></a></li>
                                    <li>Email:  <a href="mailto:<?php the_field('email');?>"><?php the_field('email');?></a></li>
                                    <li>Perfil de Linkedin:  <a href="<?php the_field('linkedin');?>">Mi perfil</a></li>
                                    <li>Enlace al Currículum:  <a href="<?php the_field('curriculum');?>">Mi CV</a></li>
                                </ul>
						</div>

					</div>
					<div class="col-md-3 col-12 sidebar">
						
					</div>
				</div>
			</div>
		</section>
	</article>
</main>

<?php get_footer(); ?>