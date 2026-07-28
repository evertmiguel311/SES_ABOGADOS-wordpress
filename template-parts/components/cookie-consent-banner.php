<?php
/**
 * Cookie / Privacy Consent Banner — docs/biblioteca_componentes.md §9.
 *
 * Responsabilidad: obtener consentimiento antes de cargar scripts de
 * terceros (GA4, Microsoft Clarity) — cumplimiento de la Ley 1581 de
 * 2012 (CLAUDE.md §8). Los scripts de Analytics/Clarity no deben
 * encolarse en `wp_head` incondicionalmente (docs/wordpress.md §9).
 *
 * Pendiente de implementación (Sprint 9, docs/roadmap.md — Optimización:
 * SEO, accesibilidad, analítica, Cloudflare).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
