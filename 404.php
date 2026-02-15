<?php
/**
 * 404-virhe -sivutemplate
 *
 * @package Moderni_Teal
 */

get_header();
?>

<main id="primary" class="site-content" role="main">
    <div class="container">
        <section class="error-404">

            <div class="error-404__code">404</div>

            <h1><?php esc_html_e( 'Sivua ei löytynyt', 'moderni-teal' ); ?></h1>

            <p style="max-width: 500px; margin: var(--spacing-md) auto var(--spacing-xl); color: var(--color-text-light);">
                <?php esc_html_e( 'Etsimääsi sivua ei valitettavasti löytynyt. Se on saatettu poistaa, siirtää tai nimeä on muutettu.', 'moderni-teal' ); ?>
            </p>

            <?php get_search_form(); ?>

            <div style="margin-top: var(--spacing-2xl);">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">
                    <?php esc_html_e( '&larr; Palaa etusivulle', 'moderni-teal' ); ?>
                </a>
            </div>

        </section>
    </div>
</main>

<?php
get_footer();