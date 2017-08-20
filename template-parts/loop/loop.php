<?php
/**
 * The main loop content template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

?>

<div id="container" <?php bs4_site_container_class(); ?>>
	<div class="row">
		<div id="primary" <?php bs4_site_primary_column_class(); ?>>
			<main id="main" class="site-main" role="main">
				<?php if ( is_archive() || is_post_type_archive() ) : ?>
					<?php the_archive_title( '<header class="loop-header"><h1 class="loop-title">', '</h1></header>' ); ?>
				<?php elseif ( ! is_front_page() && is_home() ) : ?>
					<header class="loop-header">
						<h1 class="loop-title"><?php single_post_title( '', false ); ?></h1>
					</header>
				<?php endif; ?>

				<div id="site-loop" class="site-loop loop-<?php bs4_loop_layout(); ?>-layout">
					<?php get_template_part( 'template-parts/loop/' . bs4_get_loop_layout() . '/' . bs4_get_loop_layout() ); ?>
				</div><!-- #site-loop -->

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- #container -->
