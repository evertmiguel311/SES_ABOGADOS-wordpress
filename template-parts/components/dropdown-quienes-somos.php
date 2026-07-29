<?php
/**
 * Dropdown simple (Quiénes Somos) — docs/biblioteca_componentes.md §2.
 *
 * Acceso a 2 sub-rutas fijas dentro de la misma página "Quiénes Somos"
 * (anclas #firma / #equipo, docs/estructura_web.md) — conjunto fijo y
 * conocido, no se diseña para crecer (CLAUDE.md §5). Markup y clases
 * idénticas al prototipo aprobado (prototipo/index.html).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_quienes_somos_url = home_url( '/quienes-somos/' );
?>
<div class="dropdown">
	<button type="button" class="dropdown-trigger" aria-haspopup="true" aria-expanded="false" aria-controls="quienes-somos-panel">
		<?php esc_html_e( 'Quiénes Somos', 'ses-abogados' ); ?>
		<svg class="chevron" width="9" height="6" viewBox="0 0 9 6" fill="none" aria-hidden="true"><path d="M1 1L4.5 5L8 1" stroke="currentColor" stroke-width="1.3"/></svg>
	</button>
	<div class="dropdown-panel" id="quienes-somos-panel" hidden>
		<a href="<?php echo esc_url( $ses_quienes_somos_url . '#firma' ); ?>"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_quienes_somos_url . '#equipo' ); ?>"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></a>
	</div>
</div>
