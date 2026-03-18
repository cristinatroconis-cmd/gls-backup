<?php
/**
 * Template Part: Home Publics Slides
 * Proyecto: Granada Luxury Suites
 * Fecha: 18/02/2026
 */

if( have_rows('publics_slides') ): ?>

<section class="publics-home-slides">

    <?php while( have_rows('publics_slides') ): the_row();

        $background = get_sub_field('slide_background');
        $title      = get_sub_field('slide_title');
        $text       = get_sub_field('slide_text');
        $button     = get_sub_field('slide_button');

    ?>

        <div class="publics-slide">

            <?php if($background): ?>
                <div class="publics-slide-bg"
                     style="background-image: url('<?php echo esc_url($background['url']); ?>');">
                </div>
            <?php endif; ?>

            <div class="publics-slide-inner">

                <?php if($title): ?>
                    <h2 class="gls-home-prop-title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if($text): ?>
                    <div class="gls-home-prop-text">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                <?php endif; ?>

                <?php if($button): ?>
                    <a href="<?php echo esc_url($button['url']); ?>"
                       class="gls-home-prop-cta"
                       target="<?php echo esc_attr($button['target']); ?>">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>

            </div>

        </div>

    <?php endwhile; ?>

</section>

<?php endif; ?>
