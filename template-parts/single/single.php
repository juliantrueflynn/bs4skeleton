<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

					get_template_part( 'template-parts/single/single-content', get_post_format() );

					the_post_navigation( array(
						'prev_text' => '<i class="fa fa-arrow-left"></i> ' . esc_html__( 'Previous', 'bs4' ),
						'next_text' => esc_html__( 'Next', 'bs4' ) . ' <i class="fa fa-arrow-right ml-1"></i>',
					) );

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
