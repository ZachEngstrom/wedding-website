<?php
/**
 * @package Match
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php match_post_thumbnail(); ?>

	<header class="entry-header">

		<?php
			$h1_meta_value = get_post_meta( get_the_ID(), 'h1', true );
			if (!isset($h1_meta_value) || $h1_meta_value == '') {
				if (is_front_page()) {
					the_title( '<h2 class="entry-title">', '</h2>' );
				} else {
					the_title( '<h1 class="entry-title">', '</h1>' );
				}
			} else {
				if (is_front_page()) {
					echo '<h2 class="entry-title">'.$h1_meta_value.'</h2>';
				} else {
					echo '<h1 class="entry-title">'.$h1_meta_value.'</h1>';
				}
			}
		?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'match' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta entry-meta-footer">
		<?php edit_post_link( __( 'Edit', 'match' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
