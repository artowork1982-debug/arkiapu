<?php
/**
 * Hakulomake
 *
 * @package Moderni_Teal
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text" for="search-field">
        <?php esc_html_e( 'Hae:', 'moderni-teal' ); ?>
    </label>
    <input
        type="search"
        id="search-field"
        class="search-field"
        placeholder="<?php esc_attr_e( 'Hae sivustolta&hellip;', 'moderni-teal' ); ?>"
        value="<?php echo get_search_query(); ?>"
        name="s"
    />
    <button type="submit" class="search-submit">
        <?php esc_html_e( 'Hae', 'moderni-teal' ); ?>
    </button>
</form>