
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
                <?php esc_html_e( 'Kaikki oikeudet pidätetään.', 'moderni-teal' ); ?>
            </p>
        </div><!-- .footer-bottom -->

    </div><!-- .container -->
</footer><!-- .site-footer -->

<?php wp_footer(); ?>

</body>
</html>
