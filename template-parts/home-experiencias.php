<?php
/**
 * Template Part: Home Experiencias
 * Proyecto: Granada Luxury Suites
 * Fecha: 18/02/2026
 */

if( have_rows('experiencias_items') ): ?>

<section class="gls-experiencias">

    <div class="gls-experiencias__container">

        <div class="gls-experiencias__grid">

            <?php while( have_rows('experiencias_items') ): the_row();

                $image  = get_sub_field('exp_image');
                $title  = get_sub_field('exp_title');
                $text   = get_sub_field('exp_text');
                $button = get_sub_field('exp_button');

            ?>

                <article class="gls-experiencia">

                    <?php if($image): ?>
                        <div class="gls-experiencia__image">
                            <img src="<?php echo esc_url($image['url']); ?>"
                                 alt="<?php echo esc_attr($image['alt']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="gls-experiencia__content">

                        <?php if($title): ?>
                            <h3 class="gls-experiencia__title">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if($text): ?>
							<div class="gls-experiencia__text">
                                <?php echo esc_html($text); ?>
							</div>
                            
                        <?php endif; ?>

                        <?php if($button): ?>
                            <a href="<?php echo esc_url($button['url']); ?>"
                               class="gls-experiencia__cta btn-fix"
                               target="<?php echo esc_attr($button['target']); ?>">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<?php endif; ?>
