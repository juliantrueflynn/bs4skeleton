<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package BS4_Skeleton
 */

get_header(); ?>

	<div id="container" <?php bs4_site_container_class(); ?>>
		<div class="row">
			<div id="primary" <?php bs4_site_primary_column_class(); ?>>
				<main id="main" class="site-main" role="main">

					<header class="entry-header">
						<h1 class="entry-title"><?php
							/* translators: %s: search query. */
							printf( esc_html__( '&#8220;%s&#8221; Search Results', 'bs4' ), get_search_query() );
						?></h1>
					</header><!-- .page-header -->

					<div id="site-loop" class="site-loop loop-<?php bs4_loop_layout(); ?>-layout">
						<?php get_template_part( 'template-parts/loop/' . bs4_get_loop_layout() . '/' . bs4_get_loop_layout() ); ?>
					</div><!-- #site-loop -->

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- #container -->

<?php
get_footer();
