<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>

<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title"><?php
		$count = $product->get_review_count();
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count ) ) :
			/* translators: 1: reviews count 2: product name */
			printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
		else :
			esc_attr_e( 'Reviews', 'woocommerce' );
		endif;
		?></h2>

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist list-group">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array(
					'callback' => 'woocommerce_comments',
				) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				bs4_comments_pagination();
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_attr_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter = wp_get_current_commenter();

				$comment_form = array(
					'title_reply' => have_comments() ? __( 'Add a review', 'woocommerce' ) : sprintf(
						/* translators: %s product title. */
						esc_attr__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ),
						get_the_title()
					),
					'title_reply_to' => /* translators: %s product title. */ __( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
					'title_reply_after' => '</h3>',
					'comment_notes_after' => '',
					'fields' => array(
						'author' => sprintf(
							'<div class="comment-form-author form-group row">%s<div class="col-sm-10">%s</div></div>',
							bs4_form_label( esc_attr__( 'Name', 'bs4' ), 'author', array(
								'class' => 'col-sm-2 col-form-label',
							) ),
							bs4_form_input( 'author', $commenter['comment_author'], array(
								'placeholder' => esc_attr__( 'Your name', 'bs4' ),
							) )
						),
						'email' => sprintf(
							'<div class="comment-form-email form-group row">%s<div class="col-sm-10">%s</div></div>',
							bs4_form_label( esc_attr__( 'Email', 'bs4' ), 'email', array(
								'class' => 'col-sm-2 col-form-label',
							) ),
							bs4_form_input( 'email', $commenter['comment_author_email'], array(
								'placeholder' => esc_attr__( 'Your email', 'bs4' ),
							) )
						),
					),
					'label_submit' => __( 'Add Review', 'woocommerce' ),
					'submit_field' => '<div class="form-submit comment-submit review-submit text-right">%1$s %2$s</div>',
					'class_submit' => esc_attr( join( ' ', bs4_get_btn_class() ) ),
					'logged_in_as' => '',
				);

				$account_page_url = wc_get_page_permalink( 'myaccount' );

				if ( $account_page_url ) :
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(
						/* translators: %s product title. */
						__( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url )
					) . '</p>';
				endif;

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) :
					$ratings_options = array(
						'' => esc_html__( 'Rate&hellip;', 'woocommerce' ),
						'5' => esc_html__( 'Perfect', 'woocommerce' ),
						'4' => esc_html__( 'Good', 'woocommerce' ),
						'3' => esc_html__( 'Average', 'woocommerce' ),
						'2' => esc_html__( 'Not that bad', 'woocommerce' ),
						'1' => esc_html__( 'Very poor', 'woocommerce' ),
					);

					$comment_form['comment_field'] = '<div class="comment-form-rating form-group">';
					$comment_form['comment_field'] .= bs4_form_label( esc_html__( 'Your rating', 'woocommerce' ), 'rating' );
					$comment_form['comment_field'] .= bs4_form_select( 'rating', '', $ratings_options, array(
						'class' => '', // Empty default class.
						'required' => true,
					) );
					$comment_form['comment_field'] .= '</div>';
				endif;

				$comment_form['comment_field'] .= sprintf(
					'<div class="comment-form-comment form-group">%s%s</div>',
					bs4_form_label( esc_attr__( 'Comment', 'bs4' ), 'comment' ),
					bs4_form_textarea( 'comment', '', array(
						'placeholder' => __( 'Your comment', 'bs4' ),
					) )
				);

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_attr_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

	<?php endif; ?>
</div>
