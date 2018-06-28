<?php

/*
 * h1 Meta Box
 *
 * To display or not to display, that is the question
 *
 * @link http://themefoundation.com/wordpress-meta-boxes-guide/
 *
 * Usage:
 *    $h1_meta_value = get_post_meta( get_the_ID(), 'h1', true );
 *	  if (!isset($h1_meta_value) || $h1_meta_value == '') {
 *	  	the_title( '<h1 class="entry-title">', '</h1>' );
 *	  } else {
 *	  	echo '<h1 class="entry-title">'.$h1_meta_value.'</h1>';
 *	  }
 */

/**
 * Adds a meta box to the post editing screen
 */
function match_h1_option() {
    add_meta_box( 'h1_option', __( 'Page/Post Title', 'match' ), 'h1_meta_callback', 'post' );
    add_meta_box( 'h1_option', __( 'Page/Post Title', 'match' ), 'h1_meta_callback', 'page' );
}
add_action( 'add_meta_boxes', 'match_h1_option' );

/**
 * Outputs the content of the meta box
 */
function h1_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'match_nonce' );
    $match_stored_meta = get_post_meta( $post->ID );

    $h1_value = $match_stored_meta['h1'][0];

	if ( isset ( $h1_value ) ) { // If value set in database (existing page)

		if ($h1_value == '') { // If database value is empty ?>
			<div>
				<label for="h1-yes" class="screen-reader-text">Title</label>
				<input type="text" name="h1" id="h1-yes" value="" style="width:100%;margin-top:.75rem">
			</div>
		<?php } else { // If database value is set ?>
			<div>
				<label for="h1-yes" class="screen-reader-text">Title</label>
				<input type="text" name="h1" id="h1-yes" value="<?php echo $h1_value; ?>" style="width:100%;margin-top:.75rem">
			</div>
		<?php }
	} else {  // If value is NOT set in database (new page/post) ?>
		<div>
			<label for="h1-yes" class="screen-reader-text">Title</label>
			<input type="text" name="h1" id="h1-yes" value="" style="width:100%;margin-top:.75rem">
		</div>
	<?php } ?>

	<p class="howto">Overwrite the default page title here.</p>

	<?php }

/**
 * Saves the custom meta input
 */
function h1_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'match_nonce' ] ) && wp_verify_nonce( $_POST[ 'match_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'h1' ] ) ) {
        update_post_meta( $post_id, 'h1', sanitize_text_field( $_POST[ 'h1' ] ) );
    }

}
add_action( 'save_post', 'h1_meta_save', 1 );
