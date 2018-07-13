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
<?php
$description_box_value = get_post_meta( get_the_ID(), 'descriptionBox', true );
if (!isset($description_box_value) || $description_box_value == '') {
 // do nothingget_the_excerpt
//echo '<meta name="description" content="'.get_the_excerpt().'">';
	if(is_singular()) {       
        global $wp_query;
        $post = $wp_query->post;
        $page_id = $post->ID;
        $page_object = get_page( $page_id );
		$content = wp_trim_words($page_object->post_content,300);
		$content = preg_replace_callback(
			"/\[.*?\]/",
			function($matches){
				foreach($matches as $match){
					return '';
				}
			}, 
			$content
		);
		if (!empty($content)){
			$output="<meta name='description' content='".$content."'>";
			echo $output;
		}
    }
} else {
echo '<meta name="description" content="'.$description_box_value.'">';
}
?>

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

							$date1 = date_create(date("Y/m/d H:i:s")); // current date and time
							$dateEndFromDB = date("Y-m-d H:i:s", substr(get_option('wedding_date_time_epoch'), 0, 10)); // get epoch date from database and format it for date_diff()
							$date2 = date_create($dateEndFromDB); // date and time of event
							$diff = date_diff($date1,$date2); // diff date1 and date2
							// if year > 1 = years, if year == 1 = year, if year < 1 = [blank]
							$year = $diff->y == '1' ? $diff->y.' year ' : $diff->y.' years ';
							$year = $year == '0 years ' ? '' : $year;
							// if month > 1 = months, if month == 1 = month, if month < 1 = [blank]
							$month = $diff->m == '1' ? $diff->m.' month ' : $diff->m.' months ';
							$month = $month == '0 months ' ? '' : $month;
							// if day > 1 = days, if day == 1 = day, if day < 1 = [blank]
							$day = $diff->d == '1' ? $diff->d.' day ' : $diff->d.' days ';
							$day = $day == '0 days ' ? '' : $day;
							// if hour > 1 = hours, if hour == 1 = hour, if hour < 1 = [blank]
							$hour = $diff->h == '1' ? $diff->h.' hour ' : $diff->h.' hours ';
							$hour = $hour == '0 hours ' ? '' : $hour;
							// if min > 1 = minutes, if min == 1 = minute, if min < 1 = [blank]
							$min = $diff->i == '1' ? $diff->i.' minute ' : $diff->i.' minutes ';
							$min = $min == '0 minutes ' ? '' : $min;
							// put it all together
							$timeString = $year . $month . $day . $hour /*. $min*/;
							// if time left starts with > 1 then "There are ", if time left starts with 1 then "There is "
							$sentanceStart = $timeString[0] > 1 ? 'There are ' : 'There is ';

							// If before event = countdown, if after event = time since
							$eventTimeString = $diff->invert == '0' ? '<p class="wedding-countdown">'.$sentanceStart.'<strong>'.$timeString.'</strong> until the wedding!</p>' : '<p>It\'s been <strong>'.$timeString.'</strong> since the wedding.';
							// output
							echo $eventTimeString;

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
