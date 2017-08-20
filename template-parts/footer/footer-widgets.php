<?php
/**
 * Displays footer widgets if assigned
 *
 * @package BS4_Skeleton
 */

?>

<div <?php bs4_site_container_class( 'footer-container widget-area' ); ?>>
	<div class="row">
		<?php dynamic_sidebar( 'footer' ); ?>
	</div><!-- .row -->
</div><!-- .widget-area -->
