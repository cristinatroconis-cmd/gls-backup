<?php 
/*          'name'              => 'seleccionados',
            'title'             => __('Productos seleccionados'),
            'description'       => __('Selección de productos'), */

/**
 * Productos Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'seleccionados-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'seleccionados';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$categoria = get_field('categoria');
$cta = get_field('cta');
$enlace_cta = get_field('enlace_cta');
$seleccionados = get_field('seleccionados');
?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> productos apartamentos-slider">
    <div class="apartamentos-container-slide">
    <?php 
        foreach( $seleccionados as $featured_post ):
            $permalink = get_permalink( $featured_post->ID );
            $title = get_the_title( $featured_post->ID );
            $id = $featured_post->ID;
            $featured_img_url = get_the_post_thumbnail_url($id,'medium_large');
            $titulo_linea_de_arriba = get_field('titulo_linea_de_arriba',$id);
            $titulo_linea_de_abajo = get_field('titulo_linea_de_abajo',$id);
            $personas = get_field('personas',$id);
            $dormitorios = get_field('dormitorios',$id);
            $banos = get_field('banos',$id);

    ?>
        <div class="apartamentos-carousel-item container" style="background-image: url('<?php echo get_the_post_thumbnail_url($featured_post->ID, 'full'); ?>');">
           
                <div class="imagen-con-overlay">
                    <!-- <img src="<?php echo get_the_post_thumbnail_url($featured_post->ID, 'full'); ?>" alt="<?php echo get_the_title($featured_post->ID); ?>"> -->
                    <div class="apartamento-imagen-overlay"></div>
                </div>
                <div class="apartamentos-carousel-caption">
                    <h3><?php echo get_the_title($featured_post->ID); ?></h3>
                    <div class="apartamentos-info-divider">
                        <span class="apartamento-elemento-divider"></span>
                    </div>
                    <p><?php echo get_the_excerpt($featured_post->ID); ?></p>
                    <a href="<?php echo get_permalink($featured_post->ID); ?>"><?php _e('Descúbrelo', 'granadaluxury'); ?></a>
                </div>
                
        </div>
    <?php 
        endforeach; 
    ?>
    </div>            

        <?php 
            if( $cta ): 
            $link_url = $cta['url'];
            $link_title = $cta['title'];
            $link_target = $cta['target'] ? $cta['target'] : '_self';
            ?>
            <div class="d-flex justify-content-center">
                <a class="cta-button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            </div>
            
        <?php endif; ?>
</section>


    