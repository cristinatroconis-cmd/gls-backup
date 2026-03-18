<?php get_header(); 
/* Template Name: Template básico */
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$titulooculto = get_field('titulooculto');
?>

<main>
<section id="cabecera-block_6229f1519f61e" class="cabecera">
    
    <?php if (has_post_thumbnail( $post->ID ) ): ?>
      <?php 
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        $imagen_movil = get_field('imagen_movil', $post->ID); ?>
      <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="" />
      
      <div class="container centrar">        
        <div class="row position-relative">
            <div class="centrar">
           
              <h1 class="h1">
                <span class="destacado"><?php
                if (is_category()) { 
                    echo single_cat_title();
                } 
                elseif (is_tag()) {
                    echo single_tag_title();
                }
                else {
                    the_title();
                }?>
                </span>
              </h1>
           
            
            </div>
        </div>
      </div>
    <?php endif; ?>
   
</section>
<div class="content container-fluid">
     <?php if ( function_exists('yoast_breadcrumb') ) {
                          yoast_breadcrumb( '<div id="breadcrumbs" class="d-block mb-3">','</div>' );
                        } ?>
    <div class="row">

            <?php the_content(); ?>
    </div>
</div>
              
  
        
 
</main>



<?php get_footer(); ?>
