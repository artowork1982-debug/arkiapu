<?php
/**
 * Teeman header
 *
 * @package Moderni_Teal
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#primary">
    <?php esc_html_e( 'Siirry sisältöön', 'moderni-teal' ); ?>
</a>

<?php
$description = get_bloginfo( 'description', 'display' );
if ( $description || is_customize_preview() ) :
?>
<div class="site-topbar">

    <div class="container">
        <p class="site-topbar__tagline"><?php echo esc_html( $description ); ?></p>
    </div>
</div>
<?php endif; ?>

<header class="site-header" role="banner">
    <div class="container">
        <!-- Mobiilivalikon nappi oikeaan yläkulmaan -->
        <div class="mobile-menu">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Avaa valikko', 'moderni-teal' ); ?>">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        <!-- Yläosa: Logo keskitettynä -->
        <div class="header-top">
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="custom-logo-wrapper">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div><!-- .site-branding -->
        </div><!-- .header-top -->

        <!-- Alaosa: Navigaatio -->
        <div class="header-bottom">
            <!-- Desktop CTA - Soita painike oikeassa reunassa -->
            <a href="tel:+358401234567" class="header-cta-call" aria-label="Soita meille">
                <img src="https://titanarkiapu.fi/wp-content/uploads/2026/02/mobile-icon.svg" alt="" width="22" height="22" class="header-cta-call__icon">
                <span class="header-cta-call__text">Soita meille</span>
            </a>
        </div><!-- .header-bottom -->

        <!-- Navigaatio erillään, jotta mobiilivalikko toimii -->
        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Päävalikko', 'moderni-teal' ); ?>" aria-hidden="true">
            <div class="mobile-menu-overlay">
                <div class="mobile-menu-content">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                    
                    <!-- Yhteystiedot mobiilivalikossa -->
                    <div class="mobile-menu-contact">
                        <h3><?php esc_html_e( 'Ota yhteyttä', 'moderni-teal' ); ?></h3>
                        <p class="contact-phone">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:+358401837383">040 183 7383</a>
                        </p>
                        <p class="contact-email">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <a href="mailto:info@titanarkiapu.fi">info@titanarkiapu.fi</a>
                        </p>
                    </div>
                    
                    <!-- Sosiaalisen median ikonit -->
                    <!-- TODO: Replace '#' placeholders with actual social media URLs or implement WordPress customizer options -->

                </div>
            </div>
        </nav><!-- #site-navigation -->

    </div><!-- .container -->
</header><!-- .site-header -->