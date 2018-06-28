<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Match
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>
<?php

global $post;
$pagepostSlug = $post->post_name;
if (is_single()) {
	$bodyClassSlug = 'post-'.$pagepostSlug;
} else if (is_page()) {
	$bodyClassSlug = 'page-'.$pagepostSlug;
} else {
	$bodyClassSlug = 'other-'.$pagepostSlug;
}

?>
<body <?php body_class($bodyClassSlug); ?>>
<div id="page" class="site-wrapper site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">

		<div class="sitebar">
			<div class="container">
				<div class="sitebar-inside">

					<div class="site-branding">
						<?php

							if (is_front_page()) {
								echo '<h1 class="site-title"><a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'. get_bloginfo( 'name' ) .'</a></h1>';
							} else {
								echo '<div class="site-title"><a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'. get_bloginfo( 'name' ) .'</a></div>';
							}

						?>
						<?php if (get_option('display_tagline') == '1'): ?>
						<h3 class="site-description"><?php bloginfo( 'description' ); ?></h3>
						<?php endif;

						if (get_option('wedding_date_time_epoch') != '') { // if option wedding_date_time_epoch is set, echo weddingCountdown string
							$remaining = get_option('wedding_date_time_epoch') - time();
							$days_remaining = floor($remaining / 86400);
							$hours_remaining = floor(($remaining % 86400) / 3600);
							if ($hours_remaining == 0) { // if hours_remaining is 0, set it to blank
								$hours_remaining = '';
							} else if ($hours_remaining == 1) { // if hours_remaining is 1, say "hour"
								$hours_remaining = ' and '.$hours_remaining.' hour';
							} else { // if hours_remaining > 1, say "hours"
								$hours_remaining = ' and '.$hours_remaining.' hours';
							}
							if ($days_remaining < 1) { // if days_remaining < 1, today is the big day!
								$weddingCountdown = '<span class="display-4">Today is the <span class="font-weight-bold text-uppercase">big day</span>!!!</span>';
							} else { // if days_remaining < 1, today is the big day!
								$weddingCountdown = 'There are '.$days_remaining.' days '.$hours_remaining.' left until the wedding!';
							}
							echo '<p class="h5 wedding-countdown">'.$weddingCountdown.'</p>';
						}

						?>

					</div>

					<nav id="site-navigation" class="main-navigation" role="navigation">
						<div class="menu-toggle-wrapper">
							<a href="#" tabindex="0" class="fa fa-bars fa-2x slicknav-btn slicknav-collapsed"><span class="slicknav-btn-text">Menu</span></a>
						</div>
						<a class="skip-link sr-only" href="#content"><?php _e( 'Skip to content', 'match' ); ?></a>

						<?php
						wp_nav_menu( apply_filters( 'match_wp_nav_menu_args', array(
							'container'       => 'div',
							'container_class' => 'site-primary-menu',
							'theme_location'  => 'primary',
							'menu_class'      => 'primary-menu sf-menu',
							'depth'           => 3,
						) ) );
						?>
					</nav>

				</div>
			</div>
		</div> <!-- .sitebar -->

		<?php if ( get_header_image() && is_front_page() ): ?>
		<div class="header-custom">
			<img src="<?php esc_url( header_image() ); ?>" class="img-responsive" alt="" />
		</div>
		<?php endif; ?>

	</header> <!-- #masthead -->
