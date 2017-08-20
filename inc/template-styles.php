<?php
/**
 * Theme inline styles
 *
 * @package BS4_Skeleton
 */

 /**
  * CSS styles for theme
  */
function bs4_layout_inline_styles() {
	$css = '
	.hidden {
	    display: none
	}';

	$css .= '
	.site-sidebar > .widget {
		margin-bottom: 1rem;
	}

	.site-navbar .top-nav {
		margin-left: auto;
	}

	.site-navbar .nav-search {
		margin-left: .5rem;
	}';

	// Styles for fixed top navbar.
	if ( in_array( 'fixed-top', bs4_get_site_navbar_class(), true ) ) :
		$css .= '
		.has-fixed-top {
		    padding-top: 80px;
		}';

		// This is needed to fix adminbar and Bootstrap fixed-top conflict.
		if ( is_admin_bar_showing() ) :
			$css .= '
			.adminbar-with-fixed-top .fixed-top {
			    top: 32px
			}

			@media screen and (max-width: 782px) {
			    .adminbar-with-fixed-top .fixed-top {
			        top: 46px
			    }
			}

			@media screen and (max-width: 600px) {
			    .adminbar-with-fixed-top #wpadminbar {
			        position: fixed;
			    }
			}';
		else :
			$css .= '
			.top-navbar {
				margin-bottom: 2rem;
			}';
		endif;
	endif;

	if ( is_singular() ) :
		// Single template styles.
		$css .= '
		.single-entry {
			margin-bottom: 1rem;
		}

		.post-navigation {
			margin-bottom: 1rem;
		}

		.single-entry-meta-top {
			margin-bottom: 1rem;
		}

		.single-entry-meta-footer {
			margin-top: 1.5rem;
		}

		.single-entry-meta-footer .post-categories {
			margin-bottom: .5rem;
		}';

		if ( 0 < get_comments_number() ) :
			// Comments template.
			$css .= '
			.commentlist > .comment {
				margin-top: 1.5rem;
			}

			.commentlist > .comment:first-child {
				margin-top: 0;
			}

			.comment-avatar {
				margin-right: 1rem;
			}

			.comment > .children {
    			margin-left: .5rem;
			}

			.children .comment-body {
    			margin-bottom: 1rem;
			}

			.reply-to-text > span {
				opacity: .7;
			}';
		endif;
	else :
		// Loop template styles.
		$css .= '
		.posts-navigation {
			margin-top: 1.25rem;
			margin-bottom: 1.25rem;
		}

		.loop-title {
			margin-bottom: 2rem;
		}

		.loop-entry {
			margin-bottom: 2rem;
		}

		.excerpt-thumb {
			margin-right: 1rem;
		}';
	endif;

	// Site footer styles.
	$css .= '
	footer#site-footer {
		margin-top: 1rem;
		padding-top: 1rem;
		padding-bottom: 1rem;
	}

	.footer-container {
		padding-top: .5rem;
		padding-bottom: .5rem;
	}

	footer#site-footer .widget-area > .widget {
		margin-top: 1rem;
		margin-bottom: 1rem;
	}

	.footer-copyright {
		margin-top: 2rem;
	}

	.copyright-text > a {
		color: inherit;
	}';

	return apply_filters( 'bs4_layout_inline_styles', $css );
}
