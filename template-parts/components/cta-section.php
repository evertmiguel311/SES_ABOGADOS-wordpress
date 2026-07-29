<?php
/**
 * CTA Section — docs/biblioteca_componentes.md §3.
 *
 * Franja de llamado a la acción antes del Footer, reutilizada tal cual en
 * Home, Quiénes Somos y Áreas de Práctica (prototipo/*.html
 * .cta-contacto). El diseño aprobado solo tiene un tratamiento de fondo
 * (`.cta-contacto`, azul institucional) — no se inventa una segunda
 * variante "grafito" que el prototipo no usa (CLAUDE.md §6/§15, mismo
 * criterio que Button).
 *
 * @param array $args {
 *     @type string $title         Obligatorio.
 *     @type string $description   Opcional — no todas las apariciones lo usan.
 *     @type array  $cta_primary   Obligatorio. {label, url}.
 *     @type array  $cta_secondary Opcional. {label, url}.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_title = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$ses_cta_primary = isset( $args['cta_primary'] ) && is_array( $args['cta_primary'] ) ? $args['cta_primary'] : array();
if ( '' === $ses_title || empty( $ses_cta_primary['label'] ) || empty( $ses_cta_primary['url'] ) ) {
	return;
}

$ses_description   = isset( $args['description'] ) ? trim( (string) $args['description'] ) : '';
$ses_cta_secondary = isset( $args['cta_secondary'] ) && is_array( $args['cta_secondary'] ) ? $args['cta_secondary'] : array();
?>
<section class="cta-contacto">
	<div class="cta-contacto-inner reveal">
		<h2><?php echo esc_html( $ses_title ); ?></h2>
		<?php if ( $ses_description ) : ?><p><?php echo esc_html( $ses_description ); ?></p><?php endif; ?>
		<?php get_template_part( 'template-parts/components/button', null, array( 'label' => $ses_cta_primary['label'], 'href' => $ses_cta_primary['url'], 'variant' => 'solid-light' ) ); ?>
		<?php if ( ! empty( $ses_cta_secondary['label'] ) && ! empty( $ses_cta_secondary['url'] ) ) : ?>
			<?php get_template_part( 'template-parts/components/button', null, array( 'label' => $ses_cta_secondary['label'], 'href' => $ses_cta_secondary['url'], 'variant' => 'outline-dark' ) ); ?>
		<?php endif; ?>
	</div>
</section>
