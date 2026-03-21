<?php get_header(); ?>

<?php
/**
 * GLS – Hero específico para páginas de archivo
 */
get_template_part('template-parts/gls-page-hero');

?>

<main>

    <!-- LOOP APARTAMENTOS -->
    <section class="seleccionados productos">
        <div class="container">
            <h2 class="text-center pb-5">
                <strong><?php _e('Nuestros', 'granadaluxury'); ?></strong>
                <?php _e('apartamentos', 'granadaluxury'); ?>
            </h2>

            <?php
            // ============================
            // FILTRO DISPONIBILIDAD (ICNEA)
            // ============================
            $paged = get_query_var('paged') ?: 1;

            $search_args = gls_icnea_get_search_args_from_request();

            $arrival          = $search_args['arrival'];
            $departure        = $search_args['departure'];
            $guests           = $search_args['guests'];
            $has_filter       = $search_args['has_dates'];
            $arrival_for_url  = $arrival;
            $departure_for_url = $departure;
            $is_fallback_mode = false;

            /**
             * available_ids:
             * - array([]) => no hay disponibles (o min stay no cumplido)
             * - array([id,id...]) => disponibles
             * - null => fallback (ICNEA falló), no filtramos
             */
            $available_ids = null;

            if ($has_filter) {
                $available_ids = gls_icnea_get_available_post_ids($arrival, $departure, $guests, 'es');
                $is_fallback_mode = gls_icnea_is_fallback_mode();
            }

            if ($has_filter && $is_fallback_mode) : ?>
                <div class="gls-no-results text-center mb-4">
                    <p class="mb-0">
                        <?php _e('No hemos podido comprobar disponibilidad en este momento', 'granadaluxury'); ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($has_filter && !$is_fallback_mode && is_array($available_ids) && empty($available_ids)) : ?>
                <div class="gls-no-results text-center mb-4">
                    <p class="mb-2">
                        <strong><?php _e('No hay disponibilidad', 'granadaluxury'); ?></strong>
                        <?php _e('para esas fechas.', 'granadaluxury'); ?>
                    </p>
                    <p class="mb-0">
                        <?php _e('Prueba otras fechas (mínimo 2 noches).', 'granadaluxury'); ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center apartamentos-loop">

                <?php
                $original_query = $wp_query;

                $args = [
                    'post_type'      => 'apartamentos',
                    'posts_per_page' => 12,
                    'paged'          => $paged,
                ];

                if ($has_filter && is_array($available_ids)) {
                    $args['post__in'] = !empty($available_ids) ? $available_ids : [0];
                    $args['orderby']  = 'post__in';
                } elseif ($has_filter && $is_fallback_mode) {
                    $args['posts_per_page'] = gls_icnea_get_fallback_posts_limit();
                }

                $wp_query = new WP_Query($args);

                if ($wp_query->have_posts()) :
                    while ($wp_query->have_posts()) : $wp_query->the_post();

                        $id = get_the_ID();

                        $titulo_linea_de_arriba = get_field('titulo_linea_de_arriba', $id);
                        $titulo_linea_de_abajo  = get_field('titulo_linea_de_abajo', $id);
                        $precio                 = get_field('precio', $id);
                        $variable_de_precio     = get_field('variable_de_precio', $id);
                        $boton                  = get_field('boton_de_reserva', $id);
                ?>

                        <div class="col-12 col-md-6 mb-5">
                            <article class="apartamento-card">

                                <?php
                                $imagenes = [];

                                if (have_rows('imagenes_card', $id)) {
                                    while (have_rows('imagenes_card', $id)) : the_row();
                                        $img = get_sub_field('imagen');
                                        if ($img) {
                                            $imagenes[] = $img;
                                        }
                                    endwhile;
                                } elseif (have_rows('fotografias', $id)) {
                                    while (have_rows('fotografias', $id)) : the_row();
                                        $img = get_sub_field('foto');
                                        if ($img) {
                                            $imagenes[] = $img;
                                        }
                                    endwhile;
                                }

                                if (!empty($imagenes)) :
                                ?>

                                    <div id="carouselapartamentos-<?php echo esc_attr($id); ?>"
                                        class="carousel slide apartamento-carousel">

                                        <div class="carousel-inner">
                                            <?php foreach ($imagenes as $index => $img) : ?>
                                                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                                                    <img src="<?php echo esc_url($img['sizes']['large']); ?>"
                                                        alt="<?php echo esc_attr(get_the_title()); ?>"
                                                        class="d-block w-100"
                                                        loading="lazy">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <?php if (count($imagenes) > 1) : ?>
                                            <button class="carousel-control-prev"
                                                type="button"
                                                data-bs-target="#carouselapartamentos-<?php echo esc_attr($id); ?>"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>

                                            <button class="carousel-control-next"
                                                type="button"
                                                data-bs-target="#carouselapartamentos-<?php echo esc_attr($id); ?>"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($precio) : ?>
                                            <div class="p-absolute precio-card">
                                                <div class="precio bebasneue mt-3">
                                                    <span class="variable">
                                                        <?php _e('Desde', 'granadaluxury'); ?>
                                                    </span>
                                                    <?php echo esc_html($precio); ?>
                                                    <span class="variable">
                                                        <?php echo esc_html($variable_de_precio); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>

                                <div class="apartamento-body p-4">

                                    <h3 class="titulo-apartamentos">
                                        <span class="strong"><?php echo esc_html($titulo_linea_de_arriba); ?></span><br>
                                        <span><?php echo esc_html($titulo_linea_de_abajo); ?></span>
                                    </h3>

                                    <?php if (get_the_excerpt()) : ?>
                                        <div class="descriptor mb-3">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (have_rows('datos_del_apartamento', $id)) : ?>
                                        <div class="datos_apartamento">
                                            <?php
                                            while (have_rows('datos_del_apartamento', $id)) : the_row();
                                                $icono = get_sub_field('icono_del_dato');
                                                $texto = get_sub_field('texto_que_acompana_al_icono');

                                                preg_match('/\d+/', (string) $texto, $matches);
                                                $numero = $matches[0] ?? '';
                                            ?>
                                                <div class="dato-numero">
                                                    <?php if ($icono) : ?>
                                                        <img src="<?php echo esc_url($icono['url']); ?>"
                                                            alt=""
                                                            class="icono-dato">
                                                    <?php endif; ?>
                                                    <span class="numero-dato"><?php echo esc_html($numero); ?></span>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    if ($boton) :
                                        $url = $boton['url'];

                                        if ($has_filter) {
                                            $url = add_query_arg([
                                                'arrival'   => $arrival_for_url,
                                                'departure' => $departure_for_url,
                                                'guests'    => max(1, (int) $guests),
                                            ], $url);
                                        }
                                    ?>
                                        <a href="<?php echo esc_url($url); ?>"
                                            class="btn-fix"
                                            target="_blank"
                                            rel="noopener noreferrer">
                                            <?php _e('ver detalles', 'granadaluxury'); ?>
                                        </a>
                                    <?php endif; ?>

                                </div>

                            </article>
                        </div>

                <?php
                    endwhile;
                endif;

                $wp_query = $original_query;
                wp_reset_postdata();
                ?>

            </div>

            <?php if (!$is_fallback_mode) : ?>
                <div class="pagination">
                    <?php custom_post_type_pagination_links(); ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>