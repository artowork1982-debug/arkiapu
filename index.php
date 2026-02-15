<?php
/**
 * Päätemplate - Blogi / Arkisto
 *
 * @package Moderni_Teal
 */

get_header();
?>

<?php 
// Show breadcrumbs on archive and search pages
if ( is_archive() || is_search() ) {
    moderni_teal_breadcrumbs(); 
}
?>

<main id="primary" class="site-content" role="main">
    <div class="container">

        <?php if ( is_home() && ! is_paged() ) : ?>
        <div class="page-hero">
            <h1><?php bloginfo( 'name' ); ?></h1>
            <p><?php bloginfo( 'description' ); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( is_archive() || is_search() ) : ?>
        <div class="page-hero" style="margin-bottom: var(--spacing-2xl);">
            <h1>
                <?php
                if ( is_search() ) {
                    printf( esc_html__( 'Hakutulokset: "%s"', 'moderni-teal' ), get_search_query() );
                } elseif ( is_category() ) {
                    single_cat_title();
                } elseif ( is_tag() ) {
                    single_tag_title();
                } elseif ( is_author() ) {
                    the_author();
                } elseif ( is_day() ) {
                    echo get_the_date();
                } elseif ( is_month() ) {
                    echo get_the_date( 'F Y' );
                } elseif ( is_year() ) {
                    echo get_the_date( 'Y' );
                } else {
                    esc_html_e( 'Arkisto', 'moderni-teal' );
                }
                ?>
            </h1>
            <?php the_archive_description( '<p>', '</p>' ); ?>
        </div>
        <?php endif; ?>

        <div class="content-area<?php echo is_active_sidebar( 'sidebar-1' ) ? ' has-sidebar' : ''; ?>">
            <div class="main-content">
                <?php if ( have_posts() ) : ?>
                    <div class="posts-grid">
                        <?php while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'card-thumbnail', array( 'class' => 'post-card__image' ) ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="post-card__image-placeholder">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <div class="post-card__content">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) :
                                ?>
                                    <span class="post-card__category">
                                        <?php echo esc_html( $categories[0]->name ); ?>
                                    </span>
                                <?php endif; ?>

                                <h2 class="post-card__title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="post-card__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="post-card__meta">
                                    <span><?php moderni_teal_posted_on(); ?></span>
                                    <span>&middot;</span>
                                    <span><?php moderni_teal_posted_by(); ?></span>
                                </div>
                            </div><!-- .post-card__content -->

                        </article><!-- .post-card -->

                        <?php endwhile; ?>
                    </div><!-- .posts-grid -->

                    <div class="pagination">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="no-results">
                        <h2><?php esc_html_e( 'Sisältöä ei löytynyt', 'moderni-teal' ); ?></h2>
                        <p><?php esc_html_e( 'Valitettavasti hakuasi vastaavaa sisältöä ei löytynyt. Kokeile hakua eri hakusanoilla.', 'moderni-teal' ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </div><!-- .main-content -->

            <?php get_sidebar(); ?>

        </div><!-- .content-area -->

    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_footer();