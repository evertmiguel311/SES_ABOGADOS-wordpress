<?php
/**
 * Quiénes Somos (`/quienes-somos`) — Sprint 5, docs/roadmap.md.
 *
 * `page-{slug}.php`, jerarquía de plantillas estándar (docs/wordpress.md
 * §10). Contenido real de docs/textos.md y docs/equipo.md — los valores
 * institucionales y el conteo de socios están explícitamente marcados
 * como pendientes de confirmación del cliente, igual que en el prototipo
 * aprobado (SES_ABOGADOS-sitio/prototipo/quienes-somos.html), no se
 * inventa certeza donde el propio contenido fuente no la tiene
 * (CLAUDE.md §14/§15).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main">
		<?php
		get_template_part(
			'template-parts/components/hero',
			null,
			array(
				'variant'  => 'interior',
				'eyebrow'  => __( 'Quiénes Somos', 'ses-abogados' ),
				'title'    => __( 'Una firma construida sobre rigor técnico y relaciones de largo plazo', 'ses-abogados' ),
				'subtitle' => __( 'SES Abogados acompaña a empresas, entidades públicas y personas naturales colombianas con práctica integral en derecho público, corporativo, inmobiliario, laboral, civil y litigio, con sede en Cartagena y cobertura en todo el territorio nacional.', 'ses-abogados' ),
			)
		);
		?>

		<section id="firma" class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<div class="firma-grid reveal">
				<div class="firma-img stock-photo-wrap">
					<img class="stock-photo" src="https://picsum.photos/seed/ses-fachada-cartagena/900/720" alt="<?php esc_attr_e( 'Fachada de oficina institucional en Cartagena (fotografía de stock, temporal)', 'ses-abogados' ); ?>" loading="lazy">
				</div>
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></div>
					<h2 class="firma-title"><?php esc_html_e( 'Misión', 'ses-abogados' ); ?></h2>
					<p class="firma-text"><?php esc_html_e( 'Brindar asesoría jurídica de alta complejidad con solidez técnica, cercanía institucional y compromiso con los resultados, acompañando a nuestros clientes en cada etapa de sus procesos legales.', 'ses-abogados' ); ?></p>
					<h2 class="firma-title" style="margin-top: 8px;"><?php esc_html_e( 'Visión', 'ses-abogados' ); ?></h2>
					<p class="firma-text" style="margin-bottom: 0;"><?php esc_html_e( 'Ser una firma de referencia en Colombia por la solidez de su criterio jurídico y la confianza que construye con cada cliente, con una práctica integral que abarca desde el derecho público y corporativo hasta el litigio y las especialidades complementarias.', 'ses-abogados' ); ?></p>
				</div>
			</div>

			<div class="stats-grid-light reveal">
				<?php
				foreach (
					array(
						array( 'value' => '4', 'label' => __( 'Grupos de práctica', 'ses-abogados' ) ),
						array( 'value' => '12', 'label' => __( 'Sub-especialidades', 'ses-abogados' ) ),
						array( 'value' => __( 'Nacional', 'ses-abogados' ), 'label' => __( 'Cobertura en Colombia', 'ses-abogados' ) ),
					) as $ses_stat
				) {
					get_template_part( 'template-parts/components/stat-tile', null, array_merge( $ses_stat, array( 'light' => true ) ) );
				}
				?>
			</div>
		</section>

		<section class="<?php echo esc_attr( ses_section_class( 'crema' ) ); ?>">
			<div style="max-width: 1280px; margin: 0 auto;">
				<div class="reveal">
					<h2 class="firma-title" style="margin-bottom: 12px;"><?php esc_html_e( 'Los principios que guían cada asesoría', 'ses-abogados' ); ?></h2>
					<p style="font-size: 13.5px; color: var(--color-texto-secundario); margin-bottom: 40px;"><?php esc_html_e( 'Valores institucionales sugeridos — pendientes de confirmación final del cliente.', 'ses-abogados' ); ?></p>
				</div>
				<div class="valores-grid">
					<?php
					$ses_valores = array(
						array(
							'icon'        => '<path d="M18 4L30 9V17C30 25 25 30.5 18 33C11 30.5 6 25 6 17V9L18 4Z" stroke="currentColor" stroke-width="1.2"/>',
							'title'       => __( 'Rigor técnico', 'ses-abogados' ),
							'description' => __( 'Análisis riguroso y actualizado de cada asunto jurídico, sin atajos.', 'ses-abogados' ),
						),
						array(
							'icon'        => '<circle cx="18" cy="18" r="13" stroke="currentColor" stroke-width="1.2"/><path d="M12 18L16 22L24 13" stroke="currentColor" stroke-width="1.2"/>',
							'title'       => __( 'Integridad', 'ses-abogados' ),
							'description' => __( 'Confidencialidad absoluta y ética profesional en cada relación.', 'ses-abogados' ),
						),
						array(
							'icon'        => '<rect x="6" y="10" width="24" height="20" stroke="currentColor" stroke-width="1.2"/><path d="M6 16H30" stroke="currentColor" stroke-width="1.2"/><path d="M12 10V6H24V10" stroke="currentColor" stroke-width="1.2"/>',
							'title'       => __( 'Compromiso institucional', 'ses-abogados' ),
							'description' => __( 'Visión de largo plazo, más allá de la transacción puntual.', 'ses-abogados' ),
						),
						array(
							'icon'        => '<circle cx="13" cy="14" r="4.5" stroke="currentColor" stroke-width="1.2"/><circle cx="23" cy="14" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M5 30C5 24 8.5 20.5 13 20.5C17.5 20.5 21 24 21 30" stroke="currentColor" stroke-width="1.2"/><path d="M18 30C18 24 21 20.5 25.5 20.5C27.5 20.5 29.5 21.5 31 23" stroke="currentColor" stroke-width="1.2"/>',
							'title'       => __( 'Cercanía', 'ses-abogados' ),
							'description' => __( 'Trato directo con los socios, sin intermediarios ni burocracia.', 'ses-abogados' ),
						),
						array(
							'icon'        => '<path d="M6 28L14 18L20 24L30 10" stroke="currentColor" stroke-width="1.2"/><path d="M22 10H30V18" stroke="currentColor" stroke-width="1.2"/>',
							'title'       => __( 'Orientación a resultados', 'ses-abogados' ),
							'description' => __( 'Ejecución técnica enfocada en el objetivo real del cliente.', 'ses-abogados' ),
						),
					);
					foreach ( $ses_valores as $ses_index => $ses_valor ) {
						get_template_part( 'template-parts/components/differentiator-item', null, array_merge( $ses_valor, array( 'reveal_delay' => $ses_index ) ) );
					}
					?>
				</div>
			</div>
		</section>

		<section id="equipo" class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<div class="reveal">
				<div class="eyebrow"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></div>
				<h2 class="firma-title"><?php esc_html_e( 'Socios fundadores', 'ses-abogados' ); ?></h2>
			</div>
			<p class="equipo-nota reveal"><?php esc_html_e( 'La razón social es "Sierra Elles & Salgado Abogados S.A.S.". Esta sección presenta a los dos socios confirmados por la firma; está pendiente de confirmar si existe un tercer socio ("Salgado") o asociados adicionales a incluir.', 'ses-abogados' ); ?></p>

			<?php
			get_template_part(
				'template-parts/components/card-grid',
				null,
				array(
					'items'      => ses_get_equipo_socios( 'full' ),
					'card_type'  => 'team',
					'grid_class' => 'equipo-grid-full',
				)
			);
			?>
		</section>

		<?php
		get_template_part(
			'template-parts/components/cta-section',
			null,
			array(
				'title'       => __( '¿Listo para conversar con nuestro equipo?', 'ses-abogados' ),
				'cta_primary' => array(
					'label' => __( 'Agendar Consulta', 'ses-abogados' ),
					'url'   => home_url( '/contacto/' ),
				),
			)
		);
		?>
	</main>

<?php
get_footer();
