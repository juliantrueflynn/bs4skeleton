<?php
/**
 * The main loop title template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

if ( is_archive() || is_post_type_archive() ) :

	the_archive_title( '<header class="loop-header"><h1 class="loop-title">', '</h1></header>' );

elseif ( ! is_front_page() && is_home() ) : ?>

	<header class="loop-header">
		<h1 class="loop-title"><?php single_post_title( '', false ); ?></h1>
	</header>

<?php
endif;
