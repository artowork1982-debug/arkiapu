
<?php
/**
 * Teeman footer
 *
 * @package Moderni_Teal
 */
?>

<footer class="site-footer" role="contentinfo">
    <div class="container">

        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
        <div class="footer-widgets">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
            <?php endif; ?>
        </div><!-- .footer-widgets -->
        <?php endif; ?>

        <div class="footer-bottom">
            <p>
                &copy; <?php echo wp_date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( '', 'moderni-teal' ); ?>
            </p>
        </div><!-- .footer-bottom -->

    </div><!-- .container -->
</footer><!-- .site-footer -->

<!-- Mobiili: Kiinteä alanavigaatio -->
<div class="mobile-bottom-bar">
    <a href="tel:+358401234567" class="mobile-bottom-bar__btn mobile-bottom-bar__btn--call">
        <img src="https://titanarkiapu.fi/wp-content/uploads/2026/02/mobile-icon.svg" alt="" width="28" height="28" class="mobile-bottom-bar__icon">
        <span>Soita</span>
    </a>
    <a href="#" class="mobile-bottom-bar__btn mobile-bottom-bar__btn--message" id="open-contact-modal">
        <img src="https://titanarkiapu.fi/wp-content/uploads/2026/02/email-ikoni.svg" alt="" width="28" height="28" class="mobile-bottom-bar__icon">
        <span>Viesti</span>
    </a>
</div>

<!-- Ota yhteyttä -modal -->
<div class="contact-modal" id="contact-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Ota yhteyttä">
    <div class="contact-modal__overlay" id="contact-modal-overlay"></div>
    <div class="contact-modal__content">
        <button class="contact-modal__close" id="close-contact-modal" aria-label="Sulje">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <h2 class="contact-modal__title">Ota yhteyttä</h2>
        <p class="contact-modal__desc">Täytä lomake ja palaamme sinulle mahdollisimman pian.</p>
        <form class="contact-modal__form" id="contact-modal-form">
            <div class="contact-modal__field">
                <label for="contact-name">Nimi *</label>
                <input type="text" id="contact-name" name="name" required placeholder="Nimesi">
            </div>
            <div class="contact-modal__field">
                <label for="contact-email">Sähköposti *</label>
                <input type="email" id="contact-email" name="email" required placeholder="sahkoposti@esimerkki.fi">
            </div>
            <div class="contact-modal__field">
                <label for="contact-phone">Puhelin</label>
                <input type="tel" id="contact-phone" name="phone" placeholder="+358 40 123 4567">
            </div>
            <div class="contact-modal__field">
                <label for="contact-message">Viesti *</label>
                <textarea id="contact-message" name="message" rows="4" required placeholder="Kerro, miten voimme auttaa..."></textarea>
            </div>
            <button type="submit" class="contact-modal__submit">Lähetä viesti</button>
        </form>
        <div class="contact-modal__success" id="contact-modal-success" style="display: none;">
            <div class="contact-modal__success-icon">✓</div>
            <h3>Kiitos viestistäsi!</h3>
            <p>Palaamme sinulle mahdollisimman pian.</p>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
