<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BS4_Skeleton
 */

$hide_sidebar = apply_filters( 'bs4_hide_sidebar', get_theme_mod( 'hide_sidebar', false ) );

if ( ! is_active_sidebar( 'secondary' ) || $hide_sidebar ) :
	return;
endif;
?>

<aside id="secondary" <?php bs4_site_secondary_column_class( 'site-sidebar' ); ?>>
	<?php dynamic_sidebar( 'secondary' ); ?>
</aside><!-- #secondary -->
