/**
 * Moderni Teal - Sulavat sivuvaihtotransitiot
 *
 * Fade-in sivun latautuessa + fade-out linkkejä klikattaessa
 *
 * @package Moderni_Teal
 */
(function () {
    'use strict';

    // Käynnistä fade-in kun DOM on valmis
    document.addEventListener('DOMContentLoaded', function () {
        // Pieni viive jotta CSS transition ehtii käynnistyä
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                document.body.classList.add('page-loaded');
            });
        });
    });

    // Fallback: jos DOMContentLoaded on jo tapahtunut
    if (document.readyState !== 'loading') {
        requestAnimationFrame(function () {
            document.body.classList.add('page-loaded');
        });
    }

    // Fade-out kun klikataan sisäistä linkkiä
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');

        // Ohita jos ei ole linkki
        if (!link) return;

        // Ohita ulkoiset linkit, ankkurilinkit, uudet välilehdet, erityiset linkit
        if (
            link.hostname !== window.location.hostname ||
            link.getAttribute('href').startsWith('#') ||
            link.getAttribute('href').startsWith('tel:') ||
            link.getAttribute('href').startsWith('mailto:') ||
            link.target === '_blank' ||
            e.ctrlKey || e.metaKey || e.shiftKey ||
            link.hasAttribute('download') ||
            link.closest('.mobile-menu-overlay') // Mobiilivalikon linkit käsitellään erikseen
        ) {
            return;
        }

        // Estä default ja käynnistä fade-out
        e.preventDefault();
        const href = link.href;

        document.body.classList.remove('page-loaded');
        document.body.classList.add('page-leaving');

        // Odota animaation valmistuminen ennen siirtymää
        setTimeout(function () {
            window.location.href = href;
        }, 300); // Sama kesto kuin CSS:n page-leaving transition
    });

    // Käsittele selaimen back/forward-painikkeet
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            // Sivu tulee bfcache:sta — näytä heti
            document.body.classList.remove('page-leaving');
            document.body.classList.add('page-loaded');
        }
    });
})();