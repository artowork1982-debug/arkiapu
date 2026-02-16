/**
 * Moderni Teal - Mobiilinavigaatio & Header Shrink
 *
 * @package Moderni_Teal
 */
(function () {
    'use strict';

    /* =============================================
       Constants
       ============================================= */
    // Time to wait for menu animation before moving focus (matches CSS animation timing)
    const MENU_OPEN_FOCUS_DELAY = 100;
    // Submenu animation duration (should match CSS max-height transition)
    const SUBMENU_ANIMATION_DURATION = 400;

    /* =============================================
       Mobiilinavigaatio
       ============================================= */
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-navigation');
    const body = document.body;

    if (toggle && nav) {
        // Focus trap elements
        const focusableElements = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
        let firstFocusableElement;
        let lastFocusableElement;

        // Update focusable elements list
        function updateFocusableElements() {
            const focusableContent = nav.querySelectorAll(focusableElements);
            const visibleFocusable = Array.from(focusableContent).filter(el => {
                return el.offsetWidth > 0 || el.offsetHeight > 0 || el === document.activeElement;
            });
            firstFocusableElement = visibleFocusable[0];
            lastFocusableElement = visibleFocusable[visibleFocusable.length - 1];
        }

        // Open menu function
        function openMenu() {
            nav.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            body.style.overflow = 'hidden';

            // Add staggered animation to menu items
            setTimeout(() => {
                updateFocusableElements();
                if (firstFocusableElement) {
                    firstFocusableElement.focus();
                }
            }, MENU_OPEN_FOCUS_DELAY);
        }

        // Close menu function
        function closeMenu() {
            nav.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';

            // Close all open submenus
            const openSubmenus = nav.querySelectorAll('.menu-item-has-children.submenu-open');
            openSubmenus.forEach(item => {
                item.classList.remove('submenu-open');
            });

            // Return focus to toggle button
            toggle.focus();
        }

        // Hampurilaisvalikon toggle
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = nav.getAttribute('aria-hidden') === 'false';

            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Focus trap
        nav.addEventListener('keydown', function (e) {
            if (nav.getAttribute('aria-hidden') === 'false') {
                const isTabPressed = e.key === 'Tab';

                if (!isTabPressed) return;

                if (e.shiftKey) { // Shift + Tab
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else { // Tab
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });

        // Sulje valikko kun klikataan linkkiä (mobiili)
        nav.querySelectorAll('#primary-menu > li > a').forEach(function (link) {
            link.addEventListener('click', function (e) {
                // Don't close if it's a parent menu item with children
                const parentLi = link.closest('li');
                if (parentLi.classList.contains('menu-item-has-children')) {
                    return;
                }

                if (window.innerWidth < 768) {
                    closeMenu();
                }
            });
        });

        // Submenu links should close the menu
        nav.querySelectorAll('.sub-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    closeMenu();
                }
            });
        });

        // Accordion toggle for submenus on mobile
        const menuItemsWithChildren = nav.querySelectorAll('.menu-item-has-children');

        menuItemsWithChildren.forEach(function (item) {
            const link = item.querySelector('> a');

            if (link) {
                link.addEventListener('click', function (e) {
                    if (window.innerWidth < 768) {
                        e.preventDefault();

                        // Toggle this submenu
                        item.classList.toggle('submenu-open');

                        // Update focusable elements after opening submenu
                        if (item.classList.contains('submenu-open')) {
                            setTimeout(updateFocusableElements, SUBMENU_ANIMATION_DURATION);
                        }
                    }
                });
            }
        });

        // Sulje valikko Escape-näppäimellä
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.getAttribute('aria-hidden') === 'false') {
                closeMenu();
            }
        });

        // Sulje valikko kun klikataan ulkopuolelle (overlay)
        nav.addEventListener('click', function (e) {
            if (e.target === nav || e.target.classList.contains('mobile-menu-overlay')) {
                if (nav.getAttribute('aria-hidden') === 'false') {
                    closeMenu();
                }
            }
        });

        // Prevent clicks on menu content from closing
        const menuContent = nav.querySelector('.mobile-menu-content');
        if (menuContent) {
            menuContent.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }

        // Reagoi ikkunan koon muutoksiin
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 768) {
                    // Close mobile menu and reset body overflow
                    if (nav.getAttribute('aria-hidden') === 'false') {
                        nav.setAttribute('aria-hidden', 'true');
                        toggle.setAttribute('aria-expanded', 'false');
                        body.style.overflow = '';
                    }

                    // Close all submenus
                    const openSubmenus = nav.querySelectorAll('.menu-item-has-children.submenu-open');
                    openSubmenus.forEach(item => {
                        item.classList.remove('submenu-open');
                    });
                }
            }, 150);
        });
    }

    /* =============================================
       Header Shrink skrollatessa
       ============================================= */
    const header = document.querySelector('.site-header');
    const topbar = document.querySelector('.site-topbar');
    const SCROLL_THRESHOLD_DOWN = 60;
    const SCROLL_THRESHOLD_UP = 20;

    if (header) {
        let ticking = false;
        let lastScrollY = 0;
        let scrollDirection = 'down';

        function onScroll() {
            const currentScrollY = window.scrollY;
            const isScrolled = header.classList.contains('scrolled');
            
            // Determine scroll direction
            if (currentScrollY > lastScrollY) {
                scrollDirection = 'down';
            } else if (currentScrollY < lastScrollY) {
                scrollDirection = 'up';
            }
            lastScrollY = currentScrollY;

            // Add/remove scrolled class with hysteresis logic
            if (!isScrolled && currentScrollY > SCROLL_THRESHOLD_DOWN && scrollDirection === 'down') {
                header.classList.add('scrolled');
                if (topbar) topbar.classList.add('topbar-hidden');
            } else if (isScrolled && currentScrollY < SCROLL_THRESHOLD_UP && scrollDirection === 'up') {
                header.classList.remove('scrolled');
                if (topbar) topbar.classList.remove('topbar-hidden');
            }

            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(onScroll);
                ticking = true;
            }
        }, { passive: true });

        onScroll();
    }
})();