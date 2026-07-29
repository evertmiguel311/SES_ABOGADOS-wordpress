<?php
/**
 * Practice Area Card — docs/biblioteca_componentes.md §4.
 *
 * Dos variantes reales del prototipo aprobado, mismo dato en dos
 * formatos distintos:
 *   - home    (default): título + lista de sub-especialidades, <h3>
 *     (prototipo/index.html .area-item).
 *   - landing: título + extracto de una línea, <h2>
 *     (prototipo/areas-de-practica.html .grupo-landing-card).
 *
 * Toda la tarjeta es un único <a> (biblioteca_componentes.md §4, evita
 * hit-targets confusos) — no se anida Button ni ningún otro elemento
 * interactivo dentro; "Ver más"/"Ver grupo" es texto decorativo
 * (.text-link), no un segundo enlace.
 *
 * @param array $args {
 *     @type string $title        Obligatorio.
 *     @type string $url          Obligatorio.
 *     @type string $icon         Markup SVG decorativo (aria-hidden). Opcional.
 *     @type string $variant      'home' (default) | 'landing'.
 *     @type array  $sub_areas    Solo variant=home. Array de strings.
 *     @type string $excerpt      Solo variant=landing.
 *     @type string $cta_label    Default 'Ver más' (home) / 'Ver grupo' (landing).
 *     @type int    $reveal_delay 0-7, para escalonar el grid (.reveal-delay-N).
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_title = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$ses_url   = isset( $args['url'] ) ? (string) $args['url'] : '';
if ( '' === $ses_title || '' === $ses_url ) {
	return;
}

$ses_variant = isset( $args['variant'] ) && 'landing' === $args['variant'] ? 'landing' : 'home';
$ses_icon    = isset( $args['icon'] ) ? $args['icon'] : '';

$ses_reveal_delay = isset( $args['reveal_delay'] ) ? max( 0, min( 7, (int) $args['reveal_delay'] ) ) : 0;
$ses_reveal_class = 'reveal' . ( $ses_reveal_delay > 0 ? ' reveal-delay-' . $ses_reveal_delay : '' );

if ( 'landing' === $ses_variant ) :
	$ses_excerpt   = isset( $args['excerpt'] ) ? trim( (string) $args['excerpt'] ) : '';
	$ses_cta_label = isset( $args['cta_label'] ) ? (string) $args['cta_label'] : __( 'Ver grupo', 'ses-abogados' );
	?>
	<a href="<?php echo esc_url( $ses_url ); ?>" class="grupo-landing-card <?php echo esc_attr( $ses_reveal_class ); ?>">
		<?php if ( $ses_icon ) : ?>
			<div class="area-icon" aria-hidden="true"><?php echo $ses_icon; ?></div>
		<?php endif; ?>
		<h2><?php echo esc_html( $ses_title ); ?></h2>
		<?php if ( $ses_excerpt ) : ?>
			<p><?php echo esc_html( $ses_excerpt ); ?></p>
		<?php endif; ?>
		<span class="text-link"><?php echo esc_html( $ses_cta_label ); ?></span>
	</a>
	<?php
	return;
endif;

$ses_sub_areas = isset( $args['sub_areas'] ) && is_array( $args['sub_areas'] ) ? $args['sub_areas'] : array();
$ses_cta_label = isset( $args['cta_label'] ) ? (string) $args['cta_label'] : __( 'Ver más', 'ses-abogados' );
?>
<a href="<?php echo esc_url( $ses_url ); ?>" class="area-item <?php echo esc_attr( $ses_reveal_class ); ?>">
	<?php if ( $ses_icon ) : ?>
		<div class="area-icon" aria-hidden="true"><?php echo $ses_icon; ?></div>
	<?php endif; ?>
	<h3><?php echo esc_html( $ses_title ); ?></h3>
	<?php if ( $ses_sub_areas ) : ?>
		<ul class="area-list">
			<?php foreach ( $ses_sub_areas as $ses_sub_area ) : ?>
				<li><?php echo esc_html( $ses_sub_area ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<span class="text-link"><?php echo esc_html( $ses_cta_label ); ?></span>
</a>
