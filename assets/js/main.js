/**
 * SES Abogados — JS del tema.
 *
 * Copia funcional del JS del prototipo aprobado por el cliente
 * (SES_ABOGADOS-sitio/prototipo/js/main.js): toggle de dropdown/mega-menú
 * (click + hover en desktop, con retraso de cierre para poder cruzar el
 * espacio entre disparador y panel), menú móvil, sombra del header
 * sticky al hacer scroll, contador ascendente de cifras y animaciones de
 * entrada al hacer scroll (docs/design_system.md §11 Motion). Vanilla JS,
 * sin frameworks (CLAUDE.md §4/§5).
 */

( function () {
	'use strict';

	var DESKTOP_MIN_WIDTH = 1024;
	var CLOSE_ANIMATION_MS = 260;

	function isDesktop() {
		return window.innerWidth >= DESKTOP_MIN_WIDTH;
	}

	function openPanel( panelEl ) {
		panelEl.hidden = false;
		requestAnimationFrame( function () {
			panelEl.classList.add( 'is-open' );
		} );
	}

	function closePanel( panelEl ) {
		panelEl.classList.remove( 'is-open' );
		window.setTimeout( function () {
			panelEl.hidden = true;
		}, CLOSE_ANIMATION_MS );
	}

	/**
	 * Menú tipo "abrir/cerrar" reutilizable para el dropdown y el
	 * mega-menú: click/teclado siempre funcionan; en desktop además se
	 * abre con hover (mouseenter/mouseleave) para no obligar a hacer
	 * click en un sitio institucional.
	 */
	function setupToggleMenu( triggerEl, panelEl, wrapEl ) {
		if ( ! triggerEl || ! panelEl ) return;

		var closeTimer = null;

		function cancelScheduledClose() {
			if ( closeTimer ) {
				window.clearTimeout( closeTimer );
				closeTimer = null;
			}
		}

		function open() {
			cancelScheduledClose();
			openPanel( panelEl );
			triggerEl.setAttribute( 'aria-expanded', 'true' );
		}
		function close() {
			cancelScheduledClose();
			closePanel( panelEl );
			triggerEl.setAttribute( 'aria-expanded', 'false' );
		}
		function toggle() {
			if ( panelEl.hidden ) open(); else close();
		}

		triggerEl.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			toggle();
		} );

		if ( wrapEl ) {
			// Hay una separación visual (gap) entre el disparador y el
			// panel; sin este retraso, cruzar ese espacio con el mouse
			// cierra el panel antes de poder llegar a los enlaces. El
			// retraso se cancela si el cursor vuelve a entrar a tiempo.
			wrapEl.addEventListener( 'mouseenter', function () {
				if ( isDesktop() ) open();
			} );
			wrapEl.addEventListener( 'mouseleave', function () {
				if ( ! isDesktop() ) return;
				cancelScheduledClose();
				closeTimer = window.setTimeout( function () {
					close();
				}, 300 );
			} );
		}

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && ! panelEl.hidden ) {
				close();
				triggerEl.focus();
			}
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( ! panelEl.hidden && wrapEl && ! wrapEl.contains( e.target ) ) {
				close();
			}
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		// Dropdown "Quiénes Somos"
		setupToggleMenu(
			document.querySelector( '.dropdown-trigger' ),
			document.getElementById( 'quienes-somos-panel' ),
			document.querySelector( '.dropdown' )
		);

		// Mega menú "Áreas de Práctica"
		setupToggleMenu(
			document.querySelector( '.mega-trigger' ),
			document.getElementById( 'areas-mega-menu' ),
			document.querySelector( '.mega-menu-wrap' )
		);

		// Menú móvil (hamburguesa)
		var mobileToggle = document.querySelector( '.mobile-menu-toggle' );
		var mobileMenu = document.getElementById( 'mobile-menu' );

		if ( mobileToggle && mobileMenu ) {
			function closeMobileMenu() {
				closePanel( mobileMenu );
				mobileToggle.setAttribute( 'aria-expanded', 'false' );
				mobileToggle.setAttribute( 'aria-label', mobileToggle.getAttribute( 'data-label-open' ) || 'Abrir menú de navegación' );
				mobileToggle.classList.remove( 'is-active' );
			}
			function openMobileMenu() {
				openPanel( mobileMenu );
				mobileToggle.setAttribute( 'aria-expanded', 'true' );
				mobileToggle.setAttribute( 'aria-label', mobileToggle.getAttribute( 'data-label-close' ) || 'Cerrar menú de navegación' );
				mobileToggle.classList.add( 'is-active' );
			}

			mobileToggle.addEventListener( 'click', function () {
				if ( mobileMenu.hidden ) openMobileMenu(); else closeMobileMenu();
			} );

			mobileMenu.querySelectorAll( 'a' ).forEach( function ( link ) {
				link.addEventListener( 'click', closeMobileMenu );
			} );

			document.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' && ! mobileMenu.hidden ) {
					closeMobileMenu();
					mobileToggle.focus();
				}
			} );

			window.addEventListener( 'resize', function () {
				if ( isDesktop() && ! mobileMenu.hidden ) closeMobileMenu();
			} );
		}

		// Sombra del header sticky al hacer scroll
		var headerWrap = document.querySelector( '.header-sticky-wrap' );
		if ( headerWrap ) {
			function onScroll() {
				headerWrap.classList.toggle( 'is-scrolled', window.scrollY > 4 );
			}
			onScroll();
			window.addEventListener( 'scroll', onScroll, { passive: true } );
		}

		var prefersReducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		// Contador ascendente para cifras (data-count-to="12" data-suffix="+").
		// El texto inicial en el HTML ya es el valor final: si JS no
		// corre, el número correcto queda visible igual (progressive
		// enhancement).
		function animateCount( el ) {
			var target = parseFloat( el.getAttribute( 'data-count-to' ) );
			var suffix = el.getAttribute( 'data-suffix' ) || '';
			if ( isNaN( target ) || prefersReducedMotion ) return;

			var duration = 900;
			var startTime = null;

			function step( timestamp ) {
				if ( startTime === null ) startTime = timestamp;
				var progress = Math.min( ( timestamp - startTime ) / duration, 1 );
				var eased = 1 - Math.pow( 1 - progress, 3 );
				el.textContent = Math.round( eased * target ) + suffix;
				if ( progress < 1 ) {
					window.requestAnimationFrame( step );
				} else {
					el.textContent = target + suffix;
				}
			}

			el.textContent = '0' + suffix;
			window.requestAnimationFrame( step );
		}

		// Animaciones de entrada al hacer scroll (fade + slide sutil)
		var revealEls = document.querySelectorAll( '.reveal' );
		if ( revealEls.length ) {
			if ( 'IntersectionObserver' in window ) {
				var observer = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							entry.target.classList.add( 'is-visible' );
							entry.target.querySelectorAll( '[data-count-to]' ).forEach( animateCount );
							observer.unobserve( entry.target );
						}
					} );
				}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' } );

				revealEls.forEach( function ( el ) { observer.observe( el ); } );
			} else {
				revealEls.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
			}
		}
	} );
} )();
