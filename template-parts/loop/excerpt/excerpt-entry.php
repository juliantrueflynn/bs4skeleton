<?php
/**
 * Template part for displaying posts with excerpts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<div class="card-body media">
			<?php if ( '' !== get_the_post_thumbnail() ) : ?>
				<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_post_thumbnail( 'thumbnail', array(
					'class' => 'img-fluid img-thumbnail d-flex excerpt-thumb',
				) ); ?></a>
			<?php endif; ?>

			<div class="media-body">
				<?php
				the_title(
					sprintf(
						'<header class="entry-header"><h2 class="entry-title"><a href="%s" rel="bookmark" title="%s">',
						esc_url( get_permalink() ),
						the_title_attribute( array(
							'before' => 'Permalink to: ',
							'echo'   => false,
						) )
					),
					'</a></h2></header>'
				);

				get_template_part( 'template-parts/single/single', 'meta-top' );
				?>

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</div><!-- .media-body -->
		</div><!-- .card-body -->
	</div><!-- .card -->
</article><!-- #post-## -->
