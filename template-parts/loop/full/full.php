<?php
/**
 * The full loop layout template (default template for loops)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

if ( have_posts() ) :

	// Start the loop.
	while ( have_posts() ) : the_post();

		// Display loop content by loop type.
		get_template_part( 'template-parts/loop/full/full-entry', get_post_format() );

	endwhile; // Close the loop.

	the_posts_navigation( array(
		'next_text' => __( 'Next', 'bs4' ) . ' <i class="fa fa-arrow-right"></i>',
		'prev_text' => '<i class="fa fa-arrow-left"></i> ' . __( 'Previous', 'bs4' ),
	) );

endif;
