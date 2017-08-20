<?php
/**
 * Template for displaying search forms
 *
 * @package BS4_Skeleton
 */

$unique_id = uniqid( 'search-form-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="sr-only">
		<?php echo esc_attr_x( 'Search for:', 'label', 'bs4' ); ?>
	</label>

	<div class="input-group">
		<span class="input-group-btn">
			<button type="submit" <?php bs4_btn_class( 'btn-search' ); ?>>
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		</span>
		<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'bs4' ); ?>" value="<?php the_search_query(); ?>" name="s" />
	</div><!-- .input-group -->
</form>
