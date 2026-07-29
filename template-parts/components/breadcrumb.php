<?php
/**
 * Breadcrumb — docs/biblioteca_componentes.md §2.
 *
 * Mismo aspecto visual ya aprobado en el prototipo (texto plano
 * "Label / Label / Actual" — prototipo/areas-de-practica/*.html
 * .breadcrumb-groups, prototipo/actualidad-juridica/*.html
 * .article-breadcrumb), con la estructura semántica que exige el
 * contrato y que el prototipo no tenía: <nav>+<ol>, `aria-current`
 * en el ítem actual (sin link) y separadores "/" marcados
 * `aria-hidden`. Cero cambio de color/tamaño/espaciado — ver reset en
 * assets/css/style.css junto a .breadcrumb-groups/.article-breadcrumb.
 *
 * No decide internamente qué clase de wrapper usar — la recibe vía
 * $args['wrapper_class'], igual que Grid de tarjetas, para no acoplar
 * el componente a un contexto de página concreto.
 *
 * @param array $args {
 *     @type array  $trail         Obligatorio. Array ordenado de
 *                                 {label, url}. El último ítem se trata
 *                                 siempre como la página actual (sin
 *                                 link, con aria-current), tenga o no
 *                                 `url`.
 *     @type string $wrapper_class Clase del <nav>. Default
 *                                 'breadcrumb-groups' (páginas de
 *                                 grupo). Usar 'article-breadcrumb' en
 *                                 la página de Artículo, o cualquier
 *                                 otra clase ya existente en el CSS.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_trail_raw = isset( $args['trail'] ) && is_array( $args['trail'] ) ? $args['trail'] : array();

$ses_trail = array();
foreach ( $ses_trail_raw as $ses_crumb ) {
	$ses_label = isset( $ses_crumb['label'] ) ? trim( (string) $ses_crumb['label'] ) : '';
	if ( '' === $ses_label ) {
		continue;
	}
	$ses_trail[] = array(
		'label' => $ses_label,
		'url'   => isset( $ses_crumb['url'] ) ? (string) $ses_crumb['url'] : '',
	);
}

// Sin al menos un cruce válido no hay nada que mostrar — nunca un <nav>/<ol> vacío.
if ( ! $ses_trail ) {
	return;
}

$ses_wrapper_class = isset( $args['wrapper_class'] ) && '' !== $args['wrapper_class']
	? (string) $args['wrapper_class']
	: 'breadcrumb-groups';

$ses_last_index = count( $ses_trail ) - 1;
?>
<nav class="<?php echo esc_attr( $ses_wrapper_class ); ?>" aria-label="<?php esc_attr_e( 'Ruta de navegación', 'ses-abogados' ); ?>">
	<ol>
		<?php foreach ( $ses_trail as $ses_index => $ses_crumb ) : ?>
			<?php $ses_is_last = ( $ses_index === $ses_last_index ); ?>
			<li<?php echo $ses_is_last ? ' aria-current="page"' : ''; ?>>
				<?php if ( ! $ses_is_last && '' !== $ses_crumb['url'] ) : ?>
					<a href="<?php echo esc_url( $ses_crumb['url'] ); ?>"><?php echo esc_html( $ses_crumb['label'] ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $ses_crumb['label'] ); ?>
				<?php endif; ?>
			</li>
			<?php if ( ! $ses_is_last ) : ?>
				<li aria-hidden="true">/</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ol>
</nav>
