<?php
/**
 * Template Name: Fluid Page
 *
 * @link https://codex.wordpress.org/Pages#Page_Templates
 *
 * @package BS4_Skeleton
 */

get_header();

	get_template_part( 'template-parts/page/' . bs4_get_page_template_slug() );

get_footer();
