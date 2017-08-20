<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BS4_Skeleton
 */

get_header();

	get_template_part( 'template-parts/single/single', get_post_type() );

get_footer();
