<?php 
/*          'name'              => 'slider',
            'title'             => __('Slider'),
            'description'       => __('Slider'), */

/**
 * slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container-fluid">
        <div class="row">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php

                    // Check rows exists.
                    if( have_rows('slide') ):
                    $count = 0;

                    // Loop through rows.
                    while( have_rows('slide') ) : the_row();

                    // Load sub field value.
                    $imageID = get_sub_field('image');
                    $image = wp_get_attachment_image_src( $imageID, 'full' );
                    $alt_text = get_post_meta($imageID , '_wp_attachment_image_alt', true);
                    $titulo = get_sub_field('titulo');
                    $textoextra = get_sub_field('textoextra');
                    $link = get_sub_field('link');
                    $textoboton = get_sub_field('textoboton');
                    ?>
                    <div class="carousel-item <?php if($count == 0) { echo 'active';} ?>">
                        <?php if($imageID): ?>
                        <img src="<?php echo $image[0]; ?>" class="d-block" alt="<?php echo $alt_text; ?>" />
                        <?php endif; ?>
                        <div class="carousel-caption">
                            <?php if($titulo): ?>
                            <span class="titulo-slider h1"><?php echo $titulo; ?></span>
                            <?php endif; ?>
                            <?php if($textoextra): ?>
                            <p><?php echo $textoextra; ?></p>
                            <?php endif; ?>
                            <?php if($textoboton): ?>
                            <a href="<?php echo $link; ?>"><?php echo $textoboton; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $count++;
                    // End loop.
                    endwhile;
                    
                    endif;
                    ?>    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section>

    