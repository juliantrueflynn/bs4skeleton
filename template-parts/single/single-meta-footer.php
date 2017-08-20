<?php
/**
 * Template part for displaying the single post footer meta area
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BS4_Skeleton
 */

?>

<footer class="entry-meta single-entry-meta-footer">
	<?php the_terms( get_the_ID(), 'category', '<div class="post-categories">', ' ', '</div>' ); ?>
	<?php the_terms( get_the_ID(), 'post_tag', '<div class="post-tags"><i class="fa fa-tags" aria-hidden="true"></i> ', ' ', '</div>' ); ?>
</footer>
