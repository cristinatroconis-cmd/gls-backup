<?php 
/*          'name'              => 'texto-imagen',
            'title'             => __('Texto con imagen'),
            'description'       => __('Texto con imagen'), */

/**
 * texto-imagen Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'texto-imagen-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'texto-imagen';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$contenido = get_field('contenido');
$imagen = get_field('imagen');
$orden = get_field('orden');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container-fluid">        
        <div class="row position-relative <?php echo $orden; ?>">
            <?php if( $contenido ): ?>
            <div class="col-12 col-md-6 background-grey">
                <div class="row">   
                    <div class="col-md-10 col-lg-10 offset-lg-1 text-team">
                        <?php echo $contenido; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if( $imagen ): ?>
            <div class="col-12 col-md-6 foto">
                    <img class="img-sobre <?php echo $tamano; ?>" src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" />
            </div>
            <?php endif; ?>
        </div>
    </div>

</section>

    