<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Match
 */

get_header();

$fullwidth_meta_value = get_post_meta( get_the_ID(), 'fullwidth', true ); ?>

<div id="content" class="site-content">

	<div class="container">
		<div class="row">

			<?php

			if ( $fullwidth_meta_value == '0' || $fullwidth_meta_value == '') { // If user has selected "Not Full Width" page layout, display sidebar
				echo '<div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12 col-lg-8">';
			} else { // If user has selected "Full Width" page layout, hide sidebar
				echo '<div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			}

			?>

				<main id="main" class="site-main my-4" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/*
						* Are we using a post format? If so, use the content-someformat.php template.
						* If not, use the content-single.php template.
						*/
						$format = ( '' != get_post_format() ) ? get_post_format() : 'single';
						get_template_part( 'template-parts/content', $format );
					?>

					<?php match_the_post_pagination(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- .container -->

</div><!-- #content -->

<?php get_footer(); ?>
