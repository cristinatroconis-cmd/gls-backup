<?php 
/*          'name'              => 'banner-slider',
            'title'             => __('Contenido con diapositivas'),
            'description'       => __('Bloque para añadir contenido en varias diapositivas'), */

/**
 * slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'banner-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'banner-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$imagen_de_fondo = get_field('imagen_de_fondo');
$pretitulo = get_field('pretitulo');
$titulo = get_field('titulo');
$enlace = get_field('enlace');
$contenido_fijo = get_field('contenido_fijo');
$contenido_fijo_imagen = get_field('contenido_fijo_imagen');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>" style="background: url(<?php echo $imagen_de_fondo; ?>) no-repeat center; background-size: cover;    background-color: var(--main-color);
    background-blend-mode: multiply;">
    <div class="container">
        <div class="row">
            <span class="h2 strong text-center m-0"><?php echo $pretitulo; ?></span>
            <span class="h2 text-center p-0 m-0"><?php echo $titulo; ?></span>
            <div id="carouselbannerslider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php

                    // Check rows exists.
                    if( have_rows('contenido') ):
                    $count = 0;
                    $counttotalbanner = count(get_field('contenido'));

                    // Loop through rows.
                    while( have_rows('contenido') ) : the_row();

                    // Load sub field value.
                    
                    $textoextra = get_sub_field('textoextra');
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

    