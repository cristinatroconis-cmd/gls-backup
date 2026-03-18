<?php get_header(); 

?>

<main class="">
	<!--BLOQUE CABECERA LOS DATOS SE RELLENAN EN OPTION DEL TEMA-->
	<section id="cabecera-block_6229f1519f61e" class="cabecera">
		<?php   $cabecera_apartamentos = get_field('cabecera_apartamentos','option');?>
		<img src="<?php echo esc_url($cabecera_apartamentos['url']); ?>" alt="<?php the_title(); ?>" class="" />
		<div class="container centrar">        
			<div class="row position-relative">
				<div class="col-12 col-md-12 centrar">
					<?php
					$titulo_apartamentos = get_field('titulo_apartamentos','option');
					$subtitulo_apartamentos = get_field('subtitulo_apartamentos','option');
					?>
					<h1 class="d-none">Apartamentos turísticos en Granada</h1>			
					<span class="h1 strong bellmt white"><?php echo $titulo_apartamentos; ?></span>
					<span class="h1 bellmt white"><?php echo $subtitulo_apartamentos; ?></span>
				</div>
			</div>
		</div>
	</section>
	
    <!--BLOQUE TEXTO DOS COLUMNAS RESPONSIVE LOS DATOS SE RELLENAN EN OPTION DEL TEMA-->
	<?php
	$titulo_arriba1 = get_field('titulo_arriba1_temporada','option');
	$titulo_abajo1 = get_field('titulo_abajo1_temporada','option');
	$textoizquierda1 = get_field('textoizquierda1_temporada','option');
	$textoderecha1 = get_field('textoderecha1_temporada','option');
	?>
	<div class="wp-block-columns container pb-10 is-layout-flex wp-container-11 wp-block-columns-is-layout-flex">
		<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:5%"></div>
		<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
			<p class="bellmt h3 m-0"><strong><?php echo $titulo_arriba1; ?></strong></p>
			<p class="bellmt h3"><?php echo $titulo_abajo1; ?></p>
			<div class="wp-block-columns is-layout-flex wp-container-8 wp-block-columns-is-layout-flex">
				<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
					<p class="coolvetica"><?php echo $textoizquierda1; ?></p>
				</div>
				<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60px"></div>
				<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
					<p class="coolvetica"><?php echo $textoderecha1; ?></p>
				</div>
			</div>
		</div>
		<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:5%"></div>
	</div>

	<!--BLOQUE LOOP APARTAMENTOS-->
    <section id="seleccionados-block_8c9f84cb8c50816d6c06b75b2b841e74" class="seleccionados productos">             
		<div class="container">
			<h2 class="text-center pb-5"><strong class="d-block"><?php _e('Nuestros', 'granadaluxury'); ?></strong> <?php _e('apartamentos', 'granadaluxury'); ?></h2>
			<div class="col-12 blog-loop">
				<div class="row column justify-content-center apartamentos-loop">
					<?php
					$original_query = $wp_query; // Guardamos la consulta original
					$wp_query = new WP_Query(array(
						'post_type'      => 'apartamentos',
						'posts_per_page' => 10,
						'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
						'meta_query'     => array(
							array(
								'key'     => 'alquiler_temporada', // Nombre del campo ACF
								'value'   => '1',                  // El valor para true en campos ACF de tipo true/false
								'compare' => '=',                  // Comparar valores
							),
						),
					));
					if ($wp_query->have_posts()) : 
					$i = 1;
					while ($wp_query->have_posts()) : $wp_query->the_post();

					$id = get_the_id();
					$permalink = get_permalink( $id );
					$title = get_the_title( $id );


					//echo $id;

					$featured_img_url = get_the_post_thumbnail_url($id,'medium_large');
					$titulo_linea_de_arriba = get_field('titulo_linea_de_arriba',$id);
					$titulo_linea_de_abajo = get_field('titulo_linea_de_abajo',$id);
					$personas = get_field('personas',$id);
					$dormitorios = get_field('dormitorios',$id);
					$banos = get_field('banos',$id);
					$ubicarray = [];

					$classes = [
						'card'
					];

					$classe = [
						'col-12',
						'col-md-6',
						'col-lg-4',
						'mb-4'
					];
					?>

       				<div class="card <?php if (($i % 2)==1 ) { echo "col-lg-10 col-md-11 col-12";} else {echo 'col-lg-10 offset-lg-2 col-md-11 offset-md-1 col-12';} ?>">
                		<article id="post-<?php echo $id; ?>" class="row d-flex flex-row<?php if (($i % 2)==1 ) { echo "-reverse";} ?>" >
							<?php 
							// Check rows exists.
							if( have_rows('fotografias',$id) ):
								$e = 0;
							?>
							<div id="carouselapartamentos-<?php echo $id; ?>" class="carousel slide col-12 col-md-6 col-lg-7 ">
							  <div class="carousel-indicators">
								<?php
								// Loop through rows.
								while( have_rows('fotografias',$id) ) : the_row(); ?>

								<button type="button" data-bs-target="#carouselapartamentos-<?php echo $id; ?>" data-bs-slide-to="<?php echo $e; ?>" class="<?php if($e==0){echo 'active';}?>" aria-current="true" aria-label="Slide <?php echo $e+1; ?>"></button>
								<?php
								// End loop.
								$e++;
								endwhile;
								endif;

								// Check rows exists.
								if( have_rows('fotografias',$id) ):
								$a = 0;
								?>
								</div>
								<div class="carousel-inner">
								<?php
								// Loop through rows.
								while( have_rows('fotografias',$id) ) : the_row();
								// Load sub field value.
								$foto = get_sub_field('foto'); ?>
								<div class="carousel-item <?php if($a==0){echo 'active';}?>">
									<img class="d-block w-100" src="<?php echo esc_url($foto['url']); ?>" alt="<?php echo esc_attr($foto['alt']); ?>" />
								</div>
								<?php
								// End loop.
								$a++;
								endwhile;
								$precio = get_field('precio_alquiler_temporada',$id);
								$variable_de_precio = get_field('variable_de_precio',$id);
								if($precio):
								?>
								<div class="p-absolute precio-card">
									<div class="precio bebasneue mt-3">
										<span class="variable"><?php _e('Desde', 'granadaluxury'); ?></span><br> <?php echo $precio; ?><span class="variable">/mes</span>
									</div>
								</div>
								<?php
								endif;
								?>
								</div>
							  <button class="carousel-control-prev" type="button" data-bs-target="#carouselapartamentos-<?php echo $id; ?>" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							  </button>
							  <button class="carousel-control-next" type="button" data-bs-target="#carouselapartamentos-<?php echo $id; ?>" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							  </button>
							</div>
                            <?php else: ?>
                    		<div class=" col-12 col-md-6 col-lg-7 imagen-card">
								<?php
								$precio = get_field('precio_alquiler_temporada',$id);
								$variable_de_precio = get_field('variable_de_precio',$id);
								if($precio):
								?>
								<div class="p-absolute precio-card">
									<div class="precio bebasneue mt-3">
										<span class="variable"><?php _e('Desde', 'granadaluxury'); ?></span><br> <?php echo $precio; ?><span class="variable">/mes</span>
									</div>
								</div>
								<?php
								endif;
							echo get_the_post_thumbnail($id, 'card-thumbnail'); 
							?>
							</div>
                        <?php endif; ?>
							<div class="card-body col-12 col-md-6 col-lg-5">
								<div class="contenido-texto">
									<h3 class="card-title bellmt titulo-apartamentos"><span class="strong"><?php echo $titulo_linea_de_arriba; ?></span><br><span><?php echo $titulo_linea_de_abajo; ?></span></h3>
									<?php if(get_the_excerpt()): ?>
									<div class="descriptor mb-3 col-12 col-md-11"><!-- d-none d-md-block -->
										<?php echo the_excerpt(); ?>
									</div>
									<?php endif; ?>

									<?php

									// Check rows existexists.
									if( have_rows('datos_del_apartamento',$id) ):
									?>
									<div class="datos_apartamento mb-4">
									<?php
									// Loop through rows.
									while( have_rows('datos_del_apartamento',$id) ) : the_row();

									// Load sub field value.
									$icono_del_dato = get_sub_field('icono_del_dato');
									$texto_que_acompana_al_icono = get_sub_field('texto_que_acompana_al_icono');
									// Do something...
									?>
									<div class="d-flex">
										<div>
										<?php 
										if( !empty( $icono_del_dato ) ): ?>
											<img src="<?php echo esc_url($icono_del_dato['url']); ?>" alt="<?php echo esc_attr($icono_del_dato['alt']); ?>" />
										<?php endif; ?>
										</div>
										<div class="lista-inicio">
											<p style="margin: 0px;"><?php echo $texto_que_acompana_al_icono; ?></p>
										</div>
									</div>
									<?php

									// End loop.
									endwhile;

									?>
									</div>
									<?php
									endif;
									?>

									<div class="d-flex justify-content-start">
										<a href="<?php the_permalink();?>?tipo=temporada" class="cta-button">
											<span><?php _e('Descúbrelo', 'granadaluxury'); ?></span><!-- d-md-block d-lg-none -->
										</a>
									</div>
								</div>
                        	</div>
                    	</article>
                	</div>   
                	<?php
					$i++;   
					endwhile;
					endif;
					$wp_query = $original_query; // Restauramos la consulta original
					wp_reset_postdata(); // Restablecemos los datos de la consulta
					?>
				</div>
			</div>
			<div class="pagination">
				<?php custom_post_type_pagination_links(); ?>
			</div>
		</div>
	</section>

	<!--BLOQUE TEXTO DOS COLUMNAS RESPONSIVE LOS DATOS SE RELLENAN EN OPTION DEL TEMA-->

	<!--BLOQUE LOGOS* LOS DATOS SE RELLENAN EN OPTION DEL TEMA-->
    <?php
	$imagen_de_fondo = get_field('imagen_de_fondo','option');
    $pretitulo = get_field('pretitulo','option');
    $titulobanner = get_field('titulobanner','option');
    $contenido_fijo = get_field('contenido_fijo','option');
    $contenido_fijo_imagen = get_field('contenido_fijo_imagen','option');
    ?>

	<section id="<?php echo esc_attr($id); ?>" class="banner-slider" style="background: url(<?php echo $imagen_de_fondo; ?>) no-repeat center; background-size: cover;    background-color: var(--main-color); background-blend-mode: multiply;">
		<div class="container">
			<div class="row">
				<span class="h2 strong text-center"><?php echo $pretitulo; ?></span>
				<span class="h2 text-center p-0 m-0"><?php echo $titulobanner; ?></span>
				<div id="carouselbannerslider" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-inner">
						<?php

						// Check rows exists.
						if( have_rows('contenido','option') ):
						$count = 0;
						$counttotalbanner = count(get_field('contenido','option'));

						// Loop through rows.
						while( have_rows('contenido','option') ) : the_row();

						// Load sub field value.

						$textoextra = get_sub_field('textoextra','option');
						?>
						<div class="carousel-item <?php if($count == 0) { echo 'active';} ?>">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="centrar">
										<?php if($textoextra): ?>
										<?php echo $textoextra; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<?php $count++;
						// End loop.
						endwhile;

						endif;
						?>    
					</div>
					<?php if($counttotalbanner > 1): ?>
					<div class="carousel-indicators">
						<?php
						for ($k = 0 ; $k < $counttotalbanner; $k++){ 
							echo'<button type="button" data-bs-target="#carouselbannerslider" data-bs-slide-to="';
							echo $k;
							echo '" class="';
							if($k == 0) { echo 'active';}
							echo '" aria-current="true" aria-label="Slide ';
							echo $k;
							echo '"></button>';
						}
						?> 
					</div>
					<?php endif; ?>
				</div>
				<div class="centrar-vert">
					<?php if( !empty( $contenido_fijo_imagen ) ): ?>
					<img src="<?php echo esc_url($contenido_fijo_imagen['url']); ?>" alt="<?php echo esc_attr($contenido_fijo_imagen['alt']); ?>" />
					<?php endif; ?>
					<div class="contenido"><?php echo $contenido_fijo; ?></div>
				</div>

				<?php 
				if( $enlace ): 
				$link_url = $enlace['url'];
				$link_title = $enlace['title'];
				$link_target = $enlace['target'] ? $enlace['target'] : '_self';
				?>
				<a class="cta-button secundario" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();