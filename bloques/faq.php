<?php 
/*          'name'              => 'faq',
            'title'             => __('Preguntas frecuentes'),
            'description'       => __('Mostrar un bloque con las preguntas frecuentes'), */

/**
 * faq Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'faq-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'faq';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$pretitulo = get_field('pretitulo');
$cta = get_field('cta');
$enlacecta = get_field('enlacecta');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> steps" data-aos="fade-up" data-aos-duration="3000">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 centrado-verticalmente">
                <?php if($pretitulo): ?>
                <h5 class="mb-3"><?php echo $pretitulo; ?></h5>
                <?php endif; ?>
                <?php if($titulo): ?>
                <h2 class="mb-3"><?php echo $titulo; ?></h2>
                <?php endif; ?>
                <?php if($subtitulo): ?>
                <h4 class=""><?php echo $subtitulo; ?></h4>
                <?php endif; ?>
                
                <?php
                // Check rows exists.
                if( have_rows('pasos') ):
                ?>

                <ul class="icono-lista">
                <?php   
                // Loop through rows.
                while( have_rows('pasos') ) : the_row();
                // Load values and assing defaults.
                $texto = get_sub_field('texto');
                ?>
                    <li><i class="fas fa-check"></i><p><?php echo $texto; ?></p></li>
                <?php
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                ?>        
                </ul>
                <?php endif;
                ?>    
                
            </div>
            <div class="col-lg-6 centrado-verticalmente">
                <div class="accordion" id="accordionfaq">
                <?php
                // Check rows exists.
                if( have_rows('dudas') ):
                $count=0;
                // Loop through rows.
                while( have_rows('dudas') ) : the_row();
                // Load values and assing defaults.
                $tituloduda = get_sub_field('tituloduda');
                $textoduda = get_sub_field('textoduda');
                ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $count; ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $count; ?>" aria-expanded="true" aria-controls="collapse<?php echo $count; ?>">
                              <?php echo $tituloduda; ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $count; ?>" class="accordion-collapse collapse <?php if($count==0) {echo 'show';}?>" aria-labelledby="heading<?php echo $count; ?>" data-bs-parent="#accordionfaq">
                            <div class="accordion-body">
                                <div class="card-body">
                                    <p><?php echo $textoduda; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
                    $count++;
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                        
                    endif;
                ?>    
                </div>
            </div>
            
        </div>
        <?php if($cta): ?>
        <div class="row boton justify-content-center">
            <a href="<?php echo $enlacecta; ?>" class="cta-button"><?php echo $cta; ?></a>
        </div>
    <?php endif; ?>
    </div>
</section>
