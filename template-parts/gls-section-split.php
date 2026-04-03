<?php
/**
 * GLS – Sección Split Luxury (Texto + Imagen + CTAs)
 * Template Part: gls-section-split.php
 *
 * Uso:
 *   get_template_part( 'template-parts/gls-section-split', null, [
 *       'prefix'    => 'gls_prop_split',   // Prefijo de los campos ACF (sin guión bajo final)
 *       'object_id' => false,              // false = post actual; 'option' = Options Page
 *       'layout'    => 'image-right',      // 'image-right' | 'image-left'
 *       'fallback'  => [                   // Contenido de ejemplo si aún no hay datos ACF
 *           'eyebrow'       => 'Descubre más',
 *           'titulo'        => 'Un título de ejemplo',
 *           'texto'         => 'Texto de descripción...',
 *           'btn_primary'   => [ 'title' => 'Saber más',  'url' => '#', 'target' => '' ],
 *           'btn_secondary' => [ 'title' => 'Contactar',  'url' => '#', 'target' => '' ],
 *           'imagen_url'    => '',
 *           'imagen_alt'    => '',
 *           'bg'            => 'light',   // 'light' | 'accent' | 'dark'
 *       ],
 *   ] );
 *
 * Campos ACF leídos (sufijo fijo por campo, prefijo variable):
 *   {prefix}_eyebrow       → text
 *   {prefix}_titulo        → text
 *   {prefix}_texto         → textarea / wysiwyg
 *   {prefix}_btn_primary   → link  (retorna ['title','url','target'])
 *   {prefix}_btn_secondary → link  (retorna ['title','url','target'])
 *   {prefix}_imagen        → image (retorna array con 'url','alt',…)
 *   {prefix}_bg            → select ('light'|'accent'|'dark')
 */

$prefix    = $args['prefix']    ?? 'gls_split';
$object_id = $args['object_id'] ?? false;   // false = post actual en ACF
$layout    = $args['layout']    ?? 'image-right';
$fallback  = $args['fallback']  ?? [];

// --- Leer campos ACF (con comprobación de función para evitar errores fatales) ---
$has_acf = function_exists( 'get_field' );

$eyebrow       = $has_acf ? get_field( $prefix . '_eyebrow',       $object_id ) : null;
$titulo        = $has_acf ? get_field( $prefix . '_titulo',        $object_id ) : null;
$texto         = $has_acf ? get_field( $prefix . '_texto',         $object_id ) : null;
$btn_primary   = $has_acf ? get_field( $prefix . '_btn_primary',   $object_id ) : null;
$btn_secondary = $has_acf ? get_field( $prefix . '_btn_secondary', $object_id ) : null;
$imagen        = $has_acf ? get_field( $prefix . '_imagen',        $object_id ) : null;
$bg            = $has_acf ? get_field( $prefix . '_bg',            $object_id ) : null;

// --- Aplicar fallbacks si el campo está vacío ---
$eyebrow       = $eyebrow       ?: ( $fallback['eyebrow']       ?? '' );
$titulo        = $titulo        ?: ( $fallback['titulo']        ?? __( 'Título de sección', 'identofmk' ) );
$texto         = $texto         ?: ( $fallback['texto']         ?? __( 'Edita este contenido desde el panel de administración en ACF.', 'identofmk' ) );
$btn_primary   = $btn_primary   ?: ( $fallback['btn_primary']   ?? null );
$btn_secondary = $btn_secondary ?: ( $fallback['btn_secondary'] ?? null );
$bg            = $bg            ?: ( $fallback['bg']            ?? 'light' );

// Imagen: puede venir de ACF (array) o como URL en fallback
$imagen_url = '';
$imagen_alt = esc_attr( $titulo );

if ( is_array( $imagen ) && ! empty( $imagen['url'] ) ) {
	$imagen_url = esc_url( $imagen['url'] );
	$imagen_alt = esc_attr( $imagen['alt'] ?? $titulo );
} elseif ( ! empty( $fallback['imagen_url'] ) ) {
	$imagen_url = esc_url( $fallback['imagen_url'] );
	$imagen_alt = esc_attr( $fallback['imagen_alt'] ?? $titulo );
}

// --- Clases del wrapper ---
$bg_class     = 'gls-split--' . sanitize_html_class( $bg ?: 'light' );
$layout_class = 'gls-split--' . sanitize_html_class( $layout );
?>
<section class="gls-split <?php echo esc_attr( $bg_class . ' ' . $layout_class ); ?>">

	<div class="gls-split__inner gls-container">

		<div class="gls-split__content">

			<?php if ( $eyebrow ) : ?>
				<span class="gls-split__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<h2 class="gls-split__title"><?php echo esc_html( $titulo ); ?></h2>

			<div class="gls-split__text">
				<?php echo wp_kses_post( wpautop( $texto ) ); ?>
			</div>

			<?php if ( $btn_primary || $btn_secondary ) : ?>
				<div class="gls-split__actions">

					<?php if ( $btn_primary ) : ?>
						<a
							href="<?php echo esc_url( $btn_primary['url'] ?? '#' ); ?>"
							class="btn-fix"
							<?php if ( ! empty( $btn_primary['target'] ) ) : ?>target="<?php echo esc_attr( $btn_primary['target'] ); ?>"<?php endif; ?>
						>
							<?php echo esc_html( $btn_primary['title'] ?? __( 'Saber más', 'identofmk' ) ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $btn_secondary ) : ?>
						<a
							href="<?php echo esc_url( $btn_secondary['url'] ?? '#' ); ?>"
							class="btn-fix-outline"
							<?php if ( ! empty( $btn_secondary['target'] ) ) : ?>target="<?php echo esc_attr( $btn_secondary['target'] ); ?>"<?php endif; ?>
						>
							<?php echo esc_html( $btn_secondary['title'] ?? __( 'Contactar', 'identofmk' ) ); ?>
						</a>
					<?php endif; ?>

				</div>
			<?php endif; ?>

		</div>

		<div class="gls-split__media">
			<?php if ( $imagen_url ) : ?>
				<img
					src="<?php echo $imagen_url; ?>"
					alt="<?php echo $imagen_alt; ?>"
					class="gls-split__img"
					loading="lazy"
				/>
			<?php else : ?>
				<div class="gls-split__img-placeholder"></div>
			<?php endif; ?>
		</div>

	</div>

</section>
