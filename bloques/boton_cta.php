<?php 
/*          'name'              => 'boton_cta',
            'title'             => __('Botón'),
            'description'       => __('Bloque que añade un botón'), */

/**
 * texto-imagen Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'boton_cta-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'boton_cta';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$enlace = get_field('enlace');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php 
    if( $enlace ): 
    $link_url = $enlace['url'];
    $link_title = $enlace['title'];
    $link_target = $enlace['target'] ? $enlace['target'] : '_self';
    ?>
    <a class="btn-fix" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>

    <?php endif; ?>
</section>

    