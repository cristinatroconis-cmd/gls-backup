<?php 
/*          'name'              => 'cabecera',
            'title'             => __('Cabecera'),
            'description'       => __('Cabecera para las páginas. No usar en home.'), */

/**
 * cabecera Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'cabecera-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'cabecera';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulo = get_field('titulo');
$titulo_no_strong = get_field('titulo_no_strong');
$imagen = get_field('imagen');
$post = get_queried_object();
$postType = get_post_type_object(get_post_type($post));
$nombrePostType = esc_html($postType->labels->singular_name);
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="fondo" style="background: url(<?php echo esc_url($imagen['url']); ?>) no-repeat; background-size: cover; background-position: center;">
    <div class="container-fluid padding-cabecera">        
        <div class="row position-relative">
            <?php if( $titulo ): ?>
            <div class="col-12 col-md-12 centrar">
                <span class="h1 strong bellmt white"><?php echo $titulo; ?></span>
                <span class="h1 bellmt white"><?php echo $titulo_no_strong; ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
	</div>
</section>


    