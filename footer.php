<?php
/**
 * Footer completo y cierre del documento.
 *
 * Implementa 1:1 el diseño aprobado por el cliente en el prototipo
 * estático (SES_ABOGADOS-sitio/prototipo/index.html): footer de 4
 * columnas + barra inferior con copyright y enlaces legales
 * (template-parts/components/footer-content.php) — docs/roadmap.md
 * Sprint 4 ("Footer de 4 columnas con copyright confirmado").
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'template-parts/components/footer-content' );
?>

<?php wp_footer(); ?>
</body>
</html>
