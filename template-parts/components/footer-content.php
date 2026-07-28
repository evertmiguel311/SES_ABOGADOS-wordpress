<?php
/**
 * Footer — docs/biblioteca_componentes.md §2.
 *
 * Footer de 4 columnas + barra inferior, presente en toda página, sin
 * variar entre plantillas. Markup y clases idénticas al prototipo
 * aprobado (prototipo/index.html) — implementación completa de Sprint 4
 * (docs/roadmap.md — "Footer de 4 columnas con copyright confirmado").
 *
 * NOTA (misma justificación que mega-menu.php): docs/wordpress.md §4
 * registra `menu-footer-nav` y `menu-footer-areas` como ubicaciones de
 * menú nativas de WordPress. Aquí se hardcodean en su lugar porque el
 * marcado del diseño aprobado es una lista plana de <a> sin <li>
 * (`.footer-links a`), y el walker por defecto de `wp_nav_menu()` siempre
 * envuelve cada ítem en <li> — usar el menú nativo tal cual introduciría
 * una diferencia visual (viñetas/indentado) que no está en el diseño. Las
 * ubicaciones de menú quedan registradas para el día que se justifique un
 * Walker propio; mientras tanto, este es el único lugar que hay que tocar
 * si cambia el contenido, no header.php ni footer.php.
 *
 * Los 4 grupos de práctica vienen de `ses_get_grupos_practica()`
 * (inc/template-tags.php), la misma fuente que usa mega-menu.php —
 * evita mantener dos arrays con las mismas etiquetas/URLs.
 *
 * El correo/ciudad de la columna "Contacto" se hardcodea con el dato ya
 * confirmado por el cliente (CLAUDE.md §1); pasa a leerse de la Options
 * Page "Datos de contacto" (docs/wordpress.md §6) cuando se construya
 * Contacto (Sprint 8).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_quienes_somos = home_url( '/quienes-somos/' );
$ses_footer_grupos = ses_get_grupos_practica();
?>
<footer class="site-footer">
	<div class="footer-inner">
		<div class="footer-grid">
			<div>
				<div class="footer-logo">
					<img src="<?php echo esc_url( SES_THEME_URI . '/assets/images/isotipo-blanco.png' ); ?>" alt="" class="footer-logo-mark" aria-hidden="true">
					<?php esc_html_e( 'SES', 'ses-abogados' ); ?> <span><?php esc_html_e( 'ABOGADOS', 'ses-abogados' ); ?></span>
				</div>
				<p class="footer-desc">
					<?php esc_html_e( 'Sierra Elles & Salgado Abogados S.A.S. Firma jurídica full-service con sede en Cartagena y cobertura nacional.', 'ses-abogados' ); ?>
				</p>
			</div>

			<div>
				<div class="footer-col-title"><?php esc_html_e( 'Firma', 'ses-abogados' ); ?></div>
				<div class="footer-links">
					<a href="<?php echo esc_url( $ses_quienes_somos . '#firma' ); ?>"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></a>
					<a href="<?php echo esc_url( $ses_quienes_somos . '#equipo' ); ?>"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/actualidad-juridica/' ) ); ?>"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a>
				</div>
			</div>

			<div>
				<div class="footer-col-title"><?php esc_html_e( 'Áreas de Práctica', 'ses-abogados' ); ?></div>
				<div class="footer-links">
					<?php foreach ( $ses_footer_grupos as $ses_grupo ) : ?>
						<a href="<?php echo esc_url( $ses_grupo['url'] ); ?>"><?php echo esc_html( $ses_grupo['short'] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div>
				<div class="footer-col-title"><?php esc_html_e( 'Contacto', 'ses-abogados' ); ?></div>
				<div class="footer-links footer-contact-info">
					<span><?php esc_html_e( 'Cartagena, Colombia', 'ses-abogados' ); ?></span>
					<span><?php echo esc_html( 'sierraellesabogados@gmail.com' ); ?></span>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<span><?php echo esc_html( ses_get_copyright_text() ); ?></span>
			<div class="footer-legal-links">
				<a href="<?php echo esc_url( home_url( '/politica-datos/' ) ); ?>"><?php esc_html_e( 'Política de Tratamiento de Datos', 'ses-abogados' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terminos/' ) ); ?>"><?php esc_html_e( 'Términos y Condiciones', 'ses-abogados' ); ?></a>
			</div>
		</div>
	</div>
</footer>
