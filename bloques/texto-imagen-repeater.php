<?php 
/*          'name'              => 'texto-imagen-repeater',
            'title'             => __('Texto con imagen con repeater'),
            'description'       => __('Texto con imagen con repeater'), */

/**
 * texto-imagen Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'texto-imagen-repeater-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'texto-imagen-repeater';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$cta = get_field('cta');
$enlace_cta = get_field('enlace_cta');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">        

            <?php

// Check rows exists.
if( have_rows('contenido-alterno') ):
    $i=0;
    // Loop through rows.
    while( have_rows('contenido-alterno') ) : the_row();

        // Load sub field value.
        $contenido = get_sub_field('contenido');
        $titulo = get_sub_field('titulo');
        $imagen = get_sub_field('imagen');
        $personas = get_sub_field('personas');
        $dormitorios = get_sub_field('dormitorios');
        $banos = get_sub_field('banos');
        $cta2 = get_sub_field('cta2');
        $enlace_cta2 = get_sub_field('enlace_cta2');

        if( $contenido ): ?>
        <div class="row texto-imagen-repeater position-relative flex-row<?php if (($i % 2)==1 ) { echo "-reverse";} ?>"> 
            <div class="col-12 col-md-4 background-grey">
                <div class="row">   
                    <div class="col-md-10 col-lg-10 offset-lg-1 text-team">
                       <h3 class="titulo-apartamentos bellmt"><strong>Luxury Suite</strong><br> <?php echo $titulo; ?></h3>
                        <?php echo $contenido; ?>
                        <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/personas.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $personas; ?> PERSONAS</p>
                               
                            </div>
                        </div>
                        <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/dormitorio.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $dormitorios; ?> DORMITORIOS</p>
                               
                            </div>
                        </div>
                        <div class="d-flex">
                            <div>
                                <img class="icono-img" src="/wp-content/uploads/bano.png" width="45px">
                            </div>
                            <div class="lista-inicio">
                                <p style="margin: 0px;"><?php echo $banos; ?> BAÑOS</p>
                               
                            </div>
                        </div>
                        <?php if($cta2): ?>
                <a href="<?php echo $enlace_cta2; ?>" class="cta-button"><?php echo $cta2; ?></a>    
                <?php endif; ?> 
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if( $imagen ): ?>
            <div class="col-12 col-md-8 foto">
                <img class="" src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" />
            </div>
            <?php endif; ?>
        </div> 
         <?php $i++;
    // End loop.
    endwhile;
    
// No value.
else :
    // Do something...
endif;

?>
        <?php if($cta): ?>
                <a href="<?php echo $enlace_cta; ?>" class="cta-button"><?php echo $cta; ?></a>    
                <?php endif; ?>     

        
    </div>

</section>