<?php

/*
 * Blog List Shortcode Declaration
 * @link https://upthemes.com/blog/2011/07/how-to-build-a-custom-page-template-for-blog-posts/
 * [postslist]
 */
function matchchild_shortcode_postslist($atts, $content=null) {

    $atts = shortcode_atts( array(
			"perpage"   => false
	), $atts );

    if ($atts['perpage'] != '' && is_numeric($atts['perpage'])) {
    	$perpage = $atts['perpage'];
    } else {
    	$perpage = '10';
    }

	query_posts('post_type=post&post_status=publish&posts_per_page='.$perpage.'&paged='. get_query_var('paged'));

	$output = '<hr><div id="blog-list">';

	// If POSTS exist, render them as list items
	if (have_posts()) {
		while (have_posts()) {
			the_post();

			$output .= '<div id="post-' . get_the_ID() . '" class="row">
				 	<div class="col-md-3 col-sm-4 col-xs-12 post-thumb">
				 		<a href="' . get_permalink().'">';

 			if ( has_post_thumbnail() ) {
 				$output .= get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'img-responsive' ) );
 			} else {
 				// echo get_avatar( get_the_author_meta( 'ID' ), 300 );
 				$output .= '<img src="' . esc_url(get_template_directory_uri()) . '/images/header-default-thumb.jpg" class="img-responsive" alt="Blue Cross and Blue Shield of Minnesota Logo">';
 			}

 			if (get_comments_number() == '1') {
 				$get_comments_text = ' comment';
 			} else {
 				$get_comments_text = ' comments';
 			}

 			$output .= '</a>
			 	</div>
			 	<div class="col-md-9 col-sm-8 col-xs-12 post-excerpt">
			 		<h2 class="h3"><a href="'. get_permalink().'">'. get_the_title().'</a></h2>
			 		<p class="text-muted">'. get_the_time('F j, Y').' | <a href="'.get_comments_link().'">'.get_comments_number().$get_comments_text.'</a></p>
			 		<div class="rich-text-container">
			 			'. get_the_excerpt().'
			 		</div>
			 	</div>
			</div>
			<hr>';

		}

			$output .= '<div class="text-center">
		        <nav aria-label="Page Navigation">
					<ul class="pagination">
						<li>'. get_previous_posts_link(__('<i class="fa fa-angle-double-left" aria-hidden="true"></i><span class="sr-only">Previous</span>','match')) .' </li>
						<li>'. get_next_posts_link(__('<i class="fa fa-angle-double-right" aria-hidden="true"></i><span class="sr-only">Next</span>','match')) .'</li>
					</ul>
				</nav>
			</div>';

	} else {

		$output .= '<div id="post-404" class="noposts"><p>'. _e('No posts found.','match').'</p></div><!-- /#post-404 -->';

	}

	wp_reset_query();

	$output .= '</div>';

	return $output;

}
add_shortcode('postslist', 'matchchild_shortcode_postslist');




/**************************************************************************************************
 *     *     *     *     *     *     *     Usage Examples     *     *     *     *     *     *     *
 **************************************************************************************************/




/*
 * Standard
 * No parameters
 *

	[postslist]

*/




/*
 * Per Page - how many posts to list per page (defaults to 10)
 * Pass perpage="" through the "postslist" shortcode
 *

	[postslist perpage="15"]

*/
