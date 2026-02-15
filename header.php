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

<header class="site-header" role="banner">
    <div class="container">

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
                    <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) :
                    ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div><!-- .site-branding -->
        </div><!-- .header-top -->

        <!-- Alaosa: Navigaatio -->
        <div class="header-bottom">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Avaa valikko', 'moderni-teal' ); ?>">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Päävalikko', 'moderni-teal' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav><!-- #site-navigation -->
        </div><!-- .header-bottom -->

    </div><!-- .container -->
</header><!-- .site-header -->