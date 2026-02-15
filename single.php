<?php
/**
 * Yksittäisen artikkelin template
 *
 * @package Moderni_Teal
 */

get_header();
?>

<?php moderni_teal_breadcrumbs(); ?>

<main id="primary" class="site-content" role="main">
    <div class="container">
        <div class="content-area<?php echo is_active_sidebar( 'sidebar-1' ) ? ' has-sidebar' : ''; ?>">
            <div class="main-content">

                <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

                    <header class="single-post__header">
                        <div class="single-post__meta">
                            <span><?php moderni_teal_posted_on(); ?></span>
                            <span>&middot;</span>
                            <span><?php moderni_teal_posted_by(); ?></span>
                            <?php
                            $categories_list = get_the_category_list( ', ' );
                            if ( $categories_list ) :
                            ?>
                                <span>&middot;</span>
                                <span><?php echo $categories_list; ?></span>
                            <?php endif; ?>
                        </div>

                        <h1><?php the_title(); ?></h1>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="single-post__featured-image">
                            <?php the_post_thumbnail( 'hero-image' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Sivut:', 'moderni-teal' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer">
                        <?php
                        $tags_list = get_the_tag_list( '', ', ' );
                        if ( $tags_list ) :
                        ?>
                            <div class="post-tags" style="margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--color-gray-200);">
                                <strong><?php esc_html_e( 'Avainsanat: ', 'moderni-teal' ); ?></strong>
                                <?php echo $tags_list; ?>
                            </div>
                        <?php endif; ?>
                    </footer>

                    <?php
                    // Artikkelien navigaatio
                    the_post_navigation( array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( '&laquo; Edellinen', 'moderni-teal' ) . '</span><span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Seuraava &raquo;', 'moderni-teal' ) . '</span><span class="nav-title">%title</span>',
                    ) );
                    ?>

                </article><!-- .single-post -->

                <?php
                // Kommentit
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>

                <?php endwhile; ?>

            </div><!-- .main-content -->

            <?php get_sidebar(); ?>

        </div><!-- .content-area -->
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_footer();