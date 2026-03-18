<?php 
    /* Template Name: Template Contacto Nueva */
    get_header();
    $titulo = get_field('titulo');
$subtitulo = get_field('subtitulo');
$titulooculto = get_field('titulooculto');
?>
<main>
<div class="page-pred">
        <header class="row header-box d-none">
            <div class="col-12">
                <?php if($titulooculto): ?>
                <h1 class="text-center"><?php echo $titulooculto; ?></h1>
                <?php else: ?>
                <h1 class="title-blue"><?php the_title(); ?></h1>
                <?php endif; ?>
            </div>
        </header>
        <div class="row content-box">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

<div class="content container">
    
               <?php if ( function_exists('yoast_breadcrumb') ) {
                          yoast_breadcrumb( '<div id="breadcrumbs" class="d-block mb-3">','</div>' );
                        } ?>
    <div class="row">
        <div class="col-md-6">
            <div class="contact-section">
                <?php if( !empty(get_option('options_ubicacion')) ): ?>
                    <div class="address contact-block">
                        <p class="h3"><strong><?php _e('Dirección', 'identofmk'); ?></strong></p>
                        <span class="p-icon"><i class="fas fa-map-marker-alt"></i><?php echo get_option('options_ubicacion'); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if( !empty(get_option('options_telefono')) ): ?>
                    <div class="phone contact-block">
                        <p class="h3"><strong ><?php _e('Teléfono', 'identofmk'); ?></strong></p>
                        <span class="p-icon"><a href="tel:<?php echo str_replace(" ", "", get_option('options_telefono')); ?>"><i class="fa fa-phone"></i><?= get_option('options_telefono'); ?> - <?php _e('Atención al Cliente', 'identofmk'); ?></a></span>
                    </div>
                <?php endif; ?>
                
                <?php if( !empty(get_option('options_correo_electronico')) ): ?>
                    <div class="email contact-block">
                        <p class="h3"><strong><?php _e('Correo electrónico', 'identofmk'); ?></strong></p>
                        <span class="p-icon"><a href="mailto:<?php echo get_option('options_correo_electronico'); ?>"><i class="fa fa-envelope"></i><?php echo get_option('options_correo_electronico'); ?></a></span>
                    </div>
                <?php endif; ?>
                
                <?php if( !empty(get_option('options_horario')) ): ?>
                    <div class="timetable contact-block">
                        <p class="h3"><strong><?php _e('Horario de atención', 'identofmk'); ?></strong></p>
                        <span class="p-icon"><i class="fa fa-clock"></i> <?php echo get_option('options_horario'); ?></span>
                    </div>
                <?php endif; ?>

                <div class="social-media contact-block">
                    <p class="h3"><strong><?php _e('Redes sociales', 'identowoofmk'); ?></strong></p>
                    <div>
                        <?php get_template_part('block', 'social'); ?>
                    </div>
                </div>
                <div class="map_box">
    <iframe style="border: 0; width: 100%;" src="<?php echo get_option('options_google_maps'); ?>" width="300" height="350"></iframe>
</div>
            </div>
        </div>

        <div class="col-md-6">
			<span class="h2"><?php _e('¿Hablamos?', 'granadaluxury'); ?></span>
			<p><?php _e('¿Listo para maximizar tus ingresos con tu propiedad? Completa el siguiente formulario y un asesor se pondrá en contacto contigo a la brevedad.', 'granadaluxury'); ?></p>
             <?php echo do_shortcode(get_option('options_formulario_de_contacto')); ?>
            
        </div>
    </div>
</div>


</main>

<?php get_footer(); ?>
