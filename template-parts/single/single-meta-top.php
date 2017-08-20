<?php
/**
 * Template part for displaying the single post top meta area
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BS4_Skeleton
 */

?>

<div class="entry-meta single-entry-meta-top">
	<ul class="list-inline">
		<li class="list-inline-item">
			<span class="author vcard">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="url fn n">
					<i class="fa fa-user"></i>
					<span class="sr-only"><?php esc_attr_e( 'Post author:', 'bs4' ); ?></span>
					<?php echo esc_attr( get_the_author() ); ?>
				</a>
			</span>
		</li>
		<li class="list-inline-item">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<i class="fa fa-clock-o"></i>
				<?php bs4_entry_time(); ?>
			</a>
		</li>
	</ul>
</div>
