<?php
/**
 * The grid loop layout template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

// Start the Loop index count.
$i = 0;
?>

<?php if ( have_posts() ) : ?>

	<div class="row">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Display loop content by loop type.
			get_template_part( 'template-parts/loop/grid/grid-entry', get_post_format() );

			// Split row based on posts_per_row setting in Customizer.
			bs4_loop_grid_rows_splitter( $i );

			$i++;

		endwhile; // Close the loop.
		?>

	</div><!-- .row -->

	<?php the_posts_navigation( array(
		'next_text' => __( 'Next' ) . ' <i class="fa fa-arrow-right"></i>',
		'prev_text' => '<i class="fa fa-arrow-left"></i> ' . __( 'Previous' ),
	) ); ?>

<?php
endif;
