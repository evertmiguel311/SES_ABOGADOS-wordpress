<?php
/**
 * Configuración base del tema: soporte de features nativas, ubicaciones
 * de menú y tamaños de imagen.
 *
 * La paleta/tipografía/espaciado del tema se definen en theme.json (WP
 * 5.8+), no vía add_theme_support( 'editor-color-palette' ) clásico —
 * evita mantener los mismos tokens en dos sitios (CLAUDE.md §5, no
 * hardcodear fuera de las variables de marca).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Soporte de tema y carga de textdomain.
 *
 * La internacionalización queda preparada (textdomain cargado) aunque
 * esta fase sea 100% español — ver CLAUDE.md §3, nota de i18n futura.
 */
function ses_setup() {
	load_theme_textdomain( 'ses-abogados', SES_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	/*
	 * El editor de bloques debe verse igual que el front-end: theme.json
	 * solo declara `settings` (paleta/tipografía cerradas), nunca `styles`,
	 * así que sin esto Gutenberg mostraría tipografía/colores por defecto
	 * en vez de los de marca mientras el cliente edita contenido.
	 */
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/style.css' );

	/*
	 * Ubicaciones de menú (docs/wordpress.md §4) — el contenido de cada
	 * uno se asigna desde el panel de WordPress, no en código. El Mega
	 * Menu de Áreas de Práctica NO se arma desde ningún menú de este
	 * registro: se genera a partir de las 4 páginas de grupo y su campo
	 * ACF `sub_especialidades` (docs/wordpress.md §4, nota Mega Menu).
	 */
	register_nav_menus(
		array(
			'menu-principal'    => __( 'Menú principal', 'ses-abogados' ),
			'menu-footer-nav'   => __( 'Footer — Navegación', 'ses-abogados' ),
			'menu-footer-areas' => __( 'Footer — Áreas de práctica', 'ses-abogados' ),
			'menu-legal'        => __( 'Footer — Legal', 'ses-abogados' ),
		)
	);
}
add_action( 'after_setup_theme', 'ses_setup' );

/**
 * Tamaños de imagen propios, uno por componente que los necesita
 * (docs/biblioteca_componentes.md — Team Card, Article Card, Hero de
 * artículo). No se crean tamaños "por si acaso": cada uno tiene un
 * consumidor documentado.
 */
function ses_image_sizes() {
	add_image_size( 'ses-team-card', 480, 640, true );     // Team Card, 3:4.
	add_image_size( 'ses-article-card', 700, 525, true );  // Article Card, 4:3.
	add_image_size( 'ses-article-hero', 1200, 600, true ); // Hero de artículo, 16:8.
}
add_action( 'after_setup_theme', 'ses_image_sizes' );

/**
 * Ancho por defecto de contenido embebido (oEmbed, alineación "wide") —
 * coincide con el contenedor de 1280px del diseño aprobado.
 */
function ses_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ses_content_width', 1280 );
}
add_action( 'after_setup_theme', 'ses_content_width', 0 );

/**
 * Aviso solo en Apariencia > Menús: las 4 ubicaciones registradas arriba
 * todavía no las consume ningún `wp_nav_menu()` — el header y el footer
 * están hardcodeados 1:1 al diseño aprobado (template-parts/components/
 * navbar.php y footer-content.php) porque el walker por defecto envuelve
 * cada ítem en <li>, algo que el diseño no tiene. Sin este aviso, alguien
 * podría asignar un menú aquí y no ver ningún cambio en el sitio, sin
 * saber por qué — se retira solo cuando exista un Walker propio
 * (Sprint 6+, docs/wordpress.md §4).
 */
function ses_nav_menus_admin_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'nav-menus' !== $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-info">
		<p>
			<?php
			esc_html_e(
				'Las ubicaciones de menú de este tema todavía no se reflejan en el sitio: la navegación (encabezado y pie de página) está fijada al diseño aprobado por el cliente. Asignar un menú aquí no cambiará lo que ven los visitantes por ahora.',
				'ses-abogados'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'ses_nav_menus_admin_notice' );
