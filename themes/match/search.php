<?php
/**
 * The template for displaying Search Results pages.
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

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'match' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php match_the_posts_pagination(); ?>

				<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- .container -->

</div><!-- #content -->

<?php get_footer(); ?>
