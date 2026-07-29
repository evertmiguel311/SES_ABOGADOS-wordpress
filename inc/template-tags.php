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

/**
 * Fuente única del dato de contacto breve (ciudad, correo) que hoy
 * aparece en la franja de aviso del header y en la columna "Contacto"
 * del footer (header.php, footer-content.php) — antes eran dos strings
 * hardcodeadas por separado, contradiciendo CLAUDE.md §14 ("un solo
 * lugar para cada dato").
 *
 * Hardcodeado a propósito, mismo patrón que ses_get_grupos_practica():
 * la Options Page ACF "Datos de contacto" (ses-opciones-contacto) ya
 * está registrada (inc/acf-options.php) pero sus campos se definen
 * recién al construir Contacto (Sprint 8, docs/wordpress.md §6) — esta
 * función es el único lugar que cambia ese día, sin tocar header.php ni
 * footer-content.php.
 */
function ses_get_contact_data() {
	return array(
		'city'  => __( 'Cartagena, Colombia', 'ses-abogados' ),
		'email' => 'sierraellesabogados@gmail.com',
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
 *
 * `excerpt` (Sprint 5) es el mismo texto ya aprobado en el prototipo
 * (prototipo/areas-de-practica.html .grupo-landing-card) para la landing
 * de Áreas de Práctica — se agrega aquí en vez de un segundo array en
 * page-areas-de-practica.php para no duplicar título/URL/ícono de nuevo.
 *
 * `links[]['full_title']`/`['description']` (Sprint 6.1) son el título
 * completo y la descripción ya aprobados de cada sub-especialidad —
 * texto exacto de las 4 páginas de grupo del prototipo
 * (prototipo/areas-de-practica/{grupo}.html .subarea-card), distinto de
 * `label` (la etiqueta corta que ya usa el Mega Menú, mega-menu.php solo
 * lee `anchor`/`label`, así que agregar estos dos campos no le afecta).
 * Es el fallback que consume page-grupo-practica.php cuando el
 * repetidor ACF `sub_especialidades` (acf-json/group_ses_grupo_practica.json)
 * todavía no tiene esa fila configurada — mismo criterio de todo Sprint 6:
 * el sitio nunca queda incompleto por falta de configuración inicial.
 */
function ses_get_grupos_practica() {
	$areas_base = home_url( '/areas-de-practica' );

	return array(
		array(
			'title'   => __( 'Derecho Público y Corporativo', 'ses-abogados' ),
			'short'   => __( 'Público y Corporativo', 'ses-abogados' ),
			'url'     => $areas_base . '/derecho-publico-y-corporativo/',
			'icon'    => '<rect x="7" y="10" width="26" height="22" stroke="currentColor" stroke-width="1.2"/><path d="M7 16H33" stroke="currentColor" stroke-width="1.2"/><path d="M13 10V6H27V10" stroke="currentColor" stroke-width="1.2"/>',
			'excerpt' => __( 'Procesos administrativos y disciplinarios, estructuración societaria y contratos mercantiles, y planeación tributaria, aduanera y de comercio exterior.', 'ses-abogados' ),
			'links'   => array(
				array(
					'label'       => __( 'Administrativo y Disciplinario', 'ses-abogados' ),
					'anchor'      => 'administrativo',
					'full_title'  => __( 'Derecho Administrativo y Disciplinario', 'ses-abogados' ),
					'description' => __( 'Acompañamiento en procesos ante entidades públicas, actos administrativos, régimen disciplinario y regulación sectorial.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Corporativo y Mercantil', 'ses-abogados' ),
					'anchor'      => 'corporativo-mercantil',
					'full_title'  => __( 'Derecho Corporativo y Mercantil', 'ses-abogados' ),
					'description' => __( 'Constitución de sociedades, gobierno corporativo, contratos mercantiles, fusiones y adquisiciones.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Tributario y Comercio Exterior', 'ses-abogados' ),
					'anchor'      => 'tributario',
					'full_title'  => __( 'Derecho Tributario, Aduanas y Comercio Exterior', 'ses-abogados' ),
					'description' => __( 'Planeación tributaria, procesos aduaneros y asesoría en operaciones de comercio exterior.', 'ses-abogados' ),
				),
			),
		),
		array(
			'title'   => __( 'Derecho Inmobiliario, Urbano y Rural', 'ses-abogados' ),
			'short'   => __( 'Inmobiliario, Urbano y Rural', 'ses-abogados' ),
			'url'     => $areas_base . '/derecho-inmobiliario-urbano-y-rural/',
			'icon'    => '<path d="M7 34V16L20 7L33 16V34H7Z" stroke="currentColor" stroke-width="1.2"/><path d="M16 34V23H24V34" stroke="currentColor" stroke-width="1.2"/>',
			'excerpt' => __( 'Consultoría en ordenamiento territorial y desarrollo urbano, estudio de títulos y saneamiento jurídico de inmuebles, y titulación de bienes baldíos y procesos policivos.', 'ses-abogados' ),
			'links'   => array(
				array(
					'label'       => __( 'Ordenamiento Territorial', 'ses-abogados' ),
					'anchor'      => 'ordenamiento-territorial',
					'full_title'  => __( 'Ordenamiento Territorial y Desarrollo Urbano', 'ses-abogados' ),
					'description' => __( 'Consultoría en licencias urbanísticas, planes parciales y asesoría a constructoras y desarrolladores.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Títulos y Saneamiento', 'ses-abogados' ),
					'anchor'      => 'titulos-saneamiento',
					'full_title'  => __( 'Estudio de Títulos y Saneamiento Jurídico', 'ses-abogados' ),
					'description' => __( 'Estudios de títulos, saneamiento y estructuración de operaciones inmobiliarias.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Baldíos y Procesos Policivos', 'ses-abogados' ),
					'anchor'      => 'baldios-policivos',
					'full_title'  => __( 'Titulación de Bienes Baldíos y Procesos Policivos', 'ses-abogados' ),
					'description' => __( 'Adquisición, formalización y gestión de predios rurales y procesos policivos de restitución.', 'ses-abogados' ),
				),
			),
		),
		array(
			'title'   => __( 'Derecho Privado, Laboral y de Familia', 'ses-abogados' ),
			'short'   => __( 'Privado, Laboral y Familia', 'ses-abogados' ),
			'url'     => $areas_base . '/derecho-privado-laboral-y-de-familia/',
			'icon'    => '<circle cx="14" cy="13" r="5" stroke="currentColor" stroke-width="1.2"/><circle cx="27" cy="13" r="5" stroke="currentColor" stroke-width="1.2"/><path d="M5 33C5 26 9 22 14 22C19 22 23 26 23 33" stroke="currentColor" stroke-width="1.2"/><path d="M20 33C20 26 24 22 29 22C31.5 22 33.7 23 35 25" stroke="currentColor" stroke-width="1.2"/>',
			'excerpt' => __( 'Responsabilidad civil y procesos civiles, derecho laboral y de la seguridad social, y derecho de familia y seguros.', 'ses-abogados' ),
			'links'   => array(
				array(
					'label'       => __( 'Civil, Procesal y de Daños', 'ses-abogados' ),
					'anchor'      => 'civil',
					'full_title'  => __( 'Derecho Civil, Procesal y de Daños', 'ses-abogados' ),
					'description' => __( 'Responsabilidad civil, procesos civiles y representación en controversias contractuales y extracontractuales.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Laboral y Seguridad Social', 'ses-abogados' ),
					'anchor'      => 'laboral',
					'full_title'  => __( 'Derecho Laboral y de la Seguridad Social', 'ses-abogados' ),
					'description' => __( 'Contratación, procesos disciplinarios y litigio laboral individual y colectivo.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Familia y Seguros', 'ses-abogados' ),
					'anchor'      => 'familia-seguros',
					'full_title'  => __( 'Derecho de Familia y Seguros', 'ses-abogados' ),
					'description' => __( 'Uniones maritales, divorcios, custodia, régimen patrimonial y asesoría en materia de seguros.', 'ses-abogados' ),
				),
			),
		),
		array(
			'title'   => __( 'Especialidades Complementarias y Litigio', 'ses-abogados' ),
			'short'   => __( 'Complementarias y Litigio', 'ses-abogados' ),
			'url'     => $areas_base . '/especialidades-complementarias-y-litigio/',
			'icon'    => '<rect x="9" y="6" width="22" height="28" stroke="currentColor" stroke-width="1.2"/><path d="M14 14H26" stroke="currentColor" stroke-width="1.2"/><path d="M14 20H26" stroke="currentColor" stroke-width="1.2"/><path d="M14 26H21" stroke="currentColor" stroke-width="1.2"/>',
			'excerpt' => __( 'Litigio y arbitramento nacional e internacional, recuperación de cartera, derecho penal, derecho migratorio, y derecho constitucional y de derechos humanos.', 'ses-abogados' ),
			'links'   => array(
				array(
					'label'       => __( 'Litigio y Arbitramento', 'ses-abogados' ),
					'anchor'      => 'litigio-arbitramento',
					'full_title'  => __( 'Litigio y Arbitramento (Nacional e Internacional) y Recuperación de Cartera', 'ses-abogados' ),
					'description' => __( 'Representación en procesos judiciales, arbitrajes nacionales e internacionales, y gestión de cobro y recuperación de cartera.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Derecho Penal', 'ses-abogados' ),
					'anchor'      => 'penal',
					'full_title'  => __( 'Derecho Penal', 'ses-abogados' ),
					'description' => __( 'Defensa y representación en procesos penales, tanto de personas naturales como de empresas.', 'ses-abogados' ),
				),
				array(
					'label'       => __( 'Migratorio y Constitucional', 'ses-abogados' ),
					'anchor'      => 'migratorio-constitucional',
					'full_title'  => __( 'Derecho Migratorio, Constitucional y Derechos Humanos', 'ses-abogados' ),
					'description' => __( 'Asesoría en procesos migratorios, acciones constitucionales y protección de derechos humanos.', 'ses-abogados' ),
				),
			),
		),
	);
}

/**
 * Busca un grupo de ses_get_grupos_practica() por el slug final de su URL
 * (ej. "derecho-publico-y-corporativo") — usado por page-grupo-practica.php
 * para saber cuál de los 4 grupos representa la página actual, sin
 * necesitar un campo ACF adicional que duplique lo que la URL ya dice
 * (docs/wordpress.md §11, slugs ya fijados 1:1 con estructura_web.md).
 *
 * @param string $slug Slug de la página actual.
 * @return array|null
 */
function ses_get_grupo_practica_por_slug( $slug ) {
	foreach ( ses_get_grupos_practica() as $ses_grupo ) {
		if ( untrailingslashit( wp_basename( $ses_grupo['url'] ) ) === $slug ) {
			return $ses_grupo;
		}
	}
	return null;
}

/**
 * Socios fundadores para Nuestro Equipo (Home y Quiénes Somos) —
 * Sprint 6, docs/wordpress.md §1.1/§3: WP_Query real sobre el CPT
 * `ses_team_member`, ordenado por el campo ACF `orden`.
 *
 * Si todavía no existe ninguna entrada publicada (sitio recién
 * desplegado, antes de que un Administrador cargue el equipo real en
 * wp-admin) o si ACF no está activo, se usa el mismo contenido ya
 * aprobado del prototipo como respaldo — mismo criterio que
 * ses_get_grupos_practica(): nunca una sección vacía o rota mientras el
 * contenido real todavía no se ha cargado (CLAUDE.md §14).
 *
 * @param string $variant 'compact' (Home) | 'full' (Quiénes Somos) — se
 *                        reenvía tal cual a team-card.php.
 * @return array Array de $args listos para card-grid.php + team-card.php.
 */
function ses_get_equipo_socios( $variant = 'compact' ) {
	$ses_query = new WP_Query(
		array(
			'post_type'      => 'ses_team_member',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => 'orden',
			'orderby'        => 'meta_value_num title',
			'order'          => 'ASC',
		)
	);

	if ( ! $ses_query->have_posts() ) {
		// Respaldo: perfiles reales de docs/equipo.md, mismo texto del
		// prototipo aprobado (SES_ABOGADOS-sitio/prototipo/index.html,
		// quienes-somos.html) mientras no exista contenido real en el CPT.
		$ses_fallback = array(
			array(
				'name'           => 'Dr. Borys José Sierra Tamara',
				'role'           => __( 'Director Jurídico y Socio Fundador', 'ses-abogados' ),
				'specialization' => __( 'Derecho Administrativo', 'ses-abogados' ),
				'bio'            => __( 'Especialista en Derecho Administrativo con más de 15 años de trayectoria en dirección jurídica y asesoría técnico-legal para el sector público y empresarial. Ha liderado oficinas jurídicas en entidades como CORVIVIENDA y la Unidad Administrativa Especial Migración Colombia, con enfoque en seguridad jurídica y blindaje normativo frente al Estado. En el sector privado, fue Asesor Jurídico General de Lácteos de la Sabana y Depósito de Tambores el Éxito S.A.S.', 'ses-abogados' ),
				'photo_url'      => SES_THEME_URI . '/assets/images/borys-sierra.png',
			),
			array(
				'name'           => 'Dr. Adolfo Antonio Elles Domínguez',
				'role'           => __( 'Socio Fundador', 'ses-abogados' ),
				'specialization' => __( 'Derecho Laboral y Seguridad Social', 'ses-abogados' ),
				'bio'            => __( 'Especialista en Derecho Laboral y Seguridad Social con más de dos décadas de experiencia en consultoría laboral, corporativa y control de gestión pública. Ha sido Asesor Jurídico y Contralor General (e) del Departamento de Sucre, con trayectoria destacada en derecho público y régimen disciplinario, y acompañamiento a METRO SABANAS S.A.S. y la Oficina de Alumbrado Público de Sincelejo.', 'ses-abogados' ),
				'photo_url'      => '',
			),
		);

		$ses_items = array();
		foreach ( $ses_fallback as $ses_index => $ses_socio ) {
			$ses_items[] = array_merge(
				$ses_socio,
				array(
					'variant'      => $variant,
					'reveal_delay' => $ses_index,
				)
			);
		}
		return $ses_items;
	}

	$ses_items = array();
	$ses_index = 0;
	while ( $ses_query->have_posts() ) {
		$ses_query->the_post();
		$ses_id = get_the_ID();
		$ses_items[] = array(
			'name'           => get_the_title( $ses_id ),
			'role'           => function_exists( 'get_field' ) ? (string) get_field( 'cargo', $ses_id ) : '',
			'specialization' => function_exists( 'get_field' ) ? (string) get_field( 'especializacion', $ses_id ) : '',
			'bio'            => function_exists( 'get_field' ) ? (string) get_field( 'bio_breve', $ses_id ) : '',
			'photo_url'      => get_the_post_thumbnail_url( $ses_id, 'ses-team-card' ),
			'variant'        => $variant,
			'reveal_delay'   => $ses_index,
		);
		++$ses_index;
	}
	wp_reset_postdata();

	return $ses_items;
}

/**
 * Cifras institucionales del Hero de Inicio (Stat Tile) —
 * docs/wordpress.md §3/§6, Options Page "Cifras institucionales".
 *
 * `mostrar_cifras` apagado explícitamente oculta la franja completa
 * (CLAUDE.md §15, no publicar cifras no confirmadas). Mientras el campo no
 * se haya tocado o ACF no esté activo, se muestran las mismas cifras
 * sugeridas ya aprobadas en el prototipo — no una sección vacía.
 *
 * @return array Array de $args para stat-tile.php (posiblemente vacío).
 */
function ses_get_cifras_institucionales() {
	$ses_fallback = array(
		array( 'value' => '4', 'label' => __( 'Grupos de práctica', 'ses-abogados' ), 'animate_count' => true, 'count_to' => '4' ),
		array( 'value' => '12', 'label' => __( 'Sub-especialidades', 'ses-abogados' ), 'animate_count' => true, 'count_to' => '12' ),
		array( 'value' => __( 'Nacional', 'ses-abogados' ), 'label' => __( 'Cobertura en Colombia', 'ses-abogados' ) ),
		array( 'value' => '35+', 'label' => __( 'Años de experiencia combinada', 'ses-abogados' ), 'animate_count' => true, 'count_to' => '35', 'suffix' => '+', 'suggested' => true ),
		array( 'value' => __( 'Público y Privado', 'ses-abogados' ), 'label' => __( 'Sectores atendidos', 'ses-abogados' ), 'suggested' => true ),
	);

	if ( ! function_exists( 'get_field' ) ) {
		return $ses_fallback;
	}

	$ses_mostrar = get_field( 'mostrar_cifras', 'option' );
	if ( false === $ses_mostrar ) {
		// Decisión explícita del administrador: ocultar la franja completa.
		return array();
	}

	$ses_cifras = get_field( 'cifras', 'option' );
	if ( ! $ses_cifras || ! is_array( $ses_cifras ) ) {
		return $ses_fallback;
	}

	$ses_items = array();
	foreach ( $ses_cifras as $ses_cifra ) {
		$ses_valor = isset( $ses_cifra['valor'] ) ? trim( (string) $ses_cifra['valor'] ) : '';
		$ses_etiqueta = isset( $ses_cifra['etiqueta'] ) ? trim( (string) $ses_cifra['etiqueta'] ) : '';
		if ( '' === $ses_valor || '' === $ses_etiqueta ) {
			continue;
		}
		$ses_item = array( 'value' => $ses_valor, 'label' => $ses_etiqueta );
		if ( is_numeric( $ses_valor ) ) {
			$ses_item['animate_count'] = true;
			$ses_item['count_to']      = $ses_valor;
		}
		$ses_items[] = $ses_item;
	}
	return $ses_items;
}

/**
 * Combina el Hero editable por ACF ("Hero de página", solo portada —
 * docs/wordpress.md §3) con el contenido ya aprobado del prototipo como
 * respaldo campo por campo. Un campo ACF vacío no borra el contenido
 * aprobado, solo lo reemplaza si el administrador lo llenó.
 *
 * @param array $ses_fallback $args completos de hero.php ya resueltos
 *                            (Sprint 5) para la página que llama.
 * @return array $args final para template-parts/components/hero.php.
 */
function ses_get_hero_args( array $ses_fallback ) {
	if ( ! function_exists( 'get_field' ) || ! is_front_page() ) {
		return $ses_fallback;
	}

	$ses_map = array(
		'eyebrow'  => 'eyebrow',
		'title'    => 'titulo',
		'subtitle' => 'subtitulo',
	);
	foreach ( $ses_map as $ses_arg_key => $ses_field_name ) {
		$ses_value = trim( (string) get_field( $ses_field_name ) );
		if ( '' !== $ses_value ) {
			$ses_fallback[ $ses_arg_key ] = $ses_value;
		}
	}

	$ses_imagen = get_field( 'imagen_fondo' );
	if ( $ses_imagen ) {
		$ses_fallback['image_url'] = $ses_imagen;
	}

	$ses_cta_primario_label = trim( (string) get_field( 'cta_primario_label' ) );
	$ses_cta_primario_url   = trim( (string) get_field( 'cta_primario_url' ) );
	if ( '' !== $ses_cta_primario_label && '' !== $ses_cta_primario_url ) {
		$ses_fallback['cta_primary'] = array( 'label' => $ses_cta_primario_label, 'url' => $ses_cta_primario_url );
	}

	$ses_cta_secundario_label = trim( (string) get_field( 'cta_secundario_label' ) );
	$ses_cta_secundario_url   = trim( (string) get_field( 'cta_secundario_url' ) );
	if ( '' !== $ses_cta_secundario_label && '' !== $ses_cta_secundario_url ) {
		$ses_fallback['cta_secondary'] = array( 'label' => $ses_cta_secundario_label, 'url' => $ses_cta_secundario_url );
	}

	return $ses_fallback;
}

/**
 * Tiempo estimado de lectura ("5 min de lectura") a partir del conteo de
 * palabras de la entrada — ~200 palabras/minuto, redondeado hacia arriba,
 * mínimo 1 minuto. Reutilizado por archive.php y single.php (repetición
 * real entre dos plantillas, criterio de Sprint 6 para crear un helper).
 *
 * @param int $post_id
 * @return string
 */
function ses_get_reading_time( $post_id ) {
	$ses_word_count = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	$ses_minutes    = max( 1, (int) ceil( $ses_word_count / 200 ) );
	/* translators: %d: minutos de lectura estimados. */
	return sprintf( _n( '%d min de lectura', '%d min de lectura', $ses_minutes, 'ses-abogados' ), $ses_minutes );
}
