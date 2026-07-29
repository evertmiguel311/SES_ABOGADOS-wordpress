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
 * menú nativas de WordPress. Aquí se hardcodean en su lugar porque cada
 * columna es una `<ul>`/`<li>` con reset propio (`.grid-list-reset`,
 * mismo patrón que Grid de tarjetas, docs/biblioteca_componentes.md §1) y
 * el walker por defecto de `wp_nav_menu()` no produce ese marcado exacto
 * — usarlo tal cual introduciría una diferencia visual (viñetas/indentado
 * sin resetear) que no está en el diseño. Las ubicaciones de menú quedan
 * registradas para el día que se justifique un Walker propio; mientras
 * tanto, este es el único lugar que hay que tocar si cambia el contenido,
 * no header.php ni footer.php.
 *
 * Los 4 grupos de práctica vienen de `ses_get_grupos_practica()`
 * (inc/template-tags.php), la misma fuente que usa mega-menu.php —
 * evita mantener dos arrays con las mismas etiquetas/URLs.
 *
 * El correo/ciudad de la columna "Contacto" viene de
 * `ses_get_contact_data()` (inc/template-tags.php), la misma fuente que
 * usa header.php — pasa a leerse de la Options Page "Datos de contacto"
 * (docs/wordpress.md §6) cuando se construya Contacto (Sprint 8), sin
 * tocar este archivo.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_quienes_somos = home_url( '/quienes-somos/' );
$ses_footer_grupos = ses_get_grupos_practica();
$ses_contact       = ses_get_contact_data();
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
				<h3 class="footer-col-title"><?php esc_html_e( 'Firma', 'ses-abogados' ); ?></h3>
				<ul class="footer-links grid-list-reset">
					<li><a href="<?php echo esc_url( $ses_quienes_somos . '#firma' ); ?>"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></a></li>
					<li><a href="<?php echo esc_url( $ses_quienes_somos . '#equipo' ); ?>"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/actualidad-juridica/' ) ); ?>"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a></li>
				</ul>
			</div>

			<div>
				<h3 class="footer-col-title"><?php esc_html_e( 'Áreas de Práctica', 'ses-abogados' ); ?></h3>
				<ul class="footer-links grid-list-reset">
					<?php foreach ( $ses_footer_grupos as $ses_grupo ) : ?>
						<li><a href="<?php echo esc_url( $ses_grupo['url'] ); ?>"><?php echo esc_html( $ses_grupo['short'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h3 class="footer-col-title"><?php esc_html_e( 'Contacto', 'ses-abogados' ); ?></h3>
				<div class="footer-links footer-contact-info">
					<span><?php echo esc_html( $ses_contact['city'] ); ?></span>
					<span><?php echo esc_html( $ses_contact['email'] ); ?></span>
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
