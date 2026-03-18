<?php 
/*          'name'              => 'cabecera-home',
            'title'             => __('Cabecera Home'),
            'description'       => __('Cabecera con puntos fuertes'), */

/**
 * Cabecera Home Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'cabecera-home-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'cabecera-home';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$titulooculto = get_field('titulooculto');
$tituloh3top = get_field('tituloh3top');
$tituloh1 = get_field('tituloh1');
$tituloh3bottom = get_field('tituloh3bottom');
$contenido = get_field('contenido');
$cta = get_field('cta');
$enlace_cta = get_field('enlace_cta');
$imagen = get_field('imagen');
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> hero" >
    <div class="container-fluid">
        <div class="row reverse-movil">
            
            <div class="overlay col-lg-5">
                <?php if($titulooculto): ?>
                <h1 class="d-none"><?php echo $titulooculto; ?></h1>
                <?php endif; ?>
                <?php if($tituloh3top): ?>
                <span class="h1 bellmt"><?php echo $tituloh3top; ?></span>
                <?php endif; ?>
                <span class="h2 bellmt"><?php echo $tituloh1; ?></span>
                <?php if($tituloh3bottom): ?>
                <span class="h1"><?php echo $tituloh3bottom; ?></span>
                <?php endif; ?>
                <?php if($contenido): ?>
                <?php echo $contenido; ?>    
                <?php endif; ?> 
                <?php if($cta): ?>
                <a href="<?php echo $enlace_cta; ?>" class="cta-button"><?php echo $cta; ?></a>    
                <?php endif; ?> 
            </div>

            <div class="imagen-hero-home col-lg-7">
                <img src="<?php echo $imagen; ?>" alt="<?php echo $titulooculto; ?>">
            </div>

        </div>
    </div>
</section>

