<?php get_header(); 
$tipo = isset($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : '';

?>

<main id="main" class="site-main">
    <article>
    	<section id="cabecera-block_6229f1519f61e" class="cabecera">
    
   
      		<?php $imagen_de_la_cabecera = get_field('imagen_de_la_cabecera');?>
      		<img src="<?php echo esc_url($imagen_de_la_cabecera['url']); ?>" alt="<?php the_title(); ?>" class="" />
			<div class="container-fluid padding-cabecera centrar">        
				<div class="row position-relative">
				  <div class="col-12 col-md-12 centrar">
					<?php
					  $titulo_linea_de_arriba = get_field('titulo_linea_de_arriba');
					  $titulo_linea_de_abajo = get_field('titulo_linea_de_abajo');
					  ?>
					  <h1 class="d-none"><?php echo $titulo_linea_de_arriba; ?> <?php echo $titulo_linea_de_abajo; ?></h1>
					  <span class="h1 strong bellmt white"><?php echo $titulo_linea_de_arriba; ?></span>
					  <span class="h1 bellmt white text-center"><?php echo $titulo_linea_de_abajo; ?></span>
					</div>
				</div>
      		</div>
		</section>
		<section class="page-pred">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-12 team-single-content">
						<?php 
						// Check rows exists.
						if( have_rows('fotografias') ):
							$e = 0;
						?>
						<?php $url_matterport = get_field('enlaceMatterport');?>
						<?php 
						// Comprobar que tenga url_matterport
						if( !empty($url_matterport ) ):
						?>
							<div class="tabs-apartamentos">
								<div class="left-tab">
									<button class="bt-apartamentos active" data-target="#carouselapartamentos">Galería</button>
								</div>
								<div class="right-tab">
									<button class="bt-tour tablinks" data-target="#tourVirtual">Tour Virtual</button>
								</div>
							</div>
						<?php endif;?>
							<div id="carouselapartamentos" class="carousel slide">
							<div class="carousel-indicators">
								<?php
								// Loop through rows.
								while( have_rows('fotografias') ) : the_row(); ?>
							
								<button type="button" data-bs-target="#carouselapartamentos" data-bs-slide-to="<?php echo $e; ?>" class="<?php if($e==0){echo 'active';}?>" aria-current="true" aria-label="Slide <?php echo $e+1; ?>"></button>
								<?php
								// End loop.
								$e++;
								endwhile;
								endif;
	
								// Check rows exists.
								if( have_rows('fotografias') ):
								$a = 0;
								?>
								</div>
								<div class="carousel-inner">
								<?php
								// Loop through rows.
								while( have_rows('fotografias') ) : the_row();
								// Load sub field value.
								$foto = get_sub_field('foto'); ?>
								<div class="carousel-item <?php if($a==0){echo 'active';}?>">
									<img class="d-block w-100" src="<?php echo esc_url($foto['url']); ?>" alt="<?php echo esc_attr($foto['alt']); ?>" />
								</div>
								<?php
								// End loop.
								$a++;
								endwhile;
								?>
								</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselapartamentos" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselapartamentos" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
							</div>
						<?php 
						// Comprobar que tenga url_matterport
						if( !empty($url_matterport )  ):
						?>
						<div id="tourVirtual" class="disabled">
							<iframe src="<?=$url_matterport?>" width="100%" height="500px" style="border:none;"></iframe>
						</div>
						<?php endif;?>
							<?php
							else: ?>
							<div class="thumbnail-single-block"><?php the_post_thumbnail('medium_large'); ?></div>
							<?php endif; ?>
                        <div class="_description_box pt-5">
                            <div class="_description">
                                <p class="bellmt h3 m-0"><strong><?php echo $titulo_linea_de_arriba; ?></strong></p>
                                <p class="bellmt h3"><?php echo $titulo_linea_de_abajo; ?></p>
                            </div>
                        </div>
                           <?php

                                // Check rows existexists.
                                if( have_rows('datos_del_apartamento',$id) ):
                                ?>
                                <div class="datos_apartamento mb-4 d-flex border-top border-bottom border-2 pt-4 pb-4">
                                <?php
                                // Loop through rows.
                                while( have_rows('datos_del_apartamento',$id) ) : the_row();

                                // Load sub field value.
                                $icono_del_dato = get_sub_field('icono_del_dato');
                                $texto_que_acompana_al_icono = get_sub_field('texto_que_acompana_al_icono');
                                // Do something...
                                ?>
                                <div style="padding-right: 3rem;" class="d-flex">
                                    <div class="d-flex info-apartamentos">
                                    <?php 
                                    if( !empty( $icono_del_dato ) ): ?>
                                        <img src="<?php echo esc_url($icono_del_dato['url']); ?>" alt="<?php echo esc_attr($icono_del_dato['alt']); ?>" />
                                    <?php endif; ?>
                                    
										<div class="lista-inicio">
											<p class="bebasneue" style="margin: 0px; font-size: 22px"><?php echo $texto_que_acompana_al_icono; ?></p>
										</div>
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
						<div class="content the-content">
						 <?php the_content(); ?>

                            <?php
                                $mas_informacion = get_field('mas_informacion');
                            ?>
                        <?php if( !empty( $mas_informacion ) ): ?>
						 <p>
  								<a class="" data-bs-toggle="collapse" href="#collapseExample"  aria-expanded="false" aria-controls="collapseExample">
    								Más información
  								</a>
  							</p>
  							<div class="collapse" id="collapseExample">
		  						<div class="mb-4">
		   						<?php echo $mas_informacion; ?>
		  						</div>
							</div>
                              <?php
                                endif;
                                ?>
						

						 	<div class="d-flex border-top border-2 pt-5 pb-3">
	                            <div>
	                                <img class="icono-img" src="/wp-content/uploads/Grupo-105.svg" width="60px">
	                            </div>
	                            <div class="lista-inicio d-flex align-items-center">
	                                <h2 class="bebasneue">Equipamiento</h2>
	                               
	                            </div>
                        	</div>
							<ul class="no-list-style pb-5">
								<?php if( get_field('lista_de_equipamiento') ): ?>
								<?php while( the_repeater_field('lista_de_equipamiento') ): ?>       
								<li><strong><i class="fa-solid fa-check"></i></strong><?php the_sub_field('nombre_del_equipamiento'); ?></li>
								<?php endwhile; ?>
								<?php endif; ?>
							</ul>

                        	<div class="d-flex border-top border-2 pt-5 pb-3">
	                            <div>
	                                <img class="icono-img" src="/wp-content/uploads/Grupo-85.svg" width="60px">
	                            </div>
	                            <div class="lista-inicio d-flex align-items-center">
	                                <h2 class="bebasneue">SERVICIOS</h2>
	                               
	                            </div>
                        	</div> 
                        		 <ul class="no-list-style pb-5">
                                            <?php if( get_field('lista_de_servicios') ): ?>
                                            <?php while( the_repeater_field('lista_de_servicios') ): ?>       
                                            <li><strong><i class="fa-solid fa-angle-right"></i></strong><?php the_sub_field('nombre_del_servicio'); ?></li>
                                            <?php endwhile; ?>
                                            <?php endif; ?>
                               </ul>
                        

                        	<div class="d-flex border-top border-2 pt-5 pb-3">
	                            <div>
	                                <img class="icono-img" src="/wp-content/uploads/Grupo-98.svg" width="60px">
	                            </div>
	                            <div class="lista-inicio d-flex align-items-center">
	                                <h2 class="bebasneue">NORMAS DEL APARTAMENTO</h2>
	                               
	                            </div>
                        	</div>
                        		 <ul class="no-list-style pb-5">
                                            <?php if( get_field('lista_de_normas_del_apartamento') ): ?>
                                            <?php while( the_repeater_field('lista_de_normas_del_apartamento') ): ?>       
                                            <li><strong><i class="fa-solid fa-angle-right"></i></strong><?php the_sub_field('norma'); ?></li>
                                            <?php endwhile; ?>
                                            <?php endif; ?>
                               </ul>


                        	<div class="d-flex border-top border-2 pt-5 pb-3">
	                            <div>
	                                <img class="icono-img" src="/wp-content/uploads/asesoria.svg" width="60px">
	                            </div>
	                            <div class="lista-inicio d-flex align-items-center">
	                                <h2 class="bebasneue">información adicional</h2>
	                               
	                            </div>
                        	</div>
                        		 <ul class="no-list-style pb-5">
                                            <?php if( get_field('lista_de_informacion_adicional') ): ?>
                                            <?php while( the_repeater_field('lista_de_informacion_adicional') ): ?>       
                                            <li><strong><i class="fa-solid fa-angle-right"></i></strong><?php the_sub_field('detalle_de_la_informacion_adicional'); ?></li>
                                            <?php endwhile; ?>
                                            <?php endif; ?>
                               </ul>
							<!-- INFORMACIÓN ADICIONAL -->
							<div class="d-flex border-top border-2 pt-5 pb-3">
	                            <div>
									<?php 
									$icono_del_campo_personalizado = get_field('icono_del_campo_personalizado');
									if( !empty( $icono_del_campo_personalizado ) ): ?>
										<img width="60px" class="icono-img" src="<?php echo esc_url($icono_del_campo_personalizado['url']); ?>" alt="<?php echo esc_attr($icono_del_campo_personalizado['alt']); ?>" />
									<?php endif; ?>
	                            </div>
	                            <div class="lista-inicio d-flex align-items-center">
									<?php
									$titulo_del_campo_personalizado = get_field('titulo_del_campo_personalizado') ?>
	                                <h2 class="bebasneue"><?php echo $titulo_del_campo_personalizado; ?></h2>
	                               
	                            </div>
                        	</div>
							<ul class="no-list-style pb-5">
								<?php if( get_field('lista_del_campo_personalizado') ): ?>
								<?php while( the_repeater_field('lista_del_campo_personalizado') ): ?>       
								<li class="campo-pers-lista"><strong><i class="fa-solid fa-check"></i></strong><?php the_sub_field('datos_del_campo_personalizado'); ?></li>
								<?php endwhile; ?>
								<?php endif; ?>
							</ul>
						
						</div>

					

					</div>
					  <div class="col-md-3 col-lg-3 col-12">
                        <div class="sidebar-apartamento mb-5">
                            <?php
                                $titulo_en_el_cajetin = get_field('titulo_en_el_cajetin');
                                $texto_del_cajetin = get_field('texto_del_cajetin');
                            ?>
                            <div class="info-apartamento" id="info-apartamento">
                                    <span class="h5 d-block titulo-caja bebasneue mb-2"><?php echo $titulo_en_el_cajetin; ?></span>
                                    <?php echo $texto_del_cajetin; ?>
                           
                                    <?php if( !empty( get_field('duracion') ) || !empty( get_field('sesiones') ) ): ?>
                                    <div class="d-flex justify-content-start flex-column sesionesduracion pt-3">
                                        <?php if( !empty( get_field('duracion') ) ): ?>
                                        <div class="grey"><i class="fa-solid fa-hourglass-half grey"></i> <?php the_field('duracion');?></div>
                                        <?php endif; ?>
                                        <?php if( !empty( get_field('sesiones') ) ): ?>
                                        <div class="grey"><i class="fa-solid fa-calendar grey"></i> <?php the_field('sesiones');?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-lg-8 col-12 d-md-none d-lg-block">
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

                                <div class="d-flex info-apartamentos">
                                    <div>
                                    <?php 
                                    if( !empty( $icono_del_dato ) ): ?>
                                        <img src="<?php echo esc_url($icono_del_dato['url']); ?>" alt="<?php echo esc_attr($icono_del_dato['alt']); ?>" />
                                    <?php endif; ?>
                                    </div>
                                    <div class="lista-inicio">
                                        <p class="bebasneue" style="margin: 0px; font-size: 16px; text-transform: uppercase;"><?php echo $texto_que_acompana_al_icono; ?></p>
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
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <?php
										if ($tipo === 'temporada') {
											// Incluir la plantilla específica para temporadap
											$precio = get_field('precio_alquiler_temporada');
											$variable_de_precio = get_field('variable_precio_temporada');
										} else {
											// Incluir la plantilla estándar
											$precio = get_field('precio');
											$variable_de_precio = get_field('variable_de_precio');
										}
                                                                          
                                     $email = get_field('email');

                                ?>
                                 <div class="precio bebasneue mt-3">
                                    <span class="variable"><?php _e('Desde', 'granadaluxury'); ?></span><br> <?php echo $precio; ?><span class="variable"><?php echo $variable_de_precio; ?></span>

                                </div>
                                    </div>
                                </div>
                              

                        

                                 <div class="mb-2 phone-sidebar">
                                    <?php 
                                    $numero_de_telefono = get_field('numero_de_telefono');
                                    if( $numero_de_telefono): 
                                            $numero_de_telefono_url = $numero_de_telefono['url'];
                                            $numero_de_telefono_title = $numero_de_telefono['title'];
                                            $numero_de_telefono_target = $numero_de_telefono['target'] ? $numero_de_telefono['target'] : '_self';
                                    ?>
                                         <strong><i class="fa-brands fa-whatsapp" style="padding-right: 5px;"></i></strong>   <a class="" href="<?php echo esc_url( $numero_de_telefono_url ); ?>" target="<?php echo esc_attr( $numero_de_telefono_target ); ?>"><?php echo esc_html( $numero_de_telefono_title ); ?></a>
                                    <?php endif; ?>

                                </div>
                                <div class="mb-2 email-sidebar">
                                    <strong><i class="fa-regular fa-envelope" style="padding-right: 5px;"></i></strong>  <a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a>

                        
                                </div>
							 <?php 
                                    $link = get_field('boton_de_reserva');
                                    if( $link ): 
                                    $link_url = $link['url'];
									if ($tipo === 'temporada') {
										// Incluir la plantilla específica para temporadap
										$link_reserva_url = $numero_de_telefono['url'];
										
									} else {
										$link_reserva_url = esc_url( $link_url );
									}
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                <a class="cta-caja secundario mt-4" href="<?php echo $link_reserva_url ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                <?php endif; ?>

                               
                        </div>
					  		
                                
                            </div>
				</div>
			</div>
				<iframe style="border: 0; width: 100%;" src="<?php echo get_field('enlace_del_mapa_en_google_maps'); ?>" width="100%" height="350"></iframe>
		</section>
	</article>
</main>

<?php get_footer(); ?>