<?php
/**
 * The loop grid item template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<?php if ( '' !== get_the_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_post_thumbnail( 'thumbnail', array(
				'class' => 'img-fluid w-100 card-img-top',
			) ); ?></a>
		<?php endif; ?>

		<div class="card-body">
			<?php
			the_title(
				sprintf(
					'<header class="entry-header"><h5 class="entry-title"><a href="%s" rel="bookmark" title="%s">',
					esc_url( get_permalink() ),
					the_title_attribute( array(
						'before' => 'Permalink to: ',
						'echo'   => false,
					) )
				),
				'</a></h5></header>'
			);
			?>

			<div class="entry-meta">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<i class="fa fa-clock-o"></i>
					<?php bs4_entry_time(); ?>
				</a>
				<?php edit_post_link( esc_attr__( 'Edit', 'bs4' ), '', '', 0, 'float-sm-right' ); ?>
			</div><!-- .entry-meta -->
		</div><!-- .card-body -->
	</div><!-- .card -->
</article><!-- #post-## -->
