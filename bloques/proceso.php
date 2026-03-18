<?php 
/*          'name'              => 'proceso',
            'title'             => __('Proceso'),
            'description'       => __('Proceso con pasos e imagen'), */

/**
 * Proceso Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'proceso-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'proceso';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$imagen = get_field('imagen');
$cta = get_field('cta');
$enlacecta = get_field('enlacecta');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> steps">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center">
                <img src="<?php echo $imagen; ?>" alt="<?php echo $titulo; ?>" />
            </div>
            <div class="col-lg-6">
                <h5><?php echo $subtitulo; ?></h5>
                <h2><?php echo $titulo; ?></h2>
                <?php
                // Check rows exists.
                if( have_rows('pasos') ):
                // Loop through rows.
                while( have_rows('pasos') ) : the_row();
                // Load values and assing defaults.
                $imagenrep = get_sub_field('imagen');
                $titulorep = get_sub_field('titulo');
                $subtitulorep = get_sub_field('subtitulo');
                ?>
                <div class="row mb-4">
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img class="step" src="<?php echo $imagenrep; ?>" alt="<?php echo $titulorep; ?>" />
                    </div>     
                    <div class="col-9">
                        <h3><?php echo $titulorep; ?></h3>
                        <p><?php echo $subtitulorep; ?></p>
                    </div>           
                </div>
                <?php
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                        
                    endif;
                ?>
            </div>
        </div>
        <?php if($cta): ?>
        <div class="row boton justify-content-center">
            <a href="<?php echo $enlacecta; ?>" class="cta-button"><?php echo $cta; ?></a>
        </div>
    <?php endif; ?>
    </div>
</section>
