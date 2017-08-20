<?php
/**
 * Template part for displaying page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package BS4_Skeleton
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<div class="card-body">
			<?php the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header>' ); ?>

			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<nav><ul class="page-links pagination">',
					'after'  => '</ul></nav>',
				) );
				?>
			</div><!-- .entry-content -->

			<?php edit_post_link( esc_attr__( 'Edit', 'bs4' ), '', '', 0, 'float-sm-right' ); ?>
		</div><!-- .card-body -->
	</div><!-- .card -->
</article><!-- #post-## -->
