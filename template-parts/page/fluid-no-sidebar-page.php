<?php
/**
 * The template for displaying fluid no sidebar page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 * @link https://codex.wordpress.org/Pages#Page_Templates
 *
 * @package BS4_Skeleton
 */

?>

<div id="container" <?php bs4_site_container_class(); ?>>
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/page/page', 'content' ); ?>

			<?php
			// If comments are open or at least one comment then get comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #container -->
