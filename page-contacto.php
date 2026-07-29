<?php
/**
 * Contacto (`/contacto`) — Sprint 5, docs/roadmap.md.
 *
 * `page-{slug}.php` (docs/wordpress.md §10). Construye la ESTRUCTURA
 * VISUAL del formulario y del bloque de contacto directo aprobados en el
 * prototipo (prototipo/contacto.html) — sin backend real todavía: sin
 * envío, sin CAPTCHA, sin validación de servidor, sin Options Page ACF
 * leída. Eso es Sprint 8 completo (docs/roadmap.md), y contact-form.php /
 * captcha-field.php / contact-info-block.php / map-embed.php ya están
 * documentados como "Pendiente de implementación (Sprint 8)" en su propio
 * docblock — por eso este bloque no los reescribe como componentes
 * reutilizables todavía; arma el markup directamente en la página, igual
 * que hace el propio prototipo, y deja el punto de enganche documentado
 * abajo.
 *
 * El correo/ciudad ya sí vienen de ses_get_contact_data() (Bloque 4.1,
 * fuente compartida con Header/Footer) — el teléfono/WhatsApp y la
 * dirección exacta siguen sin confirmar (docs/solicitud_informacion_cliente.md),
 * por lo que se muestran como "pendiente", igual que en el prototipo, no
 * como un dato inventado (CLAUDE.md §15).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ses_contact = ses_get_contact_data();
?>

	<main id="main" class="site-main">
		<?php
		get_template_part(
			'template-parts/components/hero',
			null,
			array(
				'variant'  => 'interior',
				'eyebrow'  => __( 'Contacto', 'ses-abogados' ),
				'title'    => __( 'Conversemos sobre su próximo paso jurídico', 'ses-abogados' ),
				'subtitle' => __( 'Complete el formulario y un miembro de nuestro equipo se pondrá en contacto con usted a la brevedad.', 'ses-abogados' ),
			)
		);
		?>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<div class="contact-grid">

				<?php
				/*
				 * Formulario visual (Sprint 5). Sprint 8 lo conecta a
				 * contact-form.php + captcha-field.php: nonce de WordPress,
				 * sanitización de servidor (CLAUDE.md §8) y CAPTCHA antes de
				 * quitar `onsubmit="return false;"` — dejarlo enviar de verdad
				 * hoy solo produciría una recarga de página sin destino real,
				 * peor que un formulario visual honesto (CLAUDE.md §5, no
				 * soluciones temporales que contradigan la arquitectura).
				 */
				?>
				<form class="contact-form reveal" onsubmit="return false;">
					<div class="field-row">
						<div>
							<label for="f-nombre"><?php esc_html_e( 'Nombre completo', 'ses-abogados' ); ?></label>
							<input id="f-nombre" name="nombre" type="text" placeholder="<?php esc_attr_e( 'Nombre y apellido', 'ses-abogados' ); ?>" required>
						</div>
						<div>
							<label for="f-correo"><?php esc_html_e( 'Correo electrónico', 'ses-abogados' ); ?></label>
							<input id="f-correo" name="correo" type="email" placeholder="correo@empresa.com" required>
						</div>
					</div>
					<div class="field-row">
						<div class="field-full">
							<label for="f-telefono"><?php esc_html_e( 'Teléfono', 'ses-abogados' ); ?></label>
							<input id="f-telefono" name="telefono" type="tel" placeholder="+57 300 000 0000">
						</div>
						<div class="field-full">
							<label for="f-area"><?php esc_html_e( 'Área de interés', 'ses-abogados' ); ?></label>
							<select id="f-area" name="area">
								<?php foreach ( ses_get_grupos_practica() as $ses_grupo ) : ?>
									<option><?php echo esc_html( $ses_grupo['title'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="field-full">
						<label for="f-mensaje"><?php esc_html_e( 'Mensaje', 'ses-abogados' ); ?></label>
						<textarea id="f-mensaje" name="mensaje" rows="5" placeholder="<?php esc_attr_e( 'Cuéntenos brevemente su caso', 'ses-abogados' ); ?>" required></textarea>
					</div>
					<p style="font-size:12.5px; color:var(--color-texto-secundario); margin: 4px 0 22px;">
						<?php esc_html_e( 'En la versión final este formulario incluirá CAPTCHA y validación en servidor (WordPress), según CLAUDE.md sección 8.', 'ses-abogados' ); ?>
					</p>
					<button type="submit" class="contact-submit"><?php esc_html_e( 'Enviar Mensaje', 'ses-abogados' ); ?></button>
					<p class="policy-note">
						<?php
						printf(
							/* translators: %s: enlace a la Política de Tratamiento de Datos. */
							esc_html__( 'Al enviar este formulario, usted acepta nuestra %s.', 'ses-abogados' ),
							'<a href="' . esc_url( home_url( '/politica-datos/' ) ) . '" style="color:var(--color-grafito); border-bottom:1px solid var(--color-grafito);">' . esc_html__( 'Política de Tratamiento de Datos', 'ses-abogados' ) . '</a>'
						);
						?>
					</p>
				</form>

				<div class="info-col reveal">
					<div class="info-block">
						<div class="info-label"><?php esc_html_e( 'Oficina', 'ses-abogados' ); ?></div>
						<div class="info-text"><?php echo esc_html( $ses_contact['city'] ); ?></div>
					</div>
					<div class="info-block">
						<div class="info-label"><?php esc_html_e( 'Correo', 'ses-abogados' ); ?></div>
						<div class="info-text"><?php echo esc_html( $ses_contact['email'] ); ?></div>
					</div>
					<div class="info-block">
						<div class="info-label"><?php esc_html_e( 'Teléfono / WhatsApp', 'ses-abogados' ); ?></div>
						<div class="info-text info-pending"><?php esc_html_e( 'Pendiente de confirmación', 'ses-abogados' ); ?></div>
					</div>
					<div class="info-block">
						<div class="info-label"><?php esc_html_e( 'Horario de atención', 'ses-abogados' ); ?></div>
						<div class="info-text"><?php esc_html_e( 'Lunes a viernes', 'ses-abogados' ); ?><br><?php esc_html_e( 'Horario pendiente de confirmar', 'ses-abogados' ); ?></div>
					</div>
					<?php
					/*
					 * Map embed (Sprint 8, map-embed.php): marcador neutro
					 * mientras no exista la dirección exacta de la oficina
					 * (docs/roadmap.md, criterio P1 de Sprint 8).
					 */
					?>
					<div class="map-placeholder" style="aspect-ratio:4/3;">
						<svg width="34" height="34" viewBox="0 0 40 40" fill="none" aria-hidden="true"><path d="M20 36C20 36 31 26.5 31 17C31 10.9 26.1 6 20 6C13.9 6 9 10.9 9 17C9 26.5 20 36 20 36Z" stroke="currentColor" stroke-width="1.3"/><circle cx="20" cy="17" r="4" stroke="currentColor" stroke-width="1.3"/></svg>
						<span><?php esc_html_e( 'Mapa de ubicación', 'ses-abogados' ); ?><br><?php esc_html_e( 'Pendiente de la dirección exacta de la oficina', 'ses-abogados' ); ?></span>
					</div>
				</div>
			</div>
		</section>
	</main>

<?php
get_footer();
