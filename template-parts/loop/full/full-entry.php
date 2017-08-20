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
		<?php if ( '' !== get_the_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_post_thumbnail( 'large', array(
				'class' => 'card-img-top img-fluid w-100',
			) ); ?></a>
		<?php endif; ?>

		<div class="card-body">
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
				<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. */
						__( 'Continue%s', 'bs4' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="sr-only"> "', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<nav><ul class="page-links pagination">',
					'after'  => '</ul></nav>',
				) );
				?>
			</div><!-- .entry-summary -->

			<?php get_template_part( 'template-parts/single/single', 'meta-footer' ); ?>
		</div><!-- .card-body -->
	</div><!-- .card -->
</article><!-- #post-## -->
