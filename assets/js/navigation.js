/**
 * Moderni Teal - Mobiilinavigaatio & Header Shrink
 *
 * @package Moderni_Teal
 */
(function () {
    'use strict';

    /* =============================================
       Mobiilinavigaatio
       ============================================= */
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-navigation');

    if (toggle && nav) {
        // Hampurilaisvalikon toggle
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = nav.classList.toggle('toggled');
            toggle.setAttribute('aria-expanded', isOpen);
        });

        // Sulje valikko kun klikataan linkkiä (mobiili)
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    nav.classList.remove('toggled');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });

        // Sulje valikko Escape-näppäimellä
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('toggled')) {
                nav.classList.remove('toggled');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        });

        // Sulje valikko kun klikataan ulkopuolelle
        document.addEventListener('click', function (e) {
            if (
                nav.classList.contains('toggled') &&
                !nav.contains(e.target) &&
                !toggle.contains(e.target)
            ) {
                nav.classList.remove('toggled');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Reagoi ikkunan koon muutoksiin
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 768) {
                    nav.classList.remove('toggled');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            }, 150);
        });
    }

    /* =============================================
       Header Shrink skrollatessa
       ============================================= */
    const header = document.querySelector('.site-header');
    const threshold = 60; // pikselimäärä, jolloin shrink aktivoituu

    if (header) {
        let ticking = false;

        function onScroll() {
            if (window.scrollY > threshold) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(onScroll);
                ticking = true;
            }
        }, { passive: true });

        // Tarkista heti ladattaessa (esim. sivu ladataan keskeltä)
        onScroll();
    }
})();