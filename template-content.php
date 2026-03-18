<?php
/* Template Name: Template Contenido */
get_header();
?>
<main class="contenido">

<section class="resumen">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
               <?php if (function_exists('yoast_breadcrumb') ) { yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); } ?>
                <h1 class="h1"><?php the_title(); ?></h1>
               <?php if(get_the_content() != null):?> 
                   <div class="contenido-principal"><p><?php the_content(); ?></p></div>
               <?php endif;?>
            </div>
        </div>
    </div>
</section>

<section class="alternate-content container">
    <?php $repeater_array = get_repeater_post_meta($post->ID, 'repeater_contenido'); ?>
    <?php foreach($repeater_array as $repeater_elem): ?>
        <div class="row elem mb-5 content-single">            
            <div class="col-12 col-md-5 col-lg-4 img-bloque">
                <?php if(!empty($repeater_elem['imagen_bloque'])):  ?>
                    <?php echo wp_get_attachment_image($repeater_elem['imagen_bloque'][0], 'large'); ?>
                <?php endif; ?>
            </div>

            <div class="col-12 col-md-7 col-lg-8 texto-bloque">
                <?php if(!empty($repeater_elem['titulo_bloque'])):  ?>
                    <h3 class="h3"><?php echo $repeater_elem['titulo_bloque'][0]; ?></h3>
                <?php endif; ?>

                <?php if(!empty($repeater_elem['texto_bloque'])):  ?>
                    <div class="content-bloque">
                        <?php echo apply_filters( 'the_content', $repeater_elem['texto_bloque'][0] ) ; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
</section>
</main>

<?php get_footer(); ?>