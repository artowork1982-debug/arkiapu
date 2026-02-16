<?php
/**
 * Sivutemplate
 *
 * @package Moderni_Teal
 */

get_header();
?>

<main id="primary" class="site-content" role="main">
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

 

        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content" style="max-width: 800px; margin: 0 auto;">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Sivut:', 'moderni-teal' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div><!-- .entry-content -->
        </article>

        <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>

        <?php endwhile; ?>

    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_footer();