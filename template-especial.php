<?php 
    /* Template Name: Template especial */
    get_header();
?>
<main>
<div class="title_box container-fluid">
    <div class="row">
        <div class="content container">    
            <?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );} ?>                
            <h1 class="title"><?php the_title(); ?></h1>
        </div>
    </div>
</div>

<div class="content container">
    <div class="row">
        <div class="col-12">
            <!-- Campo de texto -->
            <p><?php the_field('campo_de_texto','198'); ?></p>
            
            
            
            <!-- Campo de Área de texto -->
            <?php the_field('area_de_texto'); ?>
            
            
            
            <!-- Campo de Editor Wysiwyg -->
            <?php the_field('editor_wysiwyg'); ?>
            
            
            
            
            <!-- Campo de Editor Wysiwyg -->
            <?php if( get_field('mapa') ): ?>
	           <div style="background-color:red;">
                   <p>My field value:
                   <?php the_field('mapa'); ?>
                   </p>
                </div>
            <?php endif; ?>
            
            
            <!-- Campo de Imagen -->
            
            <?php 
            $image = get_field('imagen');
            if( !empty( $image ) ): ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            <?php endif; ?>
            
            
            
            <!-- Campo de repetidor -->
            
            <?php if( have_rows('repetidor') ): ?>

            <ul>

            <?php while( have_rows('repetidor') ): the_row(); 

                // vars
                $name = get_sub_field('nombre');
                $content = get_sub_field('parrafo');

                ?>

                <li style="background-image:url('<?php echo $name; ?>')">

                    <p><?php echo $name; ?></p>
                    <p><?php echo $content; ?></p>

                </li>

            <?php endwhile; ?>

            </ul>

        <?php endif; ?>
            
            <?php the_content(); ?>
            
            
            
            <!-- BLOQUE TESTIMONIOS -->
    
    <?php $testimonials = get_field( 'identofmk_testimonials', 'option' ); ?>
    <?php if ( is_array( $testimonials ) && ! empty( $testimonials ) ): ?>
    <section class="module_testimonials <?= get_row_layout(); ?>">
        <div class="container">
            <div class="section-head">
                <h1 class="mini-title" title="Testimonios"><em>Testimonios</em></h1>
            </div>
            <div class="module-content">
                <div class="owl-carousel owl-theme owl-carousel-default">
					<?php shuffle( $testimonials ); ?>
					<?php foreach ( array_slice( $testimonials, 0, 6 ) as $testimonial ): ?>
                        <div class="owl-carousel-item owl-carousel-default-item article col">
							<?= apply_filters( 'the_content',
								$testimonial['identofmk_testimonials_item_testimonial'] ); ?>
                            <strong><?= $testimonial['identofmk_testimonials_item_name']; ?></strong>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </div>    
    </section>
    <?php endif;?>
    
     <!-- FIN BLOQUE TESTIMONIOS -->
            
            
            
            
        </div>
    </div>
</div>

</main>

<?php get_footer(); ?>
