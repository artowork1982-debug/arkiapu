<?php
/**
 * Moderni Teal - functions.php
 *
 * @package Moderni_Teal
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Teeman asetukset
 */
function moderni_teal_setup() {
    // Käännöstuki
    load_theme_textdomain( 'moderni-teal', get_template_directory() . '/languages' );

    // RSS-syöte
    add_theme_support( 'automatic-feed-links' );

    // Dynaamiset otsikot
    add_theme_support( 'title-tag' );

    // Artikkelikuvat
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'card-thumbnail', 600, 400, true );
    add_image_size( 'hero-image', 1200, 600, true );

    // Navigaatiovalikot
    register_nav_menus( array(
        'primary'  => esc_html__( 'Päävalikko', 'moderni-teal' ),
        'footer'   => esc_html__( 'Alatunnisteen valikko', 'moderni-teal' ),
    ) );

    // HTML5-tuki
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Mukautettu logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Mukautettu tausta
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Responsiiviset embedit
    add_theme_support( 'responsive-embeds' );

    // Sisältöleveys
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'moderni_teal_setup' );

/**
 * Sivupalkin widget-alueet
 */
function moderni_teal_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sivupalkki', 'moderni-teal' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Lisää widgettejä tähän sivupalkkiin.', 'moderni-teal' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Alatunniste 1', 'moderni-teal' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Alatunnisteen ensimmäinen widget-alue.', 'moderni-teal' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Alatunniste 2', 'moderni-teal' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Alatunnisteen toinen widget-alue.', 'moderni-teal' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Alatunniste 3', 'moderni-teal' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Alatunnisteen kolmas widget-alue.', 'moderni-teal' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'moderni_teal_widgets_init' );

/**
 * Tyylitiedostot ja skriptit
 */
function moderni_teal_scripts() {
    // Google Fonts - Inter
    wp_enqueue_style(
        'moderni-teal-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Teeman päätyyli
    wp_enqueue_style(
        'moderni-teal-style',
        get_stylesheet_uri(),
        array( 'moderni-teal-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Navigaatio-JS
    wp_enqueue_script(
        'moderni-teal-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Kommenttien vastausskripti
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'moderni_teal_scripts' );

/**
 * Lisää preconnect Google Fontsille
 */
function moderni_teal_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => '',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'moderni_teal_resource_hints', 10, 2 );

/**
 * Mukautettu otteen pituus
 */
function moderni_teal_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'moderni_teal_excerpt_length' );

/**
 * Mukautettu otteen "lue lisää" -teksti
 */
function moderni_teal_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'moderni_teal_excerpt_more' );

/**
 * Artikkelin julkaisupäivämäärä
 */
function moderni_teal_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );
    echo '<span class="posted-on">' . $time_string . '</span>';
}

/**
 * Artikkelin kirjoittaja
 */
function moderni_teal_posted_by() {
    echo '<span class="byline">' . esc_html( get_the_author() ) . '</span>';
}

/**
 * Lisää body-luokkia
 */
function moderni_teal_body_classes( $classes ) {
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }
    if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter( 'body_class', 'moderni_teal_body_classes' );