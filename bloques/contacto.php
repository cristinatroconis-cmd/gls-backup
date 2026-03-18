<?php 
/*          'name'              => 'contacto',
            'title'             => __('Contacto'),
            'description'       => __('Formulario con texto de acompañamiento'), */

/**
 * Contacto Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'contacto-home-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'contacto-home';
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
    <div class="container-fluid">
        <div class="row reverse-movil">
            <div class="col-lg-6 col-12 col-md-6 d-flex justify-content-center align-items-center faq">
                <div class="col-12 col-md-10 col-lg-8 formulario-container">
                    <h2 class="mb-3 bellmt"><?php echo $titulo; ?></h2>
                    <p class="mb-3"><?php echo $subtitulo; ?></p>
                    <div id="form-container" class="form-container">
                        <a id="gform"></a>
                        <?php
                        $form_object = get_field('formulario');
                        gravity_form_enqueue_scripts($form_object['id'], true);
                        gravity_form($form_object['id'], false, false, false, '', true, 1);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="video-background">
                    <?php
                    // Load value.
                    $video = get_field('video');
                    ?>
                    <video autoplay muted playsinline loop>
                      <source src="<?php echo $video; ?>" type="video/mp4">
                      Tu navegador no soporta este formato de vídeo.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>
