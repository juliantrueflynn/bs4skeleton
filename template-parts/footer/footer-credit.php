<?php
/**
 * Displays footer credit links
 *
 * @package BS4_Skeleton
 */

?>

<div <?php bs4_site_container_class( 'footer-container footer-credit' ); ?>>
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'bs4' ) ); ?>"><?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'bs4' ), 'WordPress' );
	?></a>
</div><!-- .footer-credit -->
