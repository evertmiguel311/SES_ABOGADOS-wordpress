<?php
/**
 * Helpers pequeños y transversales usados por más de una plantilla.
 *
 * Cualquier función que solo use una plantilla vive junto a esa
 * plantilla (o a su template-part), no aquí — evita que este archivo
 * crezca sin control (CLAUDE.md §5, no sobre-ingeniería).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Copyright del footer con la razón social completa exigida por el
 * cliente (docs/estructura_web.md §Footer, "usar la razón social
 * completa, no 'SES Abogados'") y el año actual dinámico.
 */
function ses_get_copyright_text() {
	return sprintf(
		/* translators: %d: año actual. */
		esc_html__( '© %d SIERRA ELLES & SALGADO ABOGADOS S.A.S. Todos los derechos reservados.', 'ses-abogados' ),
		(int) current_time( 'Y' )
	);
}

/**
 * Fuente única de los 4 grupos de práctica (título, título corto, URL,
 * ícono y sub-especialidades), consumida por mega-menu.php y
 * footer-content.php.
 *
 * `title` es el nombre completo (mega menú); `short` es la variante
 * abreviada que usa el footer en el diseño aprobado (prototipo/index.html
 * — p.ej. "Público y Corporativo" en vez de "Derecho Público y
 * Corporativo", para cada columna del footer no se vuelva demasiado
 * ancha/alta). Mismo dato, dos formatos de un mismo campo, no dos copias
 * independientes que se puedan desincronizar.
 *
 * Hardcodeado a propósito (puente temporal hasta Sprint 6, cuando estos
 * datos vengan de las 4 páginas de grupo + ACF `sub_especialidades` —
 * docs/wordpress.md §4). Antes vivía duplicado en dos arrays distintos
 * (uno por template-part); ahora es un solo lugar que editar si cambia
 * una etiqueta o URL antes de que exista la versión dinámica.
 */
/**
 * Container — docs/biblioteca_componentes.md §1.
 *
 * Container/Section envuelven contenido arbitrario que get_template_part
 * no puede recibir como "hijo" (no hay slots/children en PHP clásico) —
 * por eso viven como helpers de clase, no como archivo con markup; el
 * llamador sigue escribiendo su propio <div>/<section> y solo pide aquí
 * el nombre de clase correcto. Evita repetir "container-wide" a mano y
 * un futuro tercer ancho solo se cambia aquí.
 *
 * @param bool $wide true → docs/design_system.md ancho ampliado (1440px).
 */
function ses_container_class( $wide = false ) {
	return $wide ? 'container-wide' : 'container';
}

/**
 * Section — docs/biblioteca_componentes.md §1.
 *
 * `background = 'grafito'` (fondo oscuro genérico) queda sin implementar:
 * hoy todo fondo oscuro del sitio es Hero o Footer, ambos componentes
 * bespoke con su propio forzado de color — ningún contenido real necesita
 * todavía una Section oscura genérica. Se agrega cuando exista ese caso
 * de uso real, no antes (CLAUDE.md §5, no sobre-ingeniería).
 *
 * @param string $background 'white' (default) | 'crema' | 'niebla'.
 */
function ses_section_class( $background = 'white' ) {
	$map = array(
		'white'  => 'section',
		'crema'  => 'section-alt',
		'niebla' => 'section-niebla',
	);
	return isset( $map[ $background ] ) ? $map[ $background ] : $map['white'];
}

function ses_get_grupos_practica() {
	$areas_base = home_url( '/areas-de-practica' );

	return array(
		array(
			'title' => __( 'Derecho Público y Corporativo', 'ses-abogados' ),
			'short' => __( 'Público y Corporativo', 'ses-abogados' ),
			'url'   => $areas_base . '/derecho-publico-y-corporativo/',
			'icon'  => '<rect x="7" y="10" width="26" height="22" stroke="currentColor" stroke-width="1.2"/><path d="M7 16H33" stroke="currentColor" stroke-width="1.2"/><path d="M13 10V6H27V10" stroke="currentColor" stroke-width="1.2"/>',
			'links' => array(
				array( 'label' => __( 'Administrativo y Disciplinario', 'ses-abogados' ), 'anchor' => 'administrativo' ),
				array( 'label' => __( 'Corporativo y Mercantil', 'ses-abogados' ), 'anchor' => 'corporativo-mercantil' ),
				array( 'label' => __( 'Tributario y Comercio Exterior', 'ses-abogados' ), 'anchor' => 'tributario' ),
			),
		),
		array(
			'title' => __( 'Derecho Inmobiliario, Urbano y Rural', 'ses-abogados' ),
			'short' => __( 'Inmobiliario, Urbano y Rural', 'ses-abogados' ),
			'url'   => $areas_base . '/derecho-inmobiliario-urbano-y-rural/',
			'icon'  => '<path d="M7 34V16L20 7L33 16V34H7Z" stroke="currentColor" stroke-width="1.2"/><path d="M16 34V23H24V34" stroke="currentColor" stroke-width="1.2"/>',
			'links' => array(
				array( 'label' => __( 'Ordenamiento Territorial', 'ses-abogados' ), 'anchor' => 'ordenamiento-territorial' ),
				array( 'label' => __( 'Títulos y Saneamiento', 'ses-abogados' ), 'anchor' => 'titulos-saneamiento' ),
				array( 'label' => __( 'Baldíos y Procesos Policivos', 'ses-abogados' ), 'anchor' => 'baldios-policivos' ),
			),
		),
		array(
			'title' => __( 'Derecho Privado, Laboral y de Familia', 'ses-abogados' ),
			'short' => __( 'Privado, Laboral y Familia', 'ses-abogados' ),
			'url'   => $areas_base . '/derecho-privado-laboral-y-de-familia/',
			'icon'  => '<circle cx="14" cy="13" r="5" stroke="currentColor" stroke-width="1.2"/><circle cx="27" cy="13" r="5" stroke="currentColor" stroke-width="1.2"/><path d="M5 33C5 26 9 22 14 22C19 22 23 26 23 33" stroke="currentColor" stroke-width="1.2"/><path d="M20 33C20 26 24 22 29 22C31.5 22 33.7 23 35 25" stroke="currentColor" stroke-width="1.2"/>',
			'links' => array(
				array( 'label' => __( 'Civil, Procesal y de Daños', 'ses-abogados' ), 'anchor' => 'civil' ),
				array( 'label' => __( 'Laboral y Seguridad Social', 'ses-abogados' ), 'anchor' => 'laboral' ),
				array( 'label' => __( 'Familia y Seguros', 'ses-abogados' ), 'anchor' => 'familia-seguros' ),
			),
		),
		array(
			'title' => __( 'Especialidades Complementarias y Litigio', 'ses-abogados' ),
			'short' => __( 'Complementarias y Litigio', 'ses-abogados' ),
			'url'   => $areas_base . '/especialidades-complementarias-y-litigio/',
			'icon'  => '<rect x="9" y="6" width="22" height="28" stroke="currentColor" stroke-width="1.2"/><path d="M14 14H26" stroke="currentColor" stroke-width="1.2"/><path d="M14 20H26" stroke="currentColor" stroke-width="1.2"/><path d="M14 26H21" stroke="currentColor" stroke-width="1.2"/>',
			'links' => array(
				array( 'label' => __( 'Litigio y Arbitramento', 'ses-abogados' ), 'anchor' => 'litigio-arbitramento' ),
				array( 'label' => __( 'Derecho Penal', 'ses-abogados' ), 'anchor' => 'penal' ),
				array( 'label' => __( 'Migratorio y Constitucional', 'ses-abogados' ), 'anchor' => 'migratorio-constitucional' ),
			),
		),
	);
}
