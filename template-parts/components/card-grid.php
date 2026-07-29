<?php
/**
 * Grid de tarjetas — docs/biblioteca_componentes.md §1.
 *
 * Distribuye Practice Area Card / Team Card / Article Card como lista
 * semántica <ul><li>. El prototipo aprobado usa <div> con las tarjetas
 * como hijos directos (.areas-grid, .grupos-landing-grid, .equipo-grid,
 * .equipo-grid-full, .blog-grid, .actualidad-grid, .related-grid) — se
 * preserva cada uno de esos grids tal cual (columnas, gap, breakpoints,
 * nada tocado) sobre un <ul>, con un reset puramente visual
 * (.grid-list-reset, nuevo, aditivo, assets/css/design-system.css) que
 * anula viñeta/margen/padding por defecto del navegador. Cero cambio
 * visible.
 *
 * No decide qué grid_class ni qué página lo usa — eso lo decide el
 * llamador (la clase de grid ya existente del contexto), manteniendo
 * el componente desacoplado del contenido que envuelve
 * (docs/biblioteca_componentes.md §10, regla de composición 1).
 *
 * @param array $args {
 *     @type array  $items      Obligatorio. Array de arrays; cada uno
 *                              son los $args del Card correspondiente
 *                              (practice-area-card.php / team-card.php /
 *                              article-card.php), tal cual espera ese
 *                              componente.
 *     @type string $card_type  Obligatorio. 'practice-area' | 'team' | 'article'.
 *     @type string $grid_class Obligatorio. Clase de grid ya existente
 *                              en el CSS del contexto (p.ej.
 *                              'areas-grid', 'blog-grid', 'equipo-grid').
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_items      = isset( $args['items'] ) && is_array( $args['items'] ) ? array_values( $args['items'] ) : array();
$ses_card_type  = isset( $args['card_type'] ) ? (string) $args['card_type'] : '';
$ses_grid_class = isset( $args['grid_class'] ) ? trim( (string) $args['grid_class'] ) : '';

$ses_card_map = array(
	'practice-area' => 'template-parts/components/practice-area-card',
	'team'          => 'template-parts/components/team-card',
	'article'       => 'template-parts/components/article-card',
);

// Sin items, sin tipo de tarjeta reconocido o sin clase de grid, no hay
// nada válido que imprimir — nunca un <ul> vacío.
if ( ! $ses_items || ! $ses_grid_class || ! isset( $ses_card_map[ $ses_card_type ] ) ) {
	return;
}

$ses_card_template = $ses_card_map[ $ses_card_type ];
?>
<ul class="<?php echo esc_attr( $ses_grid_class ); ?> grid-list-reset">
	<?php foreach ( $ses_items as $ses_item ) : ?>
		<?php if ( ! is_array( $ses_item ) ) : ?>
			<?php continue; ?>
		<?php endif; ?>
		<li>
			<?php get_template_part( $ses_card_template, null, $ses_item ); ?>
		</li>
	<?php endforeach; ?>
</ul>
