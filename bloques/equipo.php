<?php 
/*          'name'              => 'Equipo',
            'title'             => __('Bloque con todo el equipo'),
            'description'       => __('Bloque con todo el equipo'), */

/**
 * Equipo Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'equipo-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'equipo';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="contenedor100">        
        <div class="equipo-contenedor">
        <?php 
            // The Query
            $args = array(
                // Arguments for your query.
                'posts_per_page'  => -1,
                'offset'          => 0,
                'post_type'       => 'equipo',
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
                $puesto_de_trabajo = get_field('puesto_de_trabajo', $id);
                $campo_de_trabajo = get_field_object('campo_de_trabajo', $id);
                $campo_de_trabajovalue = $campo_de_trabajo['value'];
                $campo_de_trabajovaluevalue = $campo_de_trabajovalue['value'];
                $campo_de_trabajolabel = $campo_de_trabajo['label'];
                $campo_de_trabajolabellabel = $campo_de_trabajovalue['label'];
                $icono = get_field('icono', $id);
                ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('card ' . esc_attr($campo_de_trabajovaluevalue) ); ?> >
                <div class="fila">

                    <div class="imagen-contenedor">
                        <?php the_post_thumbnail(); ?>
                    </div>

                    <div class="card-body">
                        <div class="contenido-texto">
                            <?php if( !empty( $icono ) ): ?>
                            <div class="overlay-img">
                                <img class="icono" src="<?php echo esc_url($icono['url']); ?>" alt="<?php echo esc_attr($icono['alt']); ?>" />
                            </div>
                            <?php endif; ?>
                            <!-- <span class="small"><?php //echo esc_html($campo_de_trabajolabellabel);?></span> -->
                            <span class="h3 card-title"><?php the_title(); ?></span>
                            <span class="puesto"><?php echo $puesto_de_trabajo;?></span>

                        </div>
                    </div>

                </div>
                
                
            </article>
            <?php
            }
            }
            // Restore original post data.
            wp_reset_postdata();
             ?>
        </div>
    </div>

</section>


    