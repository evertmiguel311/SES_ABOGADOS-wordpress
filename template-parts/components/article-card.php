<?php
/**
 * Article Card — docs/biblioteca_componentes.md §4.
 *
 * Dos variantes reales del prototipo aprobado:
 *   - full (default): imagen + categoría + título + fecha/lectura,
 *     tarjeta completa como <a> (prototipo/index.html,
 *     prototipo/actualidad-juridica.html .articulo-card).
 *   - compact: imagen + categoría + título, sin fecha/lectura, usada
 *     sobre fondo oscuro en "Artículos relacionados"
 *     (prototipo/actualidad-juridica/*.html .related-card) — sin
 *     `.reveal`, tal como está en el diseño aprobado.
 *
 * La categoría se muestra como texto plano, igual que en el prototipo
 * aprobado — no se envuelve en Badge/Category Badge (ese es un
 * componente propio, todavía no construido, ver docs/roadmap.md).
 *
 * Si no hay `image_url` (dato dinámico aún no disponible), se omite el
 * bloque de imagen en vez de inventar un placeholder que no existe en
 * el diseño aprobado — el resto de la tarjeta sigue siendo funcional.
 *
 * @param array $args {
 *     @type string $title         Obligatorio.
 *     @type string $url           Obligatorio.
 *     @type string $category      Obligatorio.
 *     @type string $image_url     Opcional — sin ella, se omite la imagen.
 *     @type string $date_display  Solo variant=full. Fecha legible ("12 jun 2026").
 *     @type string $date_iso      Solo variant=full. Para <time datetime>, opcional.
 *     @type string $reading_time  Solo variant=full ("5 min de lectura").
 *     @type string $variant       'full' (default) | 'compact'.
 *     @type int    $reveal_delay  0-7. Solo variant=full.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_title    = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$ses_url      = isset( $args['url'] ) ? (string) $args['url'] : '';
$ses_category = isset( $args['category'] ) ? trim( (string) $args['category'] ) : '';
if ( '' === $ses_title || '' === $ses_url || '' === $ses_category ) {
	return;
}

$ses_variant   = isset( $args['variant'] ) && 'compact' === $args['variant'] ? 'compact' : 'full';
$ses_image_url = isset( $args['image_url'] ) ? (string) $args['image_url'] : '';

if ( 'compact' === $ses_variant ) :
	?>
	<a href="<?php echo esc_url( $ses_url ); ?>" class="related-card">
		<?php if ( $ses_image_url ) : ?>
			<div class="related-card-img stock-photo-wrap">
				<img class="stock-photo" src="<?php echo esc_url( $ses_image_url ); ?>" alt="" loading="lazy" aria-hidden="true">
			</div>
		<?php endif; ?>
		<div class="related-card-cat"><?php echo esc_html( $ses_category ); ?></div>
		<h3><?php echo esc_html( $ses_title ); ?></h3>
	</a>
	<?php
	return;
endif;

$ses_reveal_delay = isset( $args['reveal_delay'] ) ? max( 0, min( 7, (int) $args['reveal_delay'] ) ) : 0;
$ses_reveal_class = 'reveal' . ( $ses_reveal_delay > 0 ? ' reveal-delay-' . $ses_reveal_delay : '' );
$ses_date_display = isset( $args['date_display'] ) ? trim( (string) $args['date_display'] ) : '';
$ses_date_iso      = isset( $args['date_iso'] ) ? (string) $args['date_iso'] : '';
$ses_reading_time  = isset( $args['reading_time'] ) ? trim( (string) $args['reading_time'] ) : '';
?>
<a href="<?php echo esc_url( $ses_url ); ?>" class="articulo-card <?php echo esc_attr( $ses_reveal_class ); ?>">
	<?php if ( $ses_image_url ) : ?>
		<div class="articulo-img stock-photo-wrap">
			<img class="stock-photo" src="<?php echo esc_url( $ses_image_url ); ?>" alt="" loading="lazy" aria-hidden="true">
		</div>
	<?php endif; ?>
	<div class="articulo-categoria"><?php echo esc_html( $ses_category ); ?></div>
	<h3><?php echo esc_html( $ses_title ); ?></h3>
	<?php if ( $ses_date_display || $ses_reading_time ) : ?>
		<div class="articulo-meta">
			<?php if ( $ses_date_display && $ses_date_iso ) : ?>
				<time datetime="<?php echo esc_attr( $ses_date_iso ); ?>"><?php echo esc_html( $ses_date_display ); ?></time>
			<?php elseif ( $ses_date_display ) : ?>
				<?php echo esc_html( $ses_date_display ); ?>
			<?php endif; ?>
			<?php if ( $ses_date_display && $ses_reading_time ) : ?> · <?php endif; ?>
			<?php echo esc_html( $ses_reading_time ); ?>
		</div>
	<?php endif; ?>
</a>
