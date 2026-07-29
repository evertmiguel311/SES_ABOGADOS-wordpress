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

	/**
	 * Accordion — navegación móvil del Mega Menú (docs/componentes.md,
	 * DA-004). No reutiliza openPanel/closePanel: esas dos están pensadas
	 * para paneles superpuestos que se ocultan con `hidden` tras un
	 * retraso (CLOSE_ANIMATION_MS) mientras se desvanecen con
	 * opacity/transform. El Accordion anima `grid-template-rows`
	 * (docs/design_system.md §11.2), así que el panel permanece siempre
	 * en el flujo — no usa `hidden` — y en su lugar alterna `inert` para
	 * que sus enlaces no sean alcanzables por teclado/lector de pantalla
	 * mientras está colapsado.
	 */
	function setupAccordion( accordionEl ) {
		if ( ! accordionEl ) return;

		var allowMultiple = accordionEl.getAttribute( 'data-allow-multiple' ) === 'true';
		var triggers = Array.prototype.slice.call( accordionEl.querySelectorAll( '.accordion-trigger' ) );

		function setItemState( trigger, expand ) {
			var panel = document.getElementById( trigger.getAttribute( 'aria-controls' ) );
			if ( ! panel ) return;

			trigger.setAttribute( 'aria-expanded', expand ? 'true' : 'false' );
			panel.classList.toggle( 'is-open', expand );

			if ( expand ) {
				panel.removeAttribute( 'inert' );
			} else {
				panel.setAttribute( 'inert', '' );
			}
		}

		triggers.forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function () {
				var isExpanded = trigger.getAttribute( 'aria-expanded' ) === 'true';

				if ( ! allowMultiple && ! isExpanded ) {
					triggers.forEach( function ( other ) {
						if ( other !== trigger ) setItemState( other, false );
					} );
				}

				setItemState( trigger, ! isExpanded );
			} );
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

		// Accordion (representación móvil del Mega Menú dentro del off-canvas)
		document.querySelectorAll( '.accordion' ).forEach( setupAccordion );

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

		// Carrusel de Testimonios: scroll nativo con snap; los botones/puntos
		// son una capa de conveniencia sobre el scroll táctil, que sigue
		// funcionando aunque JS no cargue (progressive enhancement).
		var testimoniosTrack = document.querySelector( '.testimonios-track' );
		if ( testimoniosTrack ) {
			var testimonioCards = Array.prototype.slice.call( testimoniosTrack.querySelectorAll( '.testimonio-card' ) );
			var dotsWrap = document.querySelector( '.testimonios-dots' );
			var dots = [];

			testimonioCards.forEach( function ( card, i ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'testimonio-dot';
				dot.setAttribute( 'aria-label', 'Ir al testimonio ' + ( i + 1 ) );
				dot.addEventListener( 'click', function () {
					card.scrollIntoView( { behavior: prefersReducedMotion ? 'auto' : 'smooth', block: 'nearest', inline: 'start' } );
				} );
				dotsWrap.appendChild( dot );
				dots.push( dot );
			} );

			function scrollByOneCard( direction ) {
				var card = testimonioCards[ 0 ];
				var gap = 24;
				var amount = ( card.getBoundingClientRect().width + gap ) * direction;
				testimoniosTrack.scrollBy( { left: amount, behavior: prefersReducedMotion ? 'auto' : 'smooth' } );
			}

			var prevBtn = document.querySelector( '.testimonio-prev' );
			var nextBtn = document.querySelector( '.testimonio-next' );
			if ( prevBtn ) prevBtn.addEventListener( 'click', function () { scrollByOneCard( -1 ); } );
			if ( nextBtn ) nextBtn.addEventListener( 'click', function () { scrollByOneCard( 1 ); } );

			if ( 'IntersectionObserver' in window ) {
				var dotsObserver = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						var index = testimonioCards.indexOf( entry.target );
						if ( index === -1 ) return;
						dots[ index ].classList.toggle( 'is-active', entry.isIntersecting );
					} );
				}, { root: testimoniosTrack, threshold: 0.6 } );
				testimonioCards.forEach( function ( card ) { dotsObserver.observe( card ); } );
			} else if ( dots[ 0 ] ) {
				dots[ 0 ].classList.add( 'is-active' );
			}
		}
	} );
} )();
