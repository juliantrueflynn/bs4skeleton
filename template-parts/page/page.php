<?php
/**
 * The template for displaying default single pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package BS4_Skeleton
 */

?>

<div id="container" <?php bs4_site_container_class(); ?>>
	<div class="row">
		<div id="primary" <?php bs4_site_primary_column_class(); ?>>
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/page/page', 'content' );

					// If comments are open or at least one comment then get comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
				?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- #container -->
