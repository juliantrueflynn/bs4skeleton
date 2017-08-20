<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BS4_Skeleton
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<a href="#content" class="sr-only sr-only-focusable"><?php esc_html_e( 'Skip to content', 'bs4' ); ?></a>

	<?php
	// Show or hide header. Filterable and can be set from theme Customizer.
	$hide_header = apply_filters( 'bs4_hide_header', get_theme_mod( 'hide_header', false ) );

	if ( ! $hide_header ) :
		if ( has_nav_menu( 'top' ) ) :
			get_template_part( 'template-parts/nav/nav', 'top' );
		endif;
	endif;
	?>

	<div id="content" class="site-content">
		<?php do_action( 'before_content' ); ?>
