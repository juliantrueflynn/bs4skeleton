<?php
/**
 * Bootstrap 4 functions and definitions
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BS4_Skeleton
 */

/*
 * Bootstrap 4 only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';

	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bs4_setup() {
	/*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/bs4
     * If you're building a theme based on Bootstrap 4, use a find and replace
     * to change 'bs4' to the name of your theme in all the template files.
     */
	load_theme_textdomain( 'bs4' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Set the default content width.
	$GLOBALS['content_width'] = 688;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top' => esc_html__( 'Top Menu', 'bs4' ),
		'top_secondary' => esc_html__( 'Top Secondary Menu', 'bs4' ),
		'footer' => esc_html__( 'Footer Menu', 'bs4' ),
	) );

	// Switch default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'bs4_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bs4_content_width() {
	$content_width = 688;

	if ( 'no-sidebar-page' === bs4_get_page_template_slug() ) {
		$content_width = 1110;
	}

	$GLOBALS['content_width'] = apply_filters( 'bs4_content_width', $content_width );
}
add_action( 'template_redirect', 'bs4_content_width', 0 );

/**
 * Register WordPress widgets.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bs4_widgets_init() {
	// Sidebar widget area arguments.
	$sidebar_args = array(
		'name' => __( 'Sidebar', 'bs4' ),
		'id' => 'secondary',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'bs4' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	);

	// Footer widget area arguments.
	$footer_args = array(
		'name' => __( 'Footer', 'bs4' ),
		'id' => 'footer',
		'description' => __( 'Add widgets here to appear in your footer.', 'bs4' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s col-md">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	);

	// Register sidebar widget and make filterable.
	register_sidebar( apply_filters( 'bs4_sidebar_widget_args', $sidebar_args ) );

	// Register footer widget and make filterable.
	register_sidebar( apply_filters( 'bs4_footer_widget_args', $footer_args ) );
}
add_action( 'widgets_init', 'bs4_widgets_init' );

/**
 * Replaces default "[...]" (appended to automatically generated excerpts) with ellipsis and 'Continue' link.
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_more
 *
 * @param string $link 'Continue reading' link prepended with an ellipsis.
 */
function bs4_excerpt_more( $link ) {
	// If WordPress admin area then return unedited.
	if ( is_admin() ) {
		return $link;
	}

	// Format excerpt link HTML output.
	$link = sprintf(
		wp_kses(
			/* translators: 1: Post url, 2: Post title */
			__( '&hellip; <p class="card-text"><a href="%1$s" class="more-link card-link d-block">Continue %2$s</a></p>', 'bs4' ),
			array(
				'p' => array(
					'class' => array(),
				),
				'a' => array(
					'href' => array(),
					'class' => array(),
				),
				'span' => array(
					'class' => array(),
				),
			)
		),
		esc_url( get_permalink( get_the_ID() ) ),
		the_title( '<span class="sr-only">"', '"</span>', false )
	);

	return $link;
}
add_filter( 'excerpt_more', 'bs4_excerpt_more' );

/**
 * Add parent wrapper to WordPress "More Link".
 *
 * @param string $link More link HTML.
 */
function bs4_the_content_more_link( $link ) {
	return '<p class="more-link-tag card-text">' . $link . '</p>';
}
add_filter( 'the_content_more_link', 'bs4_the_content_more_link' );

/**
 * Enqueue scripts and styles.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
 */
function bs4_scripts() {
	// FontAwesome stylesheet.
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/vendors/font-awesome/css/font-awesome.min.css' ) );

	// Bootstrap 4 stylesheet that's filterable.
	wp_enqueue_style( 'bootstrap-4', get_theme_file_uri( '/vendors/bootstrap/css/bootstrap.min.css' ) );

	// Theme custom stylesheet.
	wp_enqueue_style( 'parent', get_stylesheet_uri() );

	// Inline layout styles.
	wp_add_inline_style( 'parent', bs4_layout_inline_styles() );

	// Popper for Bootstrap 4 popovers and tooltips script.
	wp_enqueue_script( 'popper', get_theme_file_uri( '/vendors/popper/popper.js' ), array( 'jquery' ), false, true );

	// Bootstrap 4 script.
	wp_enqueue_script( 'bootstrap-4', get_theme_file_uri( '/vendors/bootstrap/js/bootstrap.min.js' ), array( 'jquery' ), false, true );

	// Comment, threaded comments, and replies script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bs4_scripts' );

/*
 * Custom plugins for this theme if activated
 */
require get_parent_theme_file_path( '/inc/plugins/plugins.php' );

/*
 * Custom walker for WordPress nav menu
 */
require get_parent_theme_file_path( '/inc/class-bs4-walker-nav-menu.php' );

/*
 * Custom walker for WordPress child page list
 */
require get_parent_theme_file_path( '/inc/class-bs4-walker-page.php' );

/*
 * Custom walker for WordPress blog comments and replies
 */
require get_parent_theme_file_path( '/inc/class-bs4-walker-comments.php' );

/*
 * Custom template tags for this theme
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/*
 * Theme conditional CSS styles
 */
require get_parent_theme_file_path( '/inc/template-styles.php' );

/*
 * Bootstrap helpers
 */
require get_parent_theme_file_path( '/inc/template-bootstrap-functions.php' );

/*
 * Additional features to allow styling of the templates
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/*
 * Customizer additions
 */
require get_parent_theme_file_path( '/inc/customizer.php' );
