<?php

/*
 * Full Width Options
 *
 * To display or not to display, that is the question
 *
 * @link http://themefoundation.com/wordpress-meta-boxes-guide/
 *
 * Usage:
 *    $fullwidth_meta_value = get_post_meta( get_the_ID(), 'fullwidth', true );
 *    if ( $fullwidth_meta_value == '0') { echo "Don't Display.";}
 *    elseif ( $fullwidth_meta_value == '1') { echo "Display!";}
 *    else { echo "Something Else...";}
*/

/**
 * Adds a meta box to the post editing screen
 */
function match_fullwidth_option() {
    add_meta_box( 'fullwidth_option', __( 'Full Width', 'match' ), 'fullwidth_meta_callback', 'page', 'side' );
    add_meta_box( 'fullwidth_option', __( 'Full Width', 'match' ), 'fullwidth_meta_callback', 'post', 'side' );
}
add_action( 'add_meta_boxes', 'match_fullwidth_option' );

/**
 * Outputs the content of the meta box
 */
function fullwidth_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'match_nonce' );
    $match_stored_meta = get_post_meta( $post->ID );

	if ( isset ( $match_stored_meta['fullwidth'] ) ) { // If value set in database (existing page)
		$fullwidth_value = $match_stored_meta['fullwidth'][0];
		if ($fullwidth_value != '0') { // If database value set to "Display" then select "Display" ?>
			<div>
				<label for="fullwidth-yes">
					<input type="radio" name="fullwidth" id="fullwidth-yes" value="1" checked="checked">
					<?php _e( '<strong>Full Width</strong> (No Right Rail)', 'match' )?>
				</label>
			</div>
			<div>
				<label for="fullwidth-no">
					<input type="radio" name="fullwidth" id="fullwidth-no" value="0">
					<?php _e( '<strong>Not Full Width</strong> (Default)', 'match' )?>
				</label>
			</div>
		<?php } else { // If database value set to "Do Not Display" then select "Do Not Display" ?>
			<div>
				<label for="fullwidth-yes">
					<input type="radio" name="fullwidth" id="fullwidth-yes" value="1">
					<?php _e( '<strong>Full Width</strong> (No Right Rail)', 'match' )?>
				</label>
			</div>
			<div>
				<label for="fullwidth-no">
					<input type="radio" name="fullwidth" id="fullwidth-no" value="0" checked="checked">
					<?php _e( '<strong>Not Full Width</strong> (Default)', 'match' )?>
				</label>
			</div>
		<?php }
	} else {  // If value NOT set in database (new page) then select "Display" by default ?>
		<div>
			<label for="fullwidth-yes">
				<input type="radio" name="fullwidth" id="fullwidth-yes" value="1">
				<?php _e( '<strong>Full Width</strong> (No Right Rail)', 'match' )?>
			</label>
		</div>
		<div>
			<label for="fullwidth-no">
				<input type="radio" name="fullwidth" id="fullwidth-no" value="0" checked="checked">
				<?php _e( '<strong>Not Full Width</strong> (Default)', 'match' )?>
			</label>
		</div>
	<?php } ?>

	<p>Please select whether or not the layout for this particular page/post is full width.</p>

	<?php }

/**
 * Saves the custom meta input
 */
function fullwidth_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'match_nonce' ] ) && wp_verify_nonce( $_POST[ 'match_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'fullwidth' ] ) ) {
        update_post_meta( $post_id, 'fullwidth', sanitize_text_field( $_POST[ 'fullwidth' ] ) );
    }

}
add_action( 'save_post', 'fullwidth_meta_save' );
