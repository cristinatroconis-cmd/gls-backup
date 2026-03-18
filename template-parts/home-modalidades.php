<?php
/**
 * Template Part: Home Modalidades
 * Proyecto: Granada Luxury Suites
 * Fecha: 18/02/2026
 */

if( have_rows('modalidades_items') ): ?>

<section class="gls-modalidades">

    <div class="gls-modalidades__container">

        <div class="gls-modalidades__grid">

            <?php while( have_rows('modalidades_items') ): the_row();

                $icono = get_sub_field('modalidad_icono');
                $titulo = get_sub_field('modalidad_titulo');
                $link = get_sub_field('modalidad_link');
                $texto = get_sub_field('modalidad_texto');

            ?>

                <article class="gls-modalidad">

                    <?php if($icono): ?>
                        <div class="gls-modalidad__icono">
                            <img src="<?php echo esc_url($icono['url']); ?>"
                                 alt="<?php echo esc_attr($icono['alt']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if($titulo): ?>
                        <h3 class="gls-modalidad__title">

                            <?php if($link): ?>
                                <a href="<?php echo esc_url($link['url']); ?>"
                                   target="<?php echo esc_attr($link['target']); ?>">
                                   <?php echo esc_html($titulo); ?>
                                </a>
                            <?php else: ?>
                                <?php echo esc_html($titulo); ?>
                            <?php endif; ?>

                        </h3>
                    <?php endif; ?>

                    <?php if($texto): ?>
                        <div class="gls-modalidad__text">
                            <?php echo esc_html($texto); ?>
                        </div>
                    <?php endif; ?>

                </article>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<?php endif; ?>
