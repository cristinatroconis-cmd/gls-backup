<?php 
/*          'name'              => 'noticias',
            'title'             => __('Últimas entradas del blog'),
            'description'       => __('Mostrar las últimas entradas del blog'), */

/**
 * noticias Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'noticias-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'noticias';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$cta = get_field('cta');
$textoenlaceentradas = get_field('textoenlaceentradas');
$enlace_cta = get_field('enlace_cta');
//$categoria = get_field('categoria'); Activar y añadir el campo de texto en ACF para hacer loop solo de una categoría de entradas
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row flex-column justify-content-center mb-4">

            <?php if($titulo): ?>
            <h2 class="text-center"><?php echo $titulo; ?></h2>
            <?php endif; ?>

            <?php if($subtitulo): ?>
            <h4 class="text-center"><?php echo $subtitulo; ?></h4>
            <?php endif; ?>

        </div>

        <div class="col-md-12 col-12 blog-loop  d-lg-none">
            <div class="row">
                <div id="cat-slider">
                    <div id="news-flex-slider-movil" class="carousel slide slider_box" data-bs-ride="carousel">
                        <!-- <ol class="carousel-indicators slider-dots">
                            <li data-target="#news-flex-slider-movil" data-slide-to="0" class="active slider-dot"></li>
                            <li data-target="#news-flex-slider-movil" data-slide-to="1" class="slider-dot"></li>
                            <li data-target="#news-flex-slider-movil" data-slide-to="2" class="slider-dot"></li>
                        </ol> -->
                        <!--CAROUSEL MOVIL -->
                        <div class="carousel-inner">
                            
                            <?php 
                            // The Query
                            $args = array(
                                // Arguments for your query.
                                'posts_per_page'  => 3,
                                'offset'          => 0,
                                'orderby'         => 'post_date',
                                'order'           => 'DES',
                                'post_type'       => 'post',
                                //'category_name'   => $categoria,
                                'post_status'     => 'publish',
                                'suppress_filters' => true ); 
                             
                            // Custom query.
                            $query = new WP_Query( $args );
                             
                            // Check that we have query results.
                            if ( $query->have_posts() ) {
                                $counter = 0;
                                // Start looping over the query results.
                                while ( $query->have_posts() ) {
                                    
                                    $query->the_post(); ?>
                            <div class="carousel-item <?php if ( $counter == 0 ) {echo 'active';} ?>">
                                <div class="row carousel-loop-category">
                                    <div class="elem col-12">
                                        <div class="img-container">
                                            <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
                                                <?php the_post_thumbnail('card-thumbnail'); ?>
                                                <div class="card-body">
                                                    <p class="small"><?php echo get_the_date(); ?></p>
                                                    <h4 class="card-title"><?php the_title(); ?></h4>
                                                    <div class="excerpt">
                                                        <?php echo the_excerpt(); ?>
                                                    </div>

                                                    <a href="<?php the_permalink();?>" class="read_more plas">
                                                        <span><?php echo $textoenlaceentradas; ?></span>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                                
                                    </div>
                                </div>
                            </div>
                                <?php 
                                $counter++; 
                                    }
                                }
                                // Restore original post data.
                                wp_reset_postdata(); ?>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#news-flex-slider-movil" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#news-flex-slider-movil" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 blog-loop d-none d-lg-block">
            <div class="row">
                <?php 
                // The Query
                $args = array(
                    // Arguments for your query.
                    'posts_per_page'  => 3,
                    'offset'          => 0,
                    'orderby'         => 'post_date',
                    'order'           => 'DES',
                    'post_type'       => 'post',
                    //'category_name'   => $categoria,
                    'post_status'     => 'publish',
                    'suppress_filters' => true ); 
                 
                // Custom query.
                $query = new WP_Query( $args );
                 
                // Check that we have query results.
                if ( $query->have_posts() ) {
                 
                    // Start looping over the query results.
                    while ( $query->have_posts() ) {
                 
                    $query->the_post(); ?>
                <div class="elem col-md-10 col-lg-4 mb-5">
                    <div class="img-container">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
                            <?php the_post_thumbnail('card-thumbnail'); ?>
                            <div class="card-body">
                                <p class="small"><?php echo get_the_date(); ?></p>
                                <h4 class="card-title"><?php the_title(); ?></h4>
                                <div class="excerpt">
                                    <?php echo the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink();?>" class="read_more plas">
                                    <span><?php echo $textoenlaceentradas; ?></span>
                                </a>
                            </div>
                        </article>
                    </div>                
                </div>
            <?php }}
            // Restore original post data.
            wp_reset_postdata(); ?>
            </div>
        </div>
        <?php if($cta): ?>
        <div class="row boton justify-content-center">
            <a href="<?php echo $enlace_cta; ?>" class="cta-button"><?php echo $cta; ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>



    