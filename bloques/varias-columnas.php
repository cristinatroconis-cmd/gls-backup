<?php 
/*          'name'              => 'varias-columnas',
            'title'             => __('Contenido en varias columnas'),
            'description'       => __('Bloque para añadir contenido con varias columnas'), */

/**
 * Wising Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'varias-columnas-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'varias-columnas';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$contenido = get_field('contenido');
$columnas = get_field('columnas');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12 columnas" style="column-count: <?php echo $columnas; ?>;">
               <?php echo $contenido; ?>
            </div>
        </div>
    </div>
</section>
