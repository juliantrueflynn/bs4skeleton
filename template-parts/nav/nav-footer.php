<?php
/**
 * Template for displaying the footer navigation
 *
 * @package BS4_Skeleton
 */

?>

<div <?php bs4_site_container_class( 'footer-nav-container' ); ?>>
	<?php wp_nav_menu( array(
		'theme_location' => 'footer',
		'container' 	 => false,
		'menu_class' 	 => 'nav nav-pills nav-fill flex-column flex-sm-row',
		'items_wrap'     => '<nav id="%1$s" class="%2$s" role="navigation">%3$s</nav>',
		'fallback_cb'    => 'BS4_Walker_Nav_Menu::fallback',
		'walker' 	     => new BS4_Walker_Nav_Menu(),
	) ); ?>
</div><!-- .footer-nav-container -->
