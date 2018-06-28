<?php
/**
 * The template for displaying search forms in match
 *
 * @package Match
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="row">
		<div class="col-12">
			<label for="s" class="sr-only">Search</label>
			<div class="input-group">
				<input type="text" class="form-control" id="s" name="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'match' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<div class="input-group-append">
					<button type="submit" class="input-group-text">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</div>
    </div>
</form>