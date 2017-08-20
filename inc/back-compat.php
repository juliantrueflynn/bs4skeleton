<?php
/**
 * Bootstrap 4 back compat functionality
 *
 * Prevents Bootstrap 4 from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package BS4_Skeleton
 */

/**
 * Prevent switching to Bootstrap 4 on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function bs4_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'bs4_upgrade_notice' );
}
add_action( 'after_switch_theme', 'bs4_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Bootstrap 4 on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function bs4_upgrade_notice() {
	$message = sprintf(
		/* translators: %s: WordPress version. */
		__( 'Bootstrap 4 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'bs4' ), $GLOBALS['wp_version']
	);

	printf( // WPCS: XSS OK.
		'<div class="error"><p>%s</p></div>',
		$message
	);
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function bs4_customize() {
	wp_die( // WPCS: XSS OK.
		sprintf(
			/* translators: %s: WordPress version. */
			__( 'Bootstrap 4 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'bs4' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'bs4_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function bs4_preview() {
	if ( isset( $_GET['preview'] ) ) { // WPCS: CSRF OK.
		wp_die( // WPCS: XSS OK.
			sprintf(
				/* translators: %s: WordPress version. */
				__( 'Bootstrap 4 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'bs4' ),
				$GLOBALS['wp_version']
			)
		);
	}
}
add_action( 'template_redirect', 'bs4_preview' );
