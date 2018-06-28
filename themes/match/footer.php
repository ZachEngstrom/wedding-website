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
							<?php echo '&copy;' . date('Y') . ' Zach Engstrom & Kelley Vanderbeck'; ?>
						</div>
					</div>
				</div>

			</div><!-- .container -->
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>
