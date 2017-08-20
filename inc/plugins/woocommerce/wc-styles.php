<?php
/**
 * Inline styles for WooCommerce plugin.
 *
 * By default this theme removes WooCommerce stylesheets. Here we're re-adding the styling we need.
 *
 * This method provides site speed benefit compared to WooCommerce default.
 *
 * @package BS4_Skeleton
 */

/**
 * Inline styles for WooCommerce.
 *
 * @param string $css Theme inline styles.
 */
function bs4_wc_inline_styles( $css ) {
	// Product sale label positioning.
	$css .= '
	.product .onsale {
	    position: absolute;
	    z-index: 1;
		margin: .625rem;
	}';

	$css .= '
	.single-product-row {
		margin-bottom: 1.25rem;
	}';

	// Nav mini cart.
	$css .= '
	.nav-cart-dropdown-menu > .dropdown-item {
		width: 14rem;
	}

	.nav-cart-item-text {
		white-space: normal;
	}

	.dropdown-item.active .nav-cart-item-text a,
	.dropdown-item:active .nav-cart-item-text a,
	.dropdown-item:focus .nav-cart-item-text a,
	.dropdown-item:hover .nav-cart-item-text a {
		color: inherit;
	}

	.nav-cart__buttons:active,
	.nav-cart__buttons:hover {
		background-color: transparent;
	}';

	if ( is_product() ) :
		// WooCommerce single product images/gallery.
		$css .= '
		.woocommerce div.product div.images img {
		    display: block;
		    width: 100%;
		    height: auto;
		    box-shadow: none
		}

		.woocommerce div.product div.images div.thumbnails {
		    padding-top: 1em
		}

		.woocommerce div.product div.images.woocommerce-product-gallery {
		    position: relative
		}

		.woocommerce div.product div.images .woocommerce-product-gallery__wrapper {
		    transition: all cubic-bezier(.795, -.035, 0, 1) .5s
		}

		.woocommerce div.product div.images .woocommerce-product-gallery__image:nth-child(n+2) {
		    width: 25%;
		    display: inline-block
		}

		.woocommerce div.product div.images .woocommerce-product-gallery__trigger {
		    position: absolute;
		    top: .5em;
		    right: .5em;
		    font-size: 2em;
		    z-index: 9;
		    width: 36px;
		    height: 36px;
		    background: #fff;
		    text-indent: -9999px;
		    border-radius: 100%;
		    box-sizing: content-box
		}

		.woocommerce div.product div.images .woocommerce-product-gallery__trigger:before {
		    content: "";
		    display: block;
		    width: 10px;
		    height: 10px;
		    border: 2px solid #000;
		    border-radius: 100%;
		    position: absolute;
		    top: 9px;
		    left: 9px;
		    box-sizing: content-box
		}

		.woocommerce div.product div.images .woocommerce-product-gallery__trigger:after {
		    content: "";
		    display: block;
		    width: 2px;
		    height: 8px;
		    background: #000;
		    border-radius: 6px;
		    position: absolute;
		    top: 19px;
		    left: 22px;
		    -webkit-transform: rotate(-45deg);
		    -moz-transform: rotate(-45deg);
		    -ms-transform: rotate(-45deg);
		    -o-transform: rotate(-45deg);
		    transform: rotate(-45deg);
		    box-sizing: content-box
		}

		.woocommerce div.product div.images .flex-control-thumbs {
		    overflow: hidden;
		    zoom: 1;
		    margin: 0;
		    padding: 0
		}

		.woocommerce div.product div.images .flex-control-thumbs li {
		    width: 25%;
		    float: left;
		    margin: 0;
		    list-style: none
		}

		.woocommerce div.product div.images .flex-control-thumbs li img {
		    cursor: pointer;
		    opacity: .5;
		    margin: 0
		}

		.woocommerce div.product div.images .flex-control-thumbs li img.flex-active,
		.woocommerce div.product div.images .flex-control-thumbs li img:hover {
		    opacity: 1
		}

		.woocommerce #content div.product div.thumbnails.columns-1 a,
		.woocommerce div.product div.thumbnails.columns-1 a,
		.woocommerce-page #content div.product div.thumbnails.columns-1 a,
		.woocommerce-page div.product div.thumbnails.columns-1 a {
		    width: 100%;
		    margin-right: 0;
		    float: none
		}

		.woocommerce #content div.product div.thumbnails.columns-2 a,
		.woocommerce div.product div.thumbnails.columns-2 a,
		.woocommerce-page #content div.product div.thumbnails.columns-2 a,
		.woocommerce-page div.product div.thumbnails.columns-2 a {
		    width: 48%
		}

		.woocommerce #content div.product div.thumbnails.columns-4 a,
		.woocommerce div.product div.thumbnails.columns-4 a,
		.woocommerce-page #content div.product div.thumbnails.columns-4 a,
		.woocommerce-page div.product div.thumbnails.columns-4 a {
		    width: 22.05%
		}

		.woocommerce #content div.product div.thumbnails.columns-5 a,
		.woocommerce div.product div.thumbnails.columns-5 a,
		.woocommerce-page #content div.product div.thumbnails.columns-5 a,
		.woocommerce-page div.product div.thumbnails.columns-5 a {
		    width: 16.9%
		}';

		// Product summary.
		$css .= '
		.entry-summary .entry-title {
			margin-bottom: 1rem;
		}

		.woocommerce-product-details__short-description {
			margin-bottom: 2rem;
		}

		.product_meta {
			margin-top: 1rem;
		}

		.product_meta .sku_wrapper {
			margin-bottom: .5rem;
			display: block;
		}';

		// Additional product sections.
		$css .= '
		.woocommerce-tabs {
			margin-bottom: 1.25rem;
		}

		.woocommerce-tabs .tab-content {
			padding-top: .625rem;
			padding-bottom: .625rem;
		}

		.up-sells.upsells.products {
			margin-top: 1.25rem;
			margin-bottom: 1.25rem;
		}

		.related.products {
			margin-top: 1.25rem;
			margin-bottom: 1.25rem;
		}

		.related .loop-entry {
			margin-bottom: 1.25rem;
		}';

		// Review form.
		$css .= '
		div#review_form_wrapper {
			margin-top: 1.25rem;
		}';
	endif;

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) :
		// Star ratings.
		$css .= '
		.star-rating {
			display: block;
			position: relative;
			overflow: hidden;
			height: 1rem;
			line-height: 1rem;
			font-size: 1rem;
			width: 4.8rem;
		}

		.star-rating::before {
			font-family: FontAwesome;
			font-style: normal;
			font-weight: normal;
			text-decoration: inherit;
			content: "\f006\f006\f006\f006\f006";
		}

		.star-rating span {
			overflow: hidden;
			padding-top: 1.5rem;
		}

		.star-rating span::before {
			font-family: FontAwesome;
			font-style: normal;
			font-weight: normal;
			text-decoration: inherit;
			content: "\f005\f005\f005\f005\f005";
		}

		.star-rating::before,
		.star-rating span::before,
		.star-rating span {
			position: absolute;
			top: 0;
			left: 0;
		}';

		if ( is_product() ) :
			// Star ratings on single products.
			$css .= '
			.woocommerce-product-rating .star-rating {
				float: left;
			}

			.comment-text .star-rating {
				float: right;
			}';

			// Star ratings in review comment form.
			if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) :
				$css .= '
				#review_form p.stars a {
					position: relative;
					text-indent: -999em;
					display: inline-block;
					text-decoration: none;
				}

				#review_form p.stars a,
				#review_form p.stars a:before {
					width: 1.2rem;
					font-size: 1.2rem;
				}

				#review_form p.stars a:before,
				#review_form p.stars a:hover ~ a:before,
				#review_form p.stars:hover a:before,
				#review_form p.stars.selected a.active:before,
				#review_form p.stars.selected a.active~a:before,
				#review_form p.stars.selected a:not(.active):before {
					font-family: FontAwesome;
					font-style: normal;
					font-weight: normal;
					text-decoration: inherit;
					content: "\f005";
				}

				#review_form p.stars a:before {
					display: block;
					position: absolute;
					top: 0;
					left: 0;
					color: #43454b;
					text-indent: 0;
					opacity: .25;
				}

				#review_form p.stars a:hover~a:before,
				#review_form p.stars.selected a.active~a:before {
					color: #43454b;
					opacity: .25;
				}

				#review_form p.stars:hover a:before,
				#review_form p.stars.selected a.active:before,
				#review_form p.stars.selected a:not(.active):before {
					color: #96588a;
					opacity: 1;
				}';
			endif;
		endif;
	endif;

	return $css;
}
add_filter( 'bs4_layout_inline_styles', 'bs4_wc_inline_styles' );
