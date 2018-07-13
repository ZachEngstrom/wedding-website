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
function match_description_box() {
    add_meta_box( 'description_box', __( 'Page/Post Description', 'match' ), 'description_box_callback', 'post' );
    add_meta_box( 'description_box', __( 'Page/Post Description', 'match' ), 'description_box_callback', 'page' );
}
add_action( 'add_meta_boxes', 'match_description_box', 100 );

/**
 * Outputs the content of the meta box
 */
function description_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'match_nonce' );
    $match_stored_meta = get_post_meta( $post->ID );

    $description_value = $match_stored_meta['descriptionBox'][0];

	if ( isset ( $description_value ) ) { // If value set in database (existing page)

		if ($description_value == '') { // If database value is empty ?>
			<div>
				<label for="description-yes" class="screen-reader-text">Title</label>
				<!--input type="text" name="description" id="description-yes" value="" style="width:100%;margin-top:.75rem" maxlength="300"-->
				<textarea name="descriptionBox" id="description-yes" style="width:100%;margin-top:.75rem" rows="5"></textarea>
			</div>
		<?php } else { // If database value is set ?>
			<div>
				<label for="description-yes" class="screen-reader-text">Title</label>
				<!--input type="text" name="descriptionBox" id="description-yes" value="<?php echo $description_value; ?>" style="width:100%;margin-top:.75rem" maxlength="300"-->
				<textarea name="descriptionBox" id="description-yes" style="width:100%;margin-top:.75rem" rows="5"><?php echo $description_value; ?></textarea>
			</div>
		<?php }
	} else {  // If value is NOT set in database (new page/post) ?>
		<div>
			<label for="description-yes" class="screen-reader-text">Title</label>
			<!--input type="text" name="descriptionBox" id="description-yes" value="" style="width:100%;margin-top:.75rem" maxlength="300"-->
			<textarea name="descriptionBox" id="description-yes" style="width:100%;margin-top:.75rem" rows="5"></textarea>
		</div>
	<?php } ?>

	<p class="howto">Set page description here.</p>



	<?php }

/**
 * Saves the custom meta input
 */
function description_box_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'match_nonce' ] ) && wp_verify_nonce( $_POST[ 'match_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'descriptionBox' ] ) ) {
        update_post_meta( $post_id, 'descriptionBox', sanitize_text_field( $_POST[ 'descriptionBox' ] ) );
    }

}
add_action( 'save_post', 'description_box_save', 1 );
