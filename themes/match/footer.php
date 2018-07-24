<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Match
 */

?>

</div> <!-- #page .site-wrapper -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="site-info">
			<div class="container">

				<div class="row">
					<div class="col-12">
						<div class="credits">
							<?php 
								date_default_timezone_set('America/Chicago');
								if (new DateTime() < new DateTime("2018-09-15 16:30:00")) {
									echo '&copy;' . date('Y') . ' Zach Engstrom & Kelley Vanderbeck';
								} else {
									echo '&copy;' . date('Y') . ' Zach & Kelley Engstrom';
								} 
							?>
						</div>
					</div>
				</div>

			</div><!-- .container -->
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>
