<?php
/**
 * The main template WooCommerce file
 *
 * This is the most generic template file in a WooCommerce supported theme.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */

get_header(); ?>

	<div id="container" <?php bs4_site_container_class(); ?>>
		<div class="row">
			<div id="primary" <?php bs4_site_primary_column_class(); ?>>
				<main id="main" class="site-main" role="main">

					<?php
					/**
					 * woocommerce_before_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 * @hooked WC_Structured_Data::generate_website_data() - 30
					 */
					do_action( 'woocommerce_before_main_content' );

					if ( is_singular( 'product' ) ) :

						while ( have_posts() ) : the_post();

							wc_get_template_part( 'content', 'single-product' );

						endwhile;

					else :

						if ( apply_filters( 'woocommerce_show_page_title', true ) ) :

							printf(
								'<header class="entry-header"><h1 class="entry-title page-title">%s</h1></header><!-- .entry-header -->',
								esc_html( woocommerce_page_title( false ) )
							);

						endif;

						do_action( 'woocommerce_archive_description' );

						if ( have_posts() ) :

							do_action( 'woocommerce_before_shop_loop' );

							woocommerce_product_loop_start();

							while ( have_posts() ) : the_post();

								wc_get_template_part( 'content', 'product' );
								bs4_wc_loop_grid_rows_splitter();

							endwhile; // End of the loop.

							woocommerce_product_loop_end();

							do_action( 'woocommerce_after_shop_loop' );

						endif;

					endif;

					/**
					 * woocommerce_after_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
				/**
				 * woocommerce_sidebar hook.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
			?>

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- #container -->

<?php
get_footer();
