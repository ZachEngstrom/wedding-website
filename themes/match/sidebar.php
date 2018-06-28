<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Match
 */

$fullwidth_meta_value = get_post_meta( get_the_ID(), 'fullwidth', true );
if ( $fullwidth_meta_value == '0' || $fullwidth_meta_value == '') { // If user has selected "Full Width" page layout, hide sidebar

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 pt-4">

	<div id="secondary" class="sidebar widget-area" role="complementary">

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h2 class="widget-title"><?php _e( 'Archives', 'match' ); ?></h2>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h2 class="widget-title"><?php _e( 'Meta', 'match' ); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>

	</div><!-- #secondary -->
</div><!-- .col-* columns of main sidebar -->

<?php }