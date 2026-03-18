<?php 
/*          'name'              => 'banner-datos',
            'title'             => __('Banner con datos'),
            'description'       => __('Banner con datos'),
*/
/**
 * banner-datos Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'banner-datos-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'banner-datos';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row">
            <?php
            // Check rows exists.
            if( have_rows('bloque_de_datos') ):
            // Loop through rows.
            while( have_rows('bloque_de_datos') ) : the_row();
            // Load values and assing defaults.
            $prefijo = get_sub_field('prefijo');
            $numero = get_sub_field('numero');
            $sufijo = get_sub_field('sufijo');
            $texto_complementario = get_sub_field('texto_complementario');

            ?>
            <div class="col-12 col-lg-4 bullet text-center number">
                <h3 class="">
                    <?php echo $prefijo; ?> 
                    <span class="count"><?php echo $numero; ?></span> 
                    <?php echo $sufijo; ?>
                </h3>
                <h5><?php echo $texto_complementario; ?></h5>
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
</section>

    