<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BS4_Skeleton
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<?php
		if ( '' !== get_the_post_thumbnail() ) :
			the_post_thumbnail( 'large', array(
				'class' => 'img-fluid w-100 card-img-top',
			) );
		endif;
		?>

		<div class="card-body">
			<?php the_title( '<header class="entry-header"><h1 class="entry-title display-4">', '</h1></header>' ); ?>

			<?php get_template_part( 'template-parts/single/single', 'meta-top' ); ?>

			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<nav><ul class="page-links pagination">',
					'after'  => '</ul></nav>',
				) );
				?>
			</div><!-- .entry-content -->

			<?php get_template_part( 'template-parts/single/single', 'meta-footer' ); ?>
		</div><!-- .card-body -->
	</div><!-- .card -->
</article><!-- #post-## -->
