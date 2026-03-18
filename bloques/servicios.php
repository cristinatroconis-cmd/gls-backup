<?php 
/*          'name'              => 'servicios',
            'title'             => __('Bloque que muestra todos los servicios'),
            'description'       => __('Bloque para añadir servicios en varias columnas'), */

/**
 * slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'servicios-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'servicios';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$pretitulo = get_field('pretitulo');
$titulo = get_field('titulo');
$enlace = get_field('boton_cta');
$texto_adicional = get_field('texto_adicional');
$columnas = get_field('columnas');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row">
            <span class="h2 strong text-center"><?php echo $pretitulo; ?></span>
            <span class="h2 text-center"><?php echo $titulo; ?></span>
            <div class="columna-2"><?php echo $texto_adicional; ?></div>
            <div class="listado-servicios">
                <div class="columnas-servicios fila-horizontal-responsive columnas-<?php echo $columnas; ?>">
                    <?php

                    // Check rows exists.
                    if( have_rows('servicios') ):
                    // Loop through rows.
                    while( have_rows('servicios') ) : the_row();

                    // Load sub field value.
                    
                    $icono = get_sub_field('icono');
                    $titulo_servicio = get_sub_field('titulo_servicio');
                    $descripcion_servicio = get_sub_field('descripcion_servicio');
                    ?>
                    <div class="servicio">
                        <?php if( !empty( $icono ) ): ?>
                        <img src="<?php echo esc_url($icono['url']); ?>" alt="<?php echo esc_attr($icono['alt']); ?>" />
                        <?php endif; ?>
                        <div class="caja_blanca">
                            <span class="h5 bebasneue"><?php echo $titulo_servicio; ?></span>
                            <?php echo $descripcion_servicio; ?>
                        </div>
                    </div>
                    <?php
                    // End loop.
                    endwhile;
                    
                    endif;
                    ?>    
                </div>
            </div>
                
            <?php 
            if( $enlace ): 
            $link_url = $enlace['url'];
            $link_title = $enlace['title'];
            $link_target = $enlace['target'] ? $enlace['target'] : '_self';
            ?>
            <div class="d-flex justify-content-center">
                <a class="cta-button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            </div>
            <?php endif; ?>

            </div>
        </div>
    </div>
</section>

    