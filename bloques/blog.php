<?php 
/*          'name'              => 'blog',
            'title'             => __('Feed de entradas'),
            'description'       => __('Mostrar todas las entradas con filtro lateral'), */

/**
 * blog Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'blog-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blog';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
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
        <div class="row">
            <div class="col-md-9 blog-loop">
                <div class="row">
                    <?php 
                    // The Query
                    $args = array(
                        // Arguments for your query.
                        'posts_per_page'  => -1,
                        'offset'          => 0,
                        'orderby'         => 'post_date',
                        'order'           => 'DES',
                        'post_type'       => 'post',
                        'post_status'     => 'publish',
                        'suppress_filters' => true ); 
                     
                    // Custom query.
                    $query = new WP_Query( $args );
                     
                    // Check that we have query results.
                    if ( $query->have_posts() ) {
                     
                        // Start looping over the query results.
                        while ( $query->have_posts() ) {
                     
                        $query->the_post(); ?>
                    <div class="elem col-md-6 col-lg-4 mb-5">
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
                                        <span><i class="fas fa-plus"></i></span>
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
            <div class="col-md-3 col-12 sidebar">
                <?php dynamic_sidebar( 'sidebar' ); ?>
            </div>
        </div>
    </div>
</section>



    