<?php
/**
 * Mega Menu (Áreas de Práctica) — docs/biblioteca_componentes.md §2.
 *
 * Presenta los 4 grupos × 12 sub-especialidades sin necesitar 12 rutas
 * propias (decisión de alcance, docs/estructura_web.md). Markup y clases
 * idénticas al prototipo aprobado (prototipo/index.html).
 *
 * NOTA IMPORTANTE (justificación de una desviación temporal de
 * docs/wordpress.md §4): la arquitectura definitiva dice que este menú
 * se genera a partir de las 4 páginas de grupo y su campo ACF
 * `sub_especialidades`, no de un array hardcodeado — pero esas 4 páginas
 * todavía no existen (son Sprint 6, docs/roadmap.md). Mientras tanto, el
 * contenido (fijo y ya confirmado en docs/servicios.md) viene de
 * `ses_get_grupos_practica()` (inc/template-tags.php) — fuente única
 * compartida con footer-content.php, para no mantener dos copias del
 * mismo dato — y se reemplaza por la versión dinámica en un solo lugar
 * cuando esas páginas existan, sin tocar header.php ni navbar.php.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_areas_base       = home_url( '/areas-de-practica' );
$ses_mega_menu_groups = ses_get_grupos_practica();
?>
<div class="mega-menu-wrap">
	<button type="button" class="mega-trigger" aria-haspopup="true" aria-expanded="false" aria-controls="areas-mega-menu">
		<?php esc_html_e( 'Áreas de Práctica', 'ses-abogados' ); ?>
		<svg class="chevron" width="9" height="6" viewBox="0 0 9 6" fill="none" aria-hidden="true"><path d="M1 1L4.5 5L8 1" stroke="currentColor" stroke-width="1.3"/></svg>
	</button>

	<div class="mega-menu" id="areas-mega-menu" hidden>
		<div class="mega-menu-inner">
			<div class="mega-menu-grid">
				<?php foreach ( $ses_mega_menu_groups as $ses_group ) : ?>
					<div class="mega-col">
						<div class="mega-icon" aria-hidden="true">
							<svg width="32" height="32" viewBox="0 0 40 40" fill="none"><?php echo $ses_group['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- SVG fijo definido en este archivo, no proviene de entrada de usuario. ?></svg>
						</div>
						<div class="mega-col-title"><?php echo esc_html( $ses_group['title'] ); ?></div>
						<div class="mega-col-links">
							<?php foreach ( $ses_group['links'] as $ses_link ) : ?>
								<a href="<?php echo esc_url( $ses_group['url'] . '#' . $ses_link['anchor'] ); ?>"><?php echo esc_html( $ses_link['label'] ); ?></a>
							<?php endforeach; ?>
						</div>
						<a href="<?php echo esc_url( $ses_group['url'] ); ?>" class="mega-col-cta"><?php esc_html_e( 'Ver grupo', 'ses-abogados' ); ?></a>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="mega-menu-footer">
				<span><?php esc_html_e( '4 grupos de práctica · 12 sub-especialidades', 'ses-abogados' ); ?></span>
				<a href="<?php echo esc_url( $ses_areas_base . '/' ); ?>"><?php esc_html_e( 'Ver todas las áreas', 'ses-abogados' ); ?></a>
			</div>
		</div>
	</div>
</div>
