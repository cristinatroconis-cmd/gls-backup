<?php get_header();
?>

<?php
/**
 * GLS – Hero específico para páginas de archivo
 */
get_template_part('template-parts/gls-page-hero');

?>
<main>
	</section>
	<div id="experiencias-content">
		<div class="TabHero-gradient"></div>

		<?php
		$categorias = get_terms([
			'taxonomy' => 'category', // Cambia 'category' por tu taxonomía personalizada si es necesario
			'hide_empty' => true, // Cambia a false si quieres incluir categorías sin posts
			'exclude' => [1], // Excluye la categoría "Sin categorizar" por ID
		]);
		if (!empty($categorias) && !is_wp_error($categorias)) {
			echo '<div id="experiencias-tabs">';
			foreach ($categorias as $index => $categoria) {
				// Verifica si esta categoría es la primera para asignarle la clase 'active' o no
				$activeClass = $index === 0 ? 'active' : '';
		?>
				<div class="tabs-child <?= $activeClass; ?>" data-target="<?= esc_attr($categoria->slug); ?>">
					<?= _e($categoria->name, "experiencias"); ?>
				</div>
				<?php
				// Si no es la última categoría, añade un 'tabs-bullets' después de ella
				if ($index < count($categorias) - 1) {
					echo '<div class="tabs-bullets"></div>';
				}
			}
			echo '</div>';
			echo '<div class="tabs-underline"></div>';
			foreach ($categorias as $index => $categoria) {
				$activeClass = $index === 0 ? 'active' : '';
				echo '<div class="experiencias-description experiencias-description-' . esc_attr($categoria->slug) . ' ' . $activeClass . '">' . esc_attr($categoria->description) . '</div> ';
			}
			echo '<section class="experiencias">
				<img src="" alt="" id="experiencias-background" class="" />
				';
			echo '<div class="experiencias-container-slide">';
			foreach ($categorias as $index => $categoria) {
				$activeClass = $index === 0 ? 'active' : '';
				echo '<div id="' . esc_attr($categoria->slug) . '" class="experiencias-category ' . $activeClass . '">';

				$args = [
					'post_type' => 'experiencias', // Tu custom post type
					'posts_per_page' => -1, // Cantidad de posts por página, -1 para todos
					'tax_query' => [
						[
							'taxonomy' => 'category', // Cambia 'category' por tu taxonomía personalizada si es necesario
							'field' => 'term_id',
							'terms' => $categoria->term_id,
						],
					],
				];
				$query = new WP_Query($args);

				if ($query->have_posts()) {

					while ($query->have_posts()) {
						$query->the_post();
						$image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
						$image_id = 'img-' . $categoria->slug . '-' . get_the_ID();
				?>
						<div class="experiencia-card">
							<h4><?= get_the_title() ?></h4>
							<div class="experiencia-img">
								<img data-lazy="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" id="<?= $image_id ?>" />
							</div>
							<div class="experiencia-contenido">
								<div class="experiencia-excerpt">
									<p><?= get_the_excerpt() ?></p><a class="experiencia-link" href="<?= get_permalink() ?>"><?= _e("VER EXPERIENCIA", "experiencias"); ?></a>
								</div>

							</div>
						</div>
		<?php
					}
				}
				echo '</div>';

				// Restablece el postdata global para evitar conflictos
				wp_reset_postdata();
			}

			echo '</section>';
			echo '</div>';
		}

		?>

		<!-- <div class="tabs-child" data-target="experiencia1"> <?= _e("Turismo", "experiencias"); ?>
			</div>
			<div class="tabs-bullets"></div>
			<div class="tabs-child active" data-target="experiencia2"><?= _e("Gastronomía", "experiencias"); ?></div>
			<div class="tabs-bullets"></div>
			<div class="tabs-child" data-target="experiencia3"><?= _e("Naturaleza", "experiencias"); ?></div> -->

	</div>


</main>
<?php get_footer(); ?>