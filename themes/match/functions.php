<?php
/**
 * Match functions and definitions
 *
 * @package Match
 */

/**
 * Match Theme Setup File
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Set content width
 */
require get_template_directory() . '/inc/content-width.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Styles & Scripts
 */
require get_template_directory() . '/inc/styles-scripts.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/******************************************************************************
 *
 * Custom Functions
 *
 *****************************************************************************/

/**
 * HTML Minifier
 */
require get_template_directory() . '/inc/html-minifier.php';

/**
 * Image Class
 */
require get_template_directory() . '/inc/image-class.php';

/**
 * Custom Meta Boxes
 */
require get_template_directory() . '/inc/metabox-description.php';
require get_template_directory() . '/inc/metabox-fullwidth.php';
require get_template_directory() . '/inc/metabox-h1.php';

/**
 * Custom Shortcodes
 */
require get_template_directory() . '/inc/shortcode-button.php';
require get_template_directory() . '/inc/shortcode-dummy-image.php';
require get_template_directory() . '/inc/shortcode-grid.php';
require get_template_directory() . '/inc/shortcode-grid-wrapper.php';
require get_template_directory() . '/inc/shortcode-postslist.php';
require get_template_directory() . '/inc/shortcode-rsvpform.php';
require get_template_directory() . '/inc/shortcode-timeline.php';
require get_template_directory() . '/inc/shortcode-weddingparty.php';

/**
 * Custom Settings
 */
require get_template_directory() . '/inc/theme-settings/settings.php';
require get_template_directory() . '/inc/theme-settings/timeline.php';
require get_template_directory() . '/inc/theme-settings/weddingparty.php';
require get_template_directory() . '/inc/theme-settings/weddingparty-add.php';
require get_template_directory() . '/inc/theme-settings/weddingparty-edit.php';
require get_template_directory() . '/inc/theme-settings/weddingparty-delete.php';

/**
 * Title Separator
 */
require get_template_directory() . '/inc/title-separator.php';