<?php
/**
 * Button — docs/biblioteca_componentes.md §6.
 *
 * Responsabilidad: acción primaria/secundaria en cualquier parte de la
 * interfaz — el átomo más reutilizado del sistema.
 *
 * Variantes: las 4 nombradas en biblioteca_componentes.md no coinciden
 * 1:1 con las clases ya aprobadas en el prototipo (prototipo/index.html,
 * prototipo/contacto.html) — no se inventa una variante "primary" sólida
 * sobre fondo claro que no existe en el diseño aprobado (CLAUDE.md §6/§15,
 * no rediseñar). Este componente expone las 4 variantes reales:
 *   - solid-light  → .btn.btn-solid-light  (sólido, sobre fondo oscuro)
 *   - outline-dark → .btn.btn-outline-dark (contorno, sobre fondo oscuro)
 *   - outline      → .btn.btn-outline      (contorno, sobre fondo claro)
 *   - text         → .text-link            (enlace de acción)
 * Si el sitio llega a necesitar un botón sólido sobre fondo claro, es una
 * decisión de diseño nueva a aprobar en su momento, no una variante de
 * este componente.
 *
 * Estados disabled/loading solo aplican al renderizar como <button> (una
 * acción, no una navegación — un <a href> deshabilitado no tiene
 * semántica nativa). Reutilizan las clases globales del Sistema de
 * Interacción (.is-disabled / .is-loading, assets/css/design-system.css)
 * en vez de duplicar opacidad/cursor aquí.
 *
 * @param array $args {
 *     @type string $label             Texto visible. Obligatorio.
 *     @type string $href              URL si navega. Sin ella, renderiza <button>.
 *     @type string $type              'button'|'submit', solo si no hay $href. Default 'button'.
 *     @type string $variant           'solid-light'|'outline-dark'|'outline'|'text'. Default 'outline'.
 *     @type string $size              'default'|'compact'. Default 'default'.
 *     @type bool   $full_width_mobile Ancho completo en mobile. Default false.
 *     @type bool   $disabled          Solo válido sin $href.
 *     @type bool   $loading           Solo válido sin $href; añade aria-busy.
 *     @type string $icon              Markup SVG decorativo opcional (aria-hidden).
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_label = isset( $args['label'] ) ? trim( (string) $args['label'] ) : '';
if ( '' === $ses_label ) {
	return;
}

$ses_href     = isset( $args['href'] ) ? (string) $args['href'] : '';
$ses_type     = isset( $args['type'] ) && 'submit' === $args['type'] ? 'submit' : 'button';
$ses_variant  = isset( $args['variant'] ) ? $args['variant'] : 'outline';
$ses_size     = isset( $args['size'] ) ? $args['size'] : 'default';
$ses_full_mob = ! empty( $args['full_width_mobile'] );
$ses_icon     = isset( $args['icon'] ) ? $args['icon'] : '';

// disabled/loading no tienen sentido en un <a href> — solo se respetan
// cuando el botón no navega (ver nota de arriba).
$ses_disabled = '' === $ses_href && ! empty( $args['disabled'] );
$ses_loading  = '' === $ses_href && ! empty( $args['loading'] );

$ses_variant_map = array(
	'solid-light'  => 'btn btn-solid-light',
	'outline-dark' => 'btn btn-outline-dark',
	'outline'      => 'btn btn-outline',
	'text'         => 'text-link',
);
$ses_variant_class = isset( $ses_variant_map[ $ses_variant ] ) ? $ses_variant_map[ $ses_variant ] : $ses_variant_map['outline'];

$ses_classes = array( $ses_variant_class );
if ( 'compact' === $ses_size && 'text' !== $ses_variant ) {
	$ses_classes[] = 'btn-compact';
}
if ( $ses_full_mob ) {
	$ses_classes[] = 'btn-full-mobile';
}
if ( $ses_disabled ) {
	$ses_classes[] = 'is-disabled';
} elseif ( $ses_loading ) {
	$ses_classes[] = 'is-loading';
}

$ses_class_attr = esc_attr( implode( ' ', $ses_classes ) );
?>
<?php if ( '' !== $ses_href && ! $ses_disabled ) : ?>
	<a href="<?php echo esc_url( $ses_href ); ?>" class="<?php echo $ses_class_attr; ?>">
		<?php if ( $ses_icon ) : ?><span class="btn-icon" aria-hidden="true"><?php echo $ses_icon; ?></span><?php endif; ?>
		<?php echo esc_html( $ses_label ); ?>
	</a>
<?php else : ?>
	<button
		type="<?php echo esc_attr( $ses_type ); ?>"
		class="<?php echo $ses_class_attr; ?>"
		<?php disabled( $ses_disabled ); ?>
		<?php echo $ses_loading ? 'aria-busy="true"' : ''; ?>
	>
		<?php if ( $ses_icon ) : ?><span class="btn-icon" aria-hidden="true"><?php echo $ses_icon; ?></span><?php endif; ?>
		<?php echo esc_html( $ses_label ); ?>
	</button>
<?php endif; ?>
