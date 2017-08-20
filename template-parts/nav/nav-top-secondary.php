<?php
/**
 * Template for optional top secondary nav
 *
 * @package BS4_Skeleton
 */

wp_nav_menu( array(
	'theme_location' => 'top_secondary',
	'container' 	 => false,
	'depth'			 => 2,
	'menu_class' 	 => 'navbar-nav top-secondary-nav',
	'fallback_cb'    => 'BS4_Walker_Nav_Menu::fallback',
	'walker' 	     => new BS4_Walker_Nav_Menu(),
) );
