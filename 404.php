<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BS4_Skeleton
 */

get_header(); ?>

<div id="container" <?php bs4_site_container_class(); ?>>
	<main id="main" class="site-main" role="main">

		<header class="entry-header">
			<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bs4' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php esc_html_e( 'Maybe try a search?', 'bs4' ); ?></p>

			<?php get_search_form(); ?>
		</div><!-- .entry-content -->

	</main><!-- #main -->
</div><!-- #container -->

<?php
get_footer();
