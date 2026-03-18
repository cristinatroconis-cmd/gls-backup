<?php
/**
 * Contenido de artículos tipo tarjeta Bootstrap para usar en queries
 */ 

 $permalink = get_permalink( $featured_post->ID );
 $title = get_the_title( $featured_post->ID );

$id = $featured_post->ID;
//echo $featured_post->ID;
                
$featured_img_url = get_the_post_thumbnail_url($featured_post->ID,'medium_large');
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
 $i = 1;
?>
       <div class="card <?php if (($i % 2)==1 ) { echo "col-lg-10 col-md-11 col-12";} else {echo 'col-lg-10 offset-lg-2 col-md-11 offset-md-1 col-12';} ?>">
                <article id="post-<?php echo $featured_post->ID; ?>" class="d-flex flex-row<?php if (($i % 2)==1 ) { echo "-reverse";} ?>" >
                        <?php if(get_the_post_thumbnail($featured_post->ID, 'card-thumbnail')): ?>
                    <div class=" col-12 col-md-6 col-lg-7 imagen-card">
                        <?php
                        echo get_the_post_thumbnail($featured_post->ID, 'card-thumbnail'); 
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
                                $i++;
                                ?>
                                </div>
                                <?php
                                endif;
                                ?>

                                <div class="d-flex justify-content-start">
                                    <a href="<?php the_permalink();?>" class="cta-button">
                                        <span><?php _e('Descúbrelo', 'granadaluxury'); ?></span><!-- d-md-block d-lg-none -->
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </article>
                </div>