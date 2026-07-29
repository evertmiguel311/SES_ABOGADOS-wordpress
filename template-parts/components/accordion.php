<?php
/**
 * Accordion — docs/biblioteca_componentes.md §6.
 *
 * Componente genérico de plegado/despliegue con dos casos de uso
 * independientes (DA-004, docs/componentes.md):
 *   1. Navegación móvil del Mega Menú de Áreas de Práctica (este bloque,
 *      Sprint 4) — el llamador (navbar.php) arma `items` a partir de
 *      ses_get_grupos_practica(), la misma fuente que usa el Mega Menú
 *      de escritorio; este archivo no conoce "grupos de práctica" ni
 *      ninguna otra noción de negocio (arquitectura.md §3.2, regla de
 *      composición 1 de biblioteca_componentes.md §10).
 *   2. Páginas legales (condicional, Sprint 5+, sin implementar aún) —
 *      cuando se active, reutiliza este mismo archivo con otro `items`.
 *
 * El panel anima con `grid-template-rows` (0fr → 1fr), no `max-height`
 * (docs/design_system.md §11.2, fila Accordion: "no height:auto
 * abrupto"). Por eso el panel permanece siempre en el flujo (no usa el
 * atributo `hidden`) y en su lugar usa `inert` mientras está colapsado,
 * para que sus enlaces no sean alcanzables por teclado/lector de
 * pantalla estando invisibles — mismo criterio que ya documenta el
 * contrato de Modal (`biblioteca_componentes.md` §6, "aria-hidden/inert
 * mientras está abierto").
 *
 * @param array $args {
 *     @type array $items Obligatorio. Array de arrays:
 *         @type string $id      Opcional. Id único del panel; si se
 *                                omite, se genera a partir del índice.
 *         @type string $title   Obligatorio. Texto del botón trigger.
 *         @type string $content Obligatorio. HTML ya resuelto y escapado
 *                                por el llamador (biblioteca_componentes.md
 *                                §6, props `items` de `{title, content}`).
 *     @type bool $allow_multiple_open Default false — abrir un ítem
 *         cierra los demás (comportamiento estándar de acordeón de
 *         navegación).
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_accordion_items = isset( $args['items'] ) && is_array( $args['items'] ) ? array_values( $args['items'] ) : array();

// Sin ítems válidos, no hay nada que imprimir — nunca un accordion vacío.
if ( ! $ses_accordion_items ) {
	return;
}

$ses_allow_multiple = ! empty( $args['allow_multiple_open'] );
?>
<div class="accordion" data-allow-multiple="<?php echo $ses_allow_multiple ? 'true' : 'false'; ?>">
	<?php
	foreach ( $ses_accordion_items as $ses_index => $ses_item ) :
		if ( ! is_array( $ses_item ) || empty( $ses_item['title'] ) || ! isset( $ses_item['content'] ) ) {
			continue;
		}

		$ses_panel_id   = ! empty( $ses_item['id'] ) ? (string) $ses_item['id'] : 'accordion-panel-' . $ses_index;
		$ses_trigger_id = $ses_panel_id . '-trigger';
		?>
		<div class="accordion-item">
			<button
				type="button"
				id="<?php echo esc_attr( $ses_trigger_id ); ?>"
				class="accordion-trigger"
				aria-expanded="false"
				aria-controls="<?php echo esc_attr( $ses_panel_id ); ?>"
			>
				<?php echo esc_html( $ses_item['title'] ); ?>
				<svg class="chevron" width="9" height="6" viewBox="0 0 9 6" fill="none" aria-hidden="true"><path d="M1 1L4.5 5L8 1" stroke="currentColor" stroke-width="1.3"/></svg>
			</button>
			<div
				id="<?php echo esc_attr( $ses_panel_id ); ?>"
				class="accordion-panel"
				role="region"
				aria-labelledby="<?php echo esc_attr( $ses_trigger_id ); ?>"
				inert
			>
				<div class="accordion-panel-inner">
					<?php echo $ses_item['content']; // phpcs:ignore WordPress.Security.EscapeOutput -- HTML ya escapado por el llamador antes de construir $args['items'], mismo criterio que el SVG de mega-menu.php. ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
