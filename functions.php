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

    // Mukautettu logo (pystylogo)
    add_theme_support( 'custom-logo', array(
        'height'      => 300,
        'width'       => 200,
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
    // Teeman päätyyli
    wp_enqueue_style(
        'moderni-teal-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // Sivuvaihto-transitiot
    wp_enqueue_script(
        'moderni-teal-page-transitions',
        get_template_directory_uri() . '/assets/js/page-transitions.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        false // Ladataan <head>:issa jotta ei tule FOUC:ia
    );

    // Navigaatio-JS
    wp_enqueue_script(
        'moderni-teal-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Ota yhteyttä -modal
    wp_enqueue_script(
        'moderni-teal-contact-modal',
        get_template_directory_uri() . '/assets/js/contact-modal.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );
    
    // Lisää AJAX URL ja nonce JavaScriptille
    wp_localize_script( 'moderni-teal-contact-modal', 'moderniTealContact', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'moderni_teal_contact' ),
    ) );

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
 * Artikkelin julkaisupäivämäärä ja päivitysaika
 */
function moderni_teal_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        $time_string .= ' <span class="updated-on">' . esc_html__( '(päivitetty ', 'moderni-teal' ) . '<time class="updated" datetime="%3$s">%4$s</time>)</span>';
    }
    
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
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

/**
 * Suorituskykyoptimoinnit - Poista emoji-skriptit
 */
function moderni_teal_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'moderni_teal_disable_emojis_tinymce' );
}
add_action( 'init', 'moderni_teal_disable_emojis' );

function moderni_teal_disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }
    return array();
}

/**
 * Poista WordPress-versio ja muut turhat metatiedot
 */
function moderni_teal_remove_version() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'moderni_teal_remove_version' );

/**
 * Non-render-blocking fonttien lataus
 */
function moderni_teal_optimize_google_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    </noscript>
    <?php
}
add_action( 'wp_head', 'moderni_teal_optimize_google_fonts', 1 );

/**
 * Lisää fetchpriority="high" hero-kuville
 */
function moderni_teal_add_fetchpriority( $attr, $attachment, $size ) {
    if ( is_singular() && has_post_thumbnail() && get_post_thumbnail_id() === $attachment->ID ) {
        $attr['fetchpriority'] = 'high';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'moderni_teal_add_fetchpriority', 10, 3 );

/**
 * Lazy loading ja async decoding kuville
 */
function moderni_teal_lazy_loading( $attr, $attachment, $size ) {
    if ( ! isset( $attr['fetchpriority'] ) || $attr['fetchpriority'] !== 'high' ) {
        $attr['loading'] = 'lazy';
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'moderni_teal_lazy_loading', 10, 3 );

/**
 * Breadcrumb-navigaatio
 */
function moderni_teal_breadcrumbs() {
    // Älä näytä etusivulla
    if ( is_front_page() ) {
        return;
    }
    
    $home_text = esc_html__( 'Etusivu', 'moderni-teal' );
    $separator = '<span class="separator"> &raquo; </span>';
    
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'moderni-teal' ) . '">';
    echo '<div class="container">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . $home_text . '</a>';
    
    if ( is_category() || is_single() ) {
        echo $separator;
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $category = $categories[0];
            if ( $category->parent ) {
                $parent_cats = array();
                $parent_id = $category->parent;
                while ( $parent_id ) {
                    $parent_cat = get_category( $parent_id );
                    $parent_cats[] = '<a href="' . esc_url( get_category_link( $parent_id ) ) . '">' . esc_html( $parent_cat->name ) . '</a>';
                    $parent_id = $parent_cat->parent;
                }
                $parent_cats = array_reverse( $parent_cats );
                echo implode( $separator, $parent_cats ) . $separator;
            }
            if ( is_single() ) {
                echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                echo $separator;
                echo '<span>' . get_the_title() . '</span>';
            } else {
                echo '<span>' . esc_html( $category->name ) . '</span>';
            }
        }
    } elseif ( is_page() ) {
        if ( wp_get_post_parent_id( get_the_ID() ) ) {
            $parent_pages = array();
            $parent_id = wp_get_post_parent_id( get_the_ID() );
            while ( $parent_id ) {
                $parent_pages[] = '<a href="' . esc_url( get_permalink( $parent_id ) ) . '">' . get_the_title( $parent_id ) . '</a>';
                $parent_id = wp_get_post_parent_id( $parent_id );
            }
            $parent_pages = array_reverse( $parent_pages );
            echo $separator . implode( $separator, $parent_pages );
        }
        echo $separator . '<span>' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        echo $separator . '<span>' . sprintf( esc_html__( 'Hakutulokset: "%s"', 'moderni-teal' ), get_search_query() ) . '</span>';
    } elseif ( is_tag() ) {
        echo $separator . '<span>' . esc_html__( 'Avainsana: ', 'moderni-teal' ) . single_tag_title( '', false ) . '</span>';
    } elseif ( is_author() ) {
        echo $separator . '<span>' . esc_html__( 'Kirjoittaja: ', 'moderni-teal' ) . get_the_author() . '</span>';
    } elseif ( is_archive() ) {
        echo $separator . '<span>' . get_the_archive_title() . '</span>';
    } elseif ( is_404() ) {
        echo $separator . '<span>' . esc_html__( 'Sivua ei löytynyt', 'moderni-teal' ) . '</span>';
    }
    
    echo '</div>';
    echo '</nav>';
}

/**
 * SEO: Canonical URL
 */
function moderni_teal_canonical_url() {
    // Älä lisää, jos SEO-plugin on aktiivinen
    if ( function_exists( 'wpseo_auto_load' ) || class_exists( 'RankMath' ) ) {
        return;
    }
    
    $canonical = '';
    
    if ( is_singular() ) {
        $canonical = get_permalink();
    } elseif ( is_category() ) {
        $canonical = get_category_link( get_queried_object_id() );
    } elseif ( is_tag() ) {
        $canonical = get_tag_link( get_queried_object_id() );
    } elseif ( is_author() ) {
        $canonical = get_author_posts_url( get_queried_object_id() );
    } elseif ( is_archive() ) {
        $canonical = get_post_type_archive_link( get_post_type() );
    } elseif ( is_home() ) {
        $canonical = home_url( '/' );
    }
    
    if ( $canonical ) {
        echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'moderni_teal_canonical_url', 1 );

/**
 * SEO: Meta Description
 */
function moderni_teal_meta_description() {
    // Älä lisää, jos SEO-plugin on aktiivinen
    if ( function_exists( 'wpseo_auto_load' ) || class_exists( 'RankMath' ) ) {
        return;
    }
    
    $description = '';
    
    if ( is_singular() ) {
        if ( has_excerpt() ) {
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words( get_the_content(), 30, '...' );
        }
    } elseif ( is_category() ) {
        $description = category_description();
    } elseif ( is_tag() ) {
        $description = tag_description();
    } elseif ( is_archive() ) {
        $description = get_the_archive_description();
    } elseif ( is_home() ) {
        $description = get_bloginfo( 'description' );
    }
    
    if ( $description ) {
        $description = wp_strip_all_tags( $description );
        $description = mb_substr( $description, 0, 160, 'UTF-8' );
        echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'moderni_teal_meta_description', 2 );

/**
 * SEO: Open Graph & Twitter Card Meta Tags
 */
function moderni_teal_social_meta_tags() {
    // Älä lisää, jos SEO-plugin on aktiivinen
    if ( function_exists( 'wpseo_auto_load' ) || class_exists( 'RankMath' ) ) {
        return;
    }
    
    $og_title = '';
    $og_description = '';
    $og_url = '';
    $og_image = '';
    $og_type = 'website';
    
    if ( is_singular() ) {
        $og_title = get_the_title();
        $og_url = get_permalink();
        $og_type = 'article';
        
        if ( has_excerpt() ) {
            $og_description = get_the_excerpt();
        } else {
            $og_description = wp_trim_words( get_the_content(), 30, '...' );
        }
        
        if ( has_post_thumbnail() ) {
            $og_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        }
    } elseif ( is_archive() ) {
        $og_title = get_the_archive_title();
        $og_description = get_the_archive_description();
        $og_url = get_post_type_archive_link( get_post_type() );
    } elseif ( is_home() ) {
        $og_title = get_bloginfo( 'name' );
        $og_description = get_bloginfo( 'description' );
        $og_url = home_url( '/' );
    }
    
    // Open Graph Tags
    if ( $og_title ) {
        echo '<meta property="og:title" content="' . esc_attr( wp_strip_all_tags( $og_title ) ) . '">' . "\n";
    }
    if ( $og_description ) {
        echo '<meta property="og:description" content="' . esc_attr( wp_strip_all_tags( $og_description ) ) . '">' . "\n";
    }
    if ( $og_url ) {
        echo '<meta property="og:url" content="' . esc_url( $og_url ) . '">' . "\n";
    }
    if ( $og_image ) {
        echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
    }
    echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    
    // Twitter Card Tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    if ( $og_title ) {
        echo '<meta name="twitter:title" content="' . esc_attr( wp_strip_all_tags( $og_title ) ) . '">' . "\n";
    }
    if ( $og_description ) {
        echo '<meta name="twitter:description" content="' . esc_attr( wp_strip_all_tags( $og_description ) ) . '">' . "\n";
    }
    if ( $og_image ) {
        echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'moderni_teal_social_meta_tags', 3 );

/**
 * SEO: JSON-LD Schema Markup
 */
function moderni_teal_schema_markup() {
    $schema = array();
    
    // WebSite Schema (etusivulla)
    if ( is_home() || is_front_page() ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo( 'name' ),
            'description' => get_bloginfo( 'description' ),
            'url' => home_url( '/' ),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => array(
                    '@type' => 'EntryPoint',
                    'urlTemplate' => home_url( '/?s={search_term_string}' )
                ),
                'query-input' => 'required name=search_term_string'
            )
        );
        
        // Organization Schema
        $logo_id = get_theme_mod( 'custom_logo' );
        $logo_url = '';
        if ( $logo_id ) {
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        }
        
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => get_bloginfo( 'name' ),
            'url' => home_url( '/' ),
            'logo' => $logo_url ? array(
                '@type' => 'ImageObject',
                'url' => $logo_url
            ) : null
        );
    }
    
    // Article Schema (yksittäisellä artikkelilla)
    if ( is_single() ) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date( 'c' ),
            'dateModified' => get_the_modified_date( 'c' ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            ),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : ''
                )
            ),
            'image' => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '',
            'articleBody' => wp_strip_all_tags( get_the_content() )
        );
    }
    
    // BreadcrumbList Schema
    if ( ! is_front_page() && ! is_404() ) {
        $breadcrumb_items = array();
        $position = 1;
        
        // Etusivu
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => esc_html__( 'Etusivu', 'moderni-teal' ),
            'item' => home_url( '/' )
        );
        
        if ( is_single() ) {
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                $category = $categories[0];
                $breadcrumb_items[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $category->name,
                    'item' => get_category_link( $category->term_id )
                );
            }
            $breadcrumb_items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        } elseif ( is_page() ) {
            $breadcrumb_items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        } elseif ( is_category() ) {
            $breadcrumb_items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => single_cat_title( '', false ),
                'item' => get_category_link( get_queried_object_id() )
            );
        }
        
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items
        );
    }
    
    // Tulosta schema
    foreach ( $schema as $schema_item ) {
        echo '<script type="application/ld+json">' . wp_json_encode( $schema_item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'moderni_teal_schema_markup', 4 );

/**
 * Yhteydenottolomakkeen AJAX-käsittelijä
 */
function moderni_teal_handle_contact_form() {
    // Tarkista nonce-turvakoodi
    if ( ! isset( $_POST['contact_nonce'] ) || ! wp_verify_nonce( $_POST['contact_nonce'], 'moderni_teal_contact' ) ) {
        wp_send_json_error( array( 'message' => 'Turvatarkistus epäonnistui.' ) );
    }

    // Puhdista syötteet
    $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    $email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
    $phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '-';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

    // Validoi pakolliset kentät
    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Täytä kaikki pakolliset kentät.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Virheellinen sähköpostiosoite.' ) );
    }

    // Vastaanottajan sähköposti
    $to = 'info@titanarkiapu.fi';

    // Viestin otsikko
    $subject = 'Yhteydenotto sivustolta: ' . $name;

    // Viestin sisältö
    $body  = "Uusi yhteydenotto sivustolta " . get_bloginfo( 'name' ) . "\n\n";
    $body .= "Nimi: {$name}\n";
    $body .= "Sähköposti: {$email}\n";
    $body .= "Puhelin: {$phone}\n\n";
    $body .= "Viesti:\n{$message}\n";

    // Headers — Reply-To asetetaan lähettäjän osoitteeseen
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: "' . str_replace( '"', '', $name ) . '" <' . $email . '>',
    );

    // Lähetä sähköposti
    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Viesti lähetetty onnistuneesti!' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Viestin lähetys epäonnistui. Yritä myöhemmin.' ) );
    }
}
add_action( 'wp_ajax_moderni_teal_contact', 'moderni_teal_handle_contact_form' );
add_action( 'wp_ajax_nopriv_moderni_teal_contact', 'moderni_teal_handle_contact_form' );

