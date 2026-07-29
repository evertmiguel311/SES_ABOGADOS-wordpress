<?php
/**
 * Value / Differentiator Item — docs/biblioteca_componentes.md §3.
 *
 * Responsabilidad: comunicar un valor/diferenciador individual (ícono +
 * texto corto) como ítem de una lista. Markup idéntico al prototipo
 * aprobado (prototipo/quienes-somos.html .valores-grid .valor-item).
 *
 * @param array $args {
 *     @type string $icon         Markup SVG decorativo (aria-hidden). Obligatorio.
 *     @type string $title        Obligatorio.
 *     @type string $description  Obligatorio.
 *     @type int    $reveal_delay 0-7, para escalonar el grid.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_title       = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$ses_description = isset( $args['description'] ) ? trim( (string) $args['description'] ) : '';
if ( '' === $ses_title || '' === $ses_description ) {
	return;
}

$ses_icon         = isset( $args['icon'] ) ? $args['icon'] : '';
$ses_reveal_delay = isset( $args['reveal_delay'] ) ? max( 0, min( 7, (int) $args['reveal_delay'] ) ) : 0;
$ses_reveal_class = 'reveal' . ( $ses_reveal_delay > 0 ? ' reveal-delay-' . $ses_reveal_delay : '' );
?>
<div class="valor-item <?php echo esc_attr( $ses_reveal_class ); ?>">
	<?php if ( $ses_icon ) : ?>
		<div class="valor-icon" aria-hidden="true"><?php echo $ses_icon; // phpcs:ignore WordPress.Security.EscapeOutput -- SVG fijo definido por el llamador, no proviene de entrada de usuario. ?></div>
	<?php endif; ?>
	<h3><?php echo esc_html( $ses_title ); ?></h3>
	<p><?php echo esc_html( $ses_description ); ?></p>
</div>
