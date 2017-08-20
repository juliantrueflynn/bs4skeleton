<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BS4_Skeleton
 */

?>

		<?php do_action( 'after_content' ); ?>
	</div><!-- .site-content -->

	<footer id="site-footer" role="contentinfo">
		<?php
		$hide_footer = apply_filters( 'bs4_hide_footer', get_theme_mod( 'hide_footer', false ) );

		if ( ! $hide_footer ) :

			// Footer widgets area template.
			if ( is_active_sidebar( 'footer' ) ) :
				get_template_part( 'template-parts/footer/footer', 'widgets' );
			endif;

			$hide_copyright = apply_filters( 'bs4_hide_footer_copyright', get_theme_mod( 'hide_footer_copyright', false ) );

			if ( ! $hide_copyright ) :
				// Footer copyright template.
				get_template_part( 'template-parts/footer/footer', 'copyright' );
			endif;

			$hide_credit = apply_filters( 'bs4_hide_footer_credit_links', get_theme_mod( 'hide_footer_credit_links', false ) );

			if ( ! $hide_credit ) :
				// Footer credit links template.
				get_template_part( 'template-parts/footer/footer', 'credit' );
			endif;

		endif;
		?>
	</footer><!-- #site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
