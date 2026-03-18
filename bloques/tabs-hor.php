<?php 
/*          'name'              => 'tabs-hor',
            'title'             => __('Tabs horizontales'),
            'description'       => __('Bloques con Tabs de Boostrap horizontales'), */

/**
 * Tabs horizontales Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'tabs-hor-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'tabs-hor';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$imagen = get_field('imagen');
?>
<?php echo $imagen; ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="row">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <?php

                // Check rows exists.
                if( have_rows('button') ):
                    $countbutton = 0;
                    // Loop through rows.
                    while( have_rows('button') ) : the_row();

                        // Load sub field value.
                        $titulo = get_sub_field('titulo');
                        // Do something...
                        ?>
                        <button class="nav-link <?php if($countbutton == 0) {echo 'active';}?>" id="nav-<?php echo $countbutton; ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo $countbutton; ?>" type="button" role="tab" aria-controls="nav-<?php echo $countbutton; ?>" aria-selected="<?php if($countbutton==0) {echo 'true';} else {echo 'false';} ?>"><?php echo $titulo; ?></button>
                        <?php 
                        $countbutton++;
                    // End loop.
                    endwhile;
                    
                // No value.
                else :
                    // Do something...
                endif;
                ?>
                    <!-- <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> -->
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <?php

                // Check rows exists.
                if( have_rows('button') ):
                    $countbutton = 0;
                    // Loop through rows.
                    while( have_rows('button') ) : the_row();

                        // Load sub field value.
                        $contenido = get_sub_field('contenido');
                        // Do something...
                        ?>

                        <div class="tab-pane fade <?php if($countbutton == 0) {echo 'show active';}?>" id="nav-<?php echo $countbutton; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $countbutton; ?>-tab"><?php echo $contenido; ?></div>

                        <?php 
                        $countbutton++;
                    // End loop.
                    endwhile;
                    
                // No value.
                else :
                    // Do something...
                endif;
                ?>
                <!-- <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">aaa</div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">bbb</div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">ccc</div> -->
            </div>
        </div>
    </div>
</section>

    