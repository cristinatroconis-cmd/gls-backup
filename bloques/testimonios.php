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
$id = 'testimonios-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'testimonios';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$titulo = get_field('titulo');
$contenido = get_field('contenido');
$link = get_field('link');
$url = get_field('url');
$textoboton = get_field('textoboton');
$testimonials = get_field( 'identofmk_testimonials', 'option' );
if ( is_array( $testimonials ) && ! empty( $testimonials ) ):
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> module_testimonials <?php get_row_layout(); ?>">

<!-- BLOQUE TESTIMONIOS -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-head">
                    <?php if($titulo): ?>
                    <h2 class="mini-title" title="Testimonios"><?php echo $titulo; ?></h2>
                    <?php endif; ?>
                </div>

                <div id="carouseltestimonios" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php shuffle( $testimonials ); 
                        $counttesti = 0;
                        foreach ( array_slice( $testimonials, 0, 6 ) as $testimonial ):
                        $counttesti++; ?>
                            <div class="carousel-item <?php if($counttesti == 1){echo ' active';} ?>">
                                <?= apply_filters( 'the_content',
                                    $testimonial['identofmk_testimonials_item_testimonial'] ); ?>
                                <strong><?= $testimonial['identofmk_testimonials_item_name']; ?></strong>
                                <div class="estrellas">
                                <?php $estrellas = $testimonial['identofmk_testimonials_estrellas']; 
                                    if ($estrellas==1) {
                                        echo '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($estrellas==2) {
                                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($estrellas==3) {
                                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                    } elseif ($estrellas==4) {
                                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
                                    } else {
                                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                                    }
                                ?>
                                </div>
                                
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouseltestimonios" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouseltestimonios" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-6">
                <?php echo $contenido; ?>
                <div class="cta">
                    <?php if($textoboton): ?>
                        <?php if($link): ?>
                    <a class="cta-button" href="<?php echo $link; ?>"><?php echo $textoboton; ?></a>
                        <?php else: ?>
                    <a class="cta-button" href="<?php echo $url; ?>"><?php echo $textoboton; ?></a>        
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>    
</section>
<?php endif;?>
    
     <!-- FIN BLOQUE TESTIMONIOS -->
