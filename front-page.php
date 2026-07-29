<?php
/**
 * Home (`/`) — Sprint 5, docs/roadmap.md.
 *
 * Ensambla componentes ya existentes sobre el contenido real aprobado en
 * el prototipo (SES_ABOGADOS-sitio/prototipo/index.html) y en
 * docs/textos.md — sin inventar copy ni cifras (CLAUDE.md §14/§15).
 *
 * Los 3 artículos de "Actualidad Jurídica" son los mismos del prototipo
 * (contenido de ejemplo, aún sin CPT/taxonomía — Sprint 6/7,
 * docs/roadmap.md): puente temporal hardcodeado, mismo criterio que
 * ses_get_grupos_practica(), documentado como tal, a reemplazar por
 * WP_Query cuando exista el blog real.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ses_grupos = ses_get_grupos_practica();

// Puente temporal (Sprint 6/7 lo reemplaza por WP_Query real sobre `post`).
$ses_articulos_recientes = array(
	array(
		'title'        => __( 'Reforma al régimen societario: qué deben revisar las empresas en 2026', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/reforma-regimen-societario-2026/' ),
		'category'     => __( 'Derecho Corporativo', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-1/700/525',
		'date_display' => '12 jun 2026',
		'date_iso'     => '2026-06-12',
		'reading_time' => __( '5 min de lectura', 'ses-abogados' ),
	),
	array(
		'title'        => __( 'Titulación rural: rutas legales para regularizar predios', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/titulacion-rural-regularizar-predios/' ),
		'category'     => __( 'Derecho Inmobiliario', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-2/700/525',
		'date_display' => '28 may 2026',
		'date_iso'     => '2026-05-28',
		'reading_time' => __( '4 min de lectura', 'ses-abogados' ),
	),
	array(
		'title'        => __( 'Nuevas reglas de teletrabajo: implicaciones para el empleador', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/nuevas-reglas-teletrabajo/' ),
		'category'     => __( 'Derecho Laboral', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-3/700/525',
		'date_display' => '14 may 2026',
		'date_iso'     => '2026-05-14',
		'reading_time' => __( '6 min de lectura', 'ses-abogados' ),
	),
);
?>

	<main id="main" class="site-main site-main--front">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;

		get_template_part(
			'template-parts/components/hero',
			null,
			ses_get_hero_args(
				array(
					'variant'       => 'home',
					'eyebrow'       => __( 'Firma jurídica full-service · Colombia', 'ses-abogados' ),
					'title'         => __( 'Su tranquilidad, nuestra misión legal.', 'ses-abogados' ),
					'subtitle'      => __( 'Firma jurídica colombiana con práctica integral en derecho público, corporativo, inmobiliario, laboral, civil y litigio. Acompañamos a empresas, entidades públicas y personas naturales en los procesos de mayor complejidad, con cobertura en todo el territorio nacional.', 'ses-abogados' ),
					'cta_primary'   => array(
						'label' => __( 'Agendar Consulta', 'ses-abogados' ),
						'url'   => home_url( '/contacto/' ),
					),
					'cta_secondary' => array(
						'label' => __( 'Conozca más sobre nosotros', 'ses-abogados' ),
						'url'   => home_url( '/quienes-somos/' ),
					),
					'image_url'     => 'https://picsum.photos/seed/ses-fachada/700/900',
					'image_alt'     => __( 'Fachada de edificio institucional (fotografía de stock, temporal)', 'ses-abogados' ),
					'seal_url'      => SES_THEME_URI . '/assets/images/ses-sello-azul.png',
					'stats'         => ses_get_cifras_institucionales(),
				)
			)
		);
		?>

		<section id="areas" class="<?php echo esc_attr( ses_section_class( 'white' ) . ' areas-practica' ); ?>">
			<div class="areas-head reveal">
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Áreas de Práctica', 'ses-abogados' ); ?></div>
					<h2><?php esc_html_e( 'Un equipo multidisciplinario para cada necesidad jurídica', 'ses-abogados' ); ?></h2>
				</div>
				<p class="areas-intro"><?php esc_html_e( 'Organizamos nuestra práctica en cuatro grupos que cubren doce sub-especialidades, permitiendo una asesoría integral y coordinada para empresas, entidades públicas y personas naturales.', 'ses-abogados' ); ?></p>
			</div>

			<?php
			$ses_areas_items = array();
			foreach ( $ses_grupos as $ses_index => $ses_grupo ) {
				$ses_areas_items[] = array(
					'title'        => $ses_grupo['title'],
					'url'          => $ses_grupo['url'],
					'icon'         => $ses_grupo['icon'],
					'sub_areas'    => wp_list_pluck( $ses_grupo['links'], 'label' ),
					'reveal_delay' => $ses_index,
				);
			}
			get_template_part(
				'template-parts/components/card-grid',
				null,
				array(
					'items'      => $ses_areas_items,
					'card_type'  => 'practice-area',
					'grid_class' => 'areas-grid',
				)
			);
			?>
		</section>

		<section class="<?php echo esc_attr( ses_section_class( 'crema' ) . ' firma' ); ?>">
			<div class="firma-grid">
				<div class="firma-img stock-photo-wrap reveal">
					<img class="stock-photo" src="https://picsum.photos/seed/ses-oficina/900/720" alt="<?php esc_attr_e( 'Sala de reuniones institucional (fotografía de stock, temporal)', 'ses-abogados' ); ?>" loading="lazy">
				</div>
				<div class="reveal">
					<div class="eyebrow"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></div>
					<h2 class="firma-title"><?php esc_html_e( 'Rigor técnico, discreción y una visión de largo plazo para cada cliente.', 'ses-abogados' ); ?></h2>
					<p class="firma-text"><?php esc_html_e( 'SES Abogados —Sierra Elles & Salgado Abogados S.A.S.— es una firma que combina experiencia técnica con visión estratégica institucional. Desde Cartagena y con cobertura en todo el territorio colombiano, acompañamos a empresas privadas, constructoras, promotores inmobiliarios, entidades públicas y personas naturales en procesos jurídicos que exigen precisión, criterio y solidez.', 'ses-abogados' ); ?></p>
					<?php get_template_part( 'template-parts/components/button', null, array( 'label' => __( 'Conocer la firma', 'ses-abogados' ), 'href' => home_url( '/quienes-somos/#firma' ), 'variant' => 'text' ) ); ?>
				</div>
			</div>
		</section>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) . ' equipo' ); ?>">
			<div class="equipo-head reveal">
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></div>
					<h2><?php esc_html_e( 'Socios fundadores', 'ses-abogados' ); ?></h2>
				</div>
				<?php get_template_part( 'template-parts/components/button', null, array( 'label' => __( 'Ver equipo completo', 'ses-abogados' ), 'href' => home_url( '/quienes-somos/#equipo' ), 'variant' => 'text' ) ); ?>
			</div>
			<?php
			get_template_part(
				'template-parts/components/card-grid',
				null,
				array(
					'items'      => ses_get_equipo_socios( 'compact' ),
					'card_type'  => 'team',
					'grid_class' => 'equipo-grid',
				)
			);
			?>
		</section>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) . ' actualidad' ); ?>">
			<div class="actualidad-head reveal">
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></div>
					<h2><?php esc_html_e( 'Análisis y perspectivas', 'ses-abogados' ); ?></h2>
				</div>
				<?php get_template_part( 'template-parts/components/button', null, array( 'label' => __( 'Ver todos los artículos', 'ses-abogados' ), 'href' => home_url( '/actualidad-juridica/' ), 'variant' => 'text' ) ); ?>
			</div>
			<?php
			$ses_articulos_items = array();
			foreach ( $ses_articulos_recientes as $ses_index => $ses_articulo ) {
				$ses_articulos_items[] = array_merge( $ses_articulo, array( 'reveal_delay' => $ses_index ) );
			}
			get_template_part(
				'template-parts/components/card-grid',
				null,
				array(
					'items'      => $ses_articulos_items,
					'card_type'  => 'article',
					'grid_class' => 'actualidad-grid',
				)
			);
			?>
		</section>

		<?php
		// Testimonios: no imprime nada si el CPT ses_testimonio todavía no
		// tiene entradas publicadas (testimonios-section.php).
		get_template_part( 'template-parts/components/testimonios-section' );

		get_template_part(
			'template-parts/components/cta-section',
			null,
			array(
				'title'       => __( 'Hablemos de su próximo paso jurídico', 'ses-abogados' ),
				'description' => __( 'Escríbanos y un miembro del equipo se pondrá en contacto a la brevedad.', 'ses-abogados' ),
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
