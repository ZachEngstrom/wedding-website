<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Match
 */

if ( ! function_exists( 'match_the_posts_pagination' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function match_the_posts_pagination() {

	// Previous/next posts navigation @since 4.1.0
	the_posts_pagination( array(
		'prev_text'          => '<span class="sr-only">' . esc_html__( 'Previous Page', 'match' ) . '</span>',
		'next_text'          => '<span class="sr-only">' . esc_html__( 'Next Page', 'match' ) . '</span>',
		'before_page_number' => '<span class="meta-nav sr-only">' . esc_html__( 'Page', 'match' ) . ' </span>',
	) );

}
endif;

if ( ! function_exists( 'match_the_post_pagination' ) ) :
/**
 * Previous/next post navigation.
 *
 * @return void
 */
function match_the_post_pagination() {

	// Previous/next post navigation @since 4.1.0.
	the_post_navigation( array(
		'next_text' => '<span class="post-title">%title</span>' . '<span class="meta-nav">' . esc_html__( '&rarr;', 'match' ) . '</span> ',
		'prev_text' => '<span class="meta-nav">' . esc_html__( '&larr;', 'match' ) . '</span>' . '<span class="post-title">%title</span>',
	) );

}
endif;

if ( ! function_exists( 'match_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function match_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'match' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function match_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so match_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so match_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in match_categorized_blog.
 */
function match_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'match_category_transient_flusher' );
add_action( 'save_post',     'match_category_transient_flusher' );

/**
 * Display an optional post thumbnail for standard post.
 *
 * @return void
*/
function match_post_thumbnail_standard() {

	// Sticky Icon
	if ( is_sticky() && is_home() && ! is_paged() ) {
	?>
	<div class="entry-media">
		<?php match_post_thumbnail(); ?>
		<div class="entry-format">
			<div class="entry-format-icon">
				<i class="fa fa-thumb-tack"></i>
			</div>
		</div><!-- .entry-format -->
	</div><!-- .entry-media -->
	<?php
	} elseif ( '' != get_the_post_thumbnail() ) {
		match_post_thumbnail();
	} // if ( is_sticky() && is_home() && ! is_paged() )

}

/**
 * Display an optional backfill for post thumbnail.
 * Backfill logic is for,
 *
 * Post Formats
 * Stick Post but not on single page
 *
 * @return void
*/
function match_post_thumbnail_backfill() {

	if ( '' != get_post_format() || ( is_sticky() && ! is_singular() ) ) :
	?>
	<div class="post-thumbnail post-thumbnail-backfill"></div>
	<?php
	endif;
}

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @return void
*/
function match_post_thumbnail() {

	// Post password check
	if ( post_password_required() || '' == get_the_post_thumbnail() ) {
		match_post_thumbnail_backfill();
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
	<?php the_post_thumbnail( 'match-standard' ); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<div class="post-thumbnail">
		<a href="<?php esc_url( the_permalink() ); ?>">
		<?php the_post_thumbnail( 'match-standard' ); ?>
		</a>
	</div><!-- .post-thumbnail -->

	<?php endif; // End is_singular()
}

if ( ! function_exists( 'match_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function match_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'match' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'match' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					$avatar_size = 68;
						if ( '0' != $comment->comment_parent ) {
							$avatar_size = 39;
						}

					echo get_avatar( $comment, $avatar_size );
					?>
					<?php printf( __( '%s <span class="says">says:</span>', 'match' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'match' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'match' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'match' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for match_comment()
