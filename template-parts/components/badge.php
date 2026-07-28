<?php
/**
 * Badge — docs/biblioteca_componentes.md §6.
 *
 * Responsabilidad: etiqueta corta no interactiva (a diferencia de
 * Category Badge, que sí puede ser link). Tono `neutral` o `accent`.
 * Si necesita interacción, no es un Badge — es Category Badge o Button.
 *
 * @param array $args {
 *     @type string $label Texto visible. Obligatorio.
 *     @type string $tone  'neutral' (default) | 'accent'.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_label = isset( $args['label'] ) ? trim( (string) $args['label'] ) : '';
if ( '' === $ses_label ) {
	return;
}

$ses_tone    = isset( $args['tone'] ) && 'accent' === $args['tone'] ? 'accent' : 'neutral';
$ses_classes = 'accent' === $ses_tone ? 'badge badge-accent' : 'badge';
?>
<span class="<?php echo esc_attr( $ses_classes ); ?>"><?php echo esc_html( $ses_label ); ?></span>
