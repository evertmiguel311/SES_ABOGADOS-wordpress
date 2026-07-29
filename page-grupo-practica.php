<?php
/**
 * Template Name: Grupo de Práctica
 *
 * `/areas-de-practica/{grupo}` (×4) — Sprint 6, docs/roadmap.md.
 * Corregida en Sprint 6.1 (auditoría Sprint 5+6, hallazgo P1).
 *
 * Una sola plantilla para las 4 páginas de grupo, asignada manualmente
 * por un Administrador al crear cada página (docs/wordpress.md §10 —
 * "evita 4 archivos casi idénticos"). Identidad fija del grupo (título,
 * URL, ícono, sub-especialidades con su ancla, título completo y
 * descripción aprobada) viene de ses_get_grupos_practica() — misma
 * fuente que el Mega Menú, sin duplicar.
 *
 * Fuente de verdad del contenido de cada sub-especialidad (Sprint 6.1):
 * 1) Si el repetidor ACF `sub_especialidades`
 *    (acf-json/group_ses_grupo_practica.json) tiene una fila con el
 *    mismo `ancla_id`, su `descripcion` gana.
 * 2) Si no, se usa `links[]['description']` de
 *    ses_get_grupos_practica() (inc/template-tags.php) — el texto ya
 *    aprobado en el prototipo (prototipo/areas-de-practica/{grupo}.html
 *    .subarea-card) — para que la página nunca quede incompleta solo
 *    porque un Administrador todavía no llenó el ACF (CLAUDE.md §14).
 * El título de cada sub-especialidad (`full_title`) no es editable por
 * ACF a propósito (acf-json/group_ses_grupo_practica.json no tiene un
 * subcampo "título" — evita una segunda fuente del mismo dato que el
 * Mega Menú/`label` ya fijan).
 *
 * Markup y clases reutilizadas 1:1 del prototipo aprobado
 * (`.subarea-grid`/`.subarea-card`, ya presentes en assets/css/style.css
 * desde antes de este sprint) — sin estilos inline ni CSS nuevo.
 *
 * Antes de Sprint 6, los anclas del Mega Menú/Accordion móvil
 * (#administrativo, etc.) apuntaban a una ruta sin página real — esta
 * plantilla resuelve esa brecha.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ses_slug  = get_post_field( 'post_name' );
$ses_grupo = ses_get_grupo_practica_por_slug( $ses_slug );

if ( ! $ses_grupo ) {
	/*
	 * Página creada con esta plantilla pero con un slug que no coincide con
	 * ninguno de los 4 grupos conocidos (error de configuración del
	 * Administrador, no un caso de uso esperado) — se avisa en vez de
	 * imprimir una página en blanco o con datos incorrectos.
	 */
	?>
	<main id="main" class="site-main">
		<section class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<div class="<?php echo esc_attr( ses_container_class() ); ?>">
				<p><?php esc_html_e( 'Esta página usa la plantilla "Grupo de Práctica", pero su slug no coincide con ninguno de los 4 grupos definidos en ses_get_grupos_practica(). Verifique que el slug de la página sea exactamente el de uno de los 4 grupos de Áreas de Práctica.', 'ses-abogados' ); ?></p>
			</div>
		</section>
	</main>
	<?php
	get_footer();
	return;
}

$ses_descripcion_grupo = function_exists( 'get_field' ) ? trim( (string) get_field( 'descripcion_grupo' ) ) : '';
if ( '' === $ses_descripcion_grupo ) {
	$ses_descripcion_grupo = $ses_grupo['excerpt'];
}

// El título de cada sub-especialidad no es editable por ACF (evita una
// segunda fuente del mismo dato que ya fija el Mega Menú/`label`); solo
// la descripción tiene fallback ACF → prototipo aprobado.

// Índice de descripciones ACF por ancla, para no depender del orden de
// las filas del repetidor (docs Sprint 6 — evitar acoplar contenido a
// posición).
$ses_descripciones_sub = array();
if ( function_exists( 'get_field' ) ) {
	$ses_repetidor = get_field( 'sub_especialidades' );
	if ( is_array( $ses_repetidor ) ) {
		foreach ( $ses_repetidor as $ses_fila ) {
			$ses_ancla = isset( $ses_fila['ancla_id'] ) ? trim( (string) $ses_fila['ancla_id'] ) : '';
			if ( '' !== $ses_ancla ) {
				$ses_descripciones_sub[ $ses_ancla ] = trim( (string) $ses_fila['descripcion'] );
			}
		}
	}
}
?>

	<main id="main" class="site-main">
		<?php
		get_template_part(
			'template-parts/components/breadcrumb',
			null,
			array(
				'trail' => array(
					array( 'label' => __( 'Inicio', 'ses-abogados' ), 'url' => home_url( '/' ) ),
					array( 'label' => __( 'Áreas de Práctica', 'ses-abogados' ), 'url' => home_url( '/areas-de-practica/' ) ),
					array( 'label' => $ses_grupo['title'] ),
				),
				'wrapper_class' => 'breadcrumb-groups',
			)
		);

		get_template_part(
			'template-parts/components/hero',
			null,
			array(
				'variant'  => 'interior',
				'eyebrow'  => __( 'Áreas de Práctica', 'ses-abogados' ),
				'title'    => $ses_grupo['title'],
				'subtitle' => $ses_descripcion_grupo,
			)
		);
		?>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<div class="subarea-grid">
				<?php foreach ( $ses_grupo['links'] as $ses_link ) : ?>
					<?php
					$ses_descripcion_sub = ! empty( $ses_descripciones_sub[ $ses_link['anchor'] ] )
						? $ses_descripciones_sub[ $ses_link['anchor'] ]
						: $ses_link['description'];
					?>
					<div id="<?php echo esc_attr( $ses_link['anchor'] ); ?>" class="subarea-card">
						<h3><?php echo esc_html( $ses_link['full_title'] ); ?></h3>
						<p><?php echo esc_html( $ses_descripcion_sub ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<?php
		get_template_part(
			'template-parts/components/cta-section',
			null,
			array(
				'title'       => __( '¿No está seguro de qué área necesita?', 'ses-abogados' ),
				'description' => __( 'Cuéntenos su caso y lo dirigimos al grupo de práctica adecuado.', 'ses-abogados' ),
				'cta_primary' => array(
					'label' => __( 'Contáctenos', 'ses-abogados' ),
					'url'   => home_url( '/contacto/' ),
				),
			)
		);
		?>
	</main>

<?php
get_footer();
