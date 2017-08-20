<?php
/**
 * Template for displaying the top navigation
 *
 * @package BS4_Skeleton
 */

?>

<nav id="site-navigation" <?php bs4_site_navbar_class( 'navbar-expand-lg' ); ?> role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'bs4' ); ?>">
	<div <?php bs4_site_container_class( 'top-navbar-container' ); ?>>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#topNavCollapse" aria-controls="topNavCollapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'bs4' ); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
			<?php
			if ( has_custom_logo() ) :
				the_custom_logo();
			else :
				echo esc_attr( get_bloginfo( 'name' ) );
			endif;
			?>
		</a>

		<div id="topNavCollapse" class="collapse navbar-collapse">
			<?php

			wp_nav_menu( array(
				'theme_location' => 'top',
				'container' 	 => false,
				'depth'			 => 2,
				'menu_class' 	 => 'navbar-nav top-nav',
				'fallback_cb'    => 'BS4_Walker_Nav_Menu::fallback',
				'walker' 	     => new BS4_Walker_Nav_Menu(),
			) );

			bs4_navbar_search();

			if ( has_nav_menu( 'top_secondary' ) ) :
				get_template_part( 'template-parts/nav/nav', 'top-secondary' );
			endif;
			?>
		</div><!-- #topNavCollapse -->
	</div><!-- .top-navbar-container -->
</nav><!-- #site-navigation -->
