<?php

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function match_widgets_init() {

	// Widget Areas
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'match' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'match_widgets_init' );