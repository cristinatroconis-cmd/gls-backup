<?php 
/*          'name'              => 'puntos-fuertes2',
            'title'             => __('Valores2'),
            'description'       => __('Cajas con valores'), */

/**
 * Puntos fuertes Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'puntos-fuertes-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'puntos-fuertes';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="bullet container mb-3">
        <div class="row align-items-start position-relative">
            <div class="offset-lg-1 col-lg-10 col-md-12 bg-white">
                <div class="row fila-horizontal-responsive">
                    <?php

                    // Check rows exists.
                    if( have_rows('bullets') ):

                    // Loop through rows.
                    while( have_rows('bullets') ) : the_row();

                    // Load sub field value.
                    $imagen = get_sub_field('imagen');
                    $titulo = get_sub_field('titulo');
                    $contenido = get_sub_field('contenido');
                    ?>
                    <div class="col-md-3 p-0">
                        <div class="cuadrado2">
                            <span class="h5"><?php echo $titulo; ?></span>
                            <span><?php echo $contenido; ?></span>
                        </div>
                    </div>    
                    <?php
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                        // Do something...
                    endif;
                    ?>    
                </div>
            </div>  
        </div>
    </div>
</section>

    