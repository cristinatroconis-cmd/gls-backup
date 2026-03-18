<?php 
/*          'name'              => 'productos',
            'title'             => __('Listado de productos'),
            'description'       => __('Listado de productos'), */

/**
 * Productos Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'productos-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'productos';
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
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row flex-column justify-content-center mb-4">
            <h2 class="text-center"><?php echo $titulo; ?></h2>
            <h4 class="text-center"><?php echo $subtitulo; ?></h4>
        </div>
        <div class="col-12 blog-loop">
            <div class="row column justify-content-center">
                <?php 
                // The Query
                $args = array(
                    // Arguments for your query.
                    'posts_per_page'  => 4,
                    'offset'          => 0,
                    'post_type'       => $categoria,
                    'tag'             => '',
                    'orderby'         => 'post_date',
                    'order'           => 'DES',
                    'post_status'     => 'publish',
                    'suppress_filters' => true ); 
                 
                // Custom query.
                $query = new WP_Query( $args );
                 
                // Check that we have query results.
                if ( $query->have_posts() ) {
                     
                // Start looping over the query results.
                while ( $query->have_posts() ) {
            
                    $query->the_post();
                    $id = get_the_ID();
                    $imagen_del_listado_de_productos = get_field('imagen_del_listado_de_productos', $id);
                    ?>
                <div class="col-md-6 col-lg-3">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
                    <?php if($imagen_del_listado_de_productos): ?>
                        <img class="card-img-top placeholder" src="<?php echo $imagen_del_listado_de_productos; ?>" alt="<?php the_title(); ?>" />
                    <?php else: ?>
                        <?php the_post_thumbnail('card-thumbnail'); ?>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="contenido-texto">
                                <h4 class="card-title"><?php the_title(); ?></h4>
                                <div class="back-card d-none d-md-flex"><!-- d-none d-md-block -->
                                    <?php echo the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink();?>" class="read_more more-arrow ">
                                    <span>Ver más <i class="fas fa-arrow-right"></i></span><!-- d-md-block d-lg-none -->
                                </a>
                            </div>
                            
                        </div>
                    </article>
                </div>
                <?php
                }
                }
                // Restore original post data.
                wp_reset_postdata();
                 ?>            
            </div>
        </div>
        <?php if($cta): ?>
        <div class="row boton justify-content-center">
            <a href="<?php echo $enlace_cta; ?>" class="cta-button"><?php echo $cta; ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>

    