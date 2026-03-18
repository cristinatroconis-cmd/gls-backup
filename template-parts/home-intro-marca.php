<?php
/**
 * Template Part: Home Intro Marca
 * Proyecto: Granada Luxury Suites
 * Fecha: 19/02/2026
 * Corrección: nombres reales de campos ACF
 */

// Campos ACF (según configuración real)
$intro_titulo   = get_field('intro_title');
$intro_texto    = get_field('intro_text');
$intro_imagen   = get_field('intro_image');
$intro_cta_1    = get_field('intro_button_1');
$intro_cta_2    = get_field('intro_button_2');
?>

<section class="gls-intro">

    <div class="gls-intro__container">

        <div class="gls-intro__col">
				
				<?php if($intro_titulo): ?>
					<h2 class="gls-intro__title">
                    	<?php echo esc_html($intro_titulo); ?>
                	</h2>
            	<?php endif; ?>
			
			<div class="gls-intro__background">
			
            	<?php if($intro_imagen): ?>
                	<div class="gls-intro__media">
                    	<img src="<?php echo esc_url($intro_imagen['url']); ?>"
                         	alt="<?php echo esc_attr($intro_imagen['alt']); ?>">
                	</div>
            	<?php endif; ?>
				
			</div>
			
		</div>
		
         <div class="gls-intro__content">

                <?php if($intro_texto): ?>
                    <div class="gls-intro__text">
                        <?php echo wp_kses_post($intro_texto); ?>
                    </div>
                <?php endif; ?>

                <?php if($intro_cta_1 || $intro_cta_2): ?>
                    <div class="gls-intro__buttons">

                        <?php if($intro_cta_1): ?>
                            <a href="<?php echo esc_url($intro_cta_1['url']); ?>"
                               class="gls-intro__cta btn-fix"
                               target="<?php echo esc_attr($intro_cta_1['target']); ?>">
                                <?php echo esc_html($intro_cta_1['title']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if($intro_cta_2): ?>
                            <a href="<?php echo esc_url($intro_cta_2['url']); ?>"
                               class="gls-intro__cta btn-fix-outline"
                               target="<?php echo esc_attr($intro_cta_2['target']); ?>">
                                <?php echo esc_html($intro_cta_2['title']); ?>
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>

    </div>

</section>
