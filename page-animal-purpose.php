<?php
/**
 * The book page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package michelle-y-burke
 */

get_header(); ?>
<?php 
$customFields = get_post_custom();
$reformatted_date = "";
$order_from_values = [];

foreach ($customFields as $key => $value) {
	if ($key == "Order From") {
		foreach ($value as $order_from) {
			$order_from_exploded = explode("|", $order_from);
			array_push($order_from_values, $order_from_exploded);
		}
	} elseif ($key == "On Sale") {
		$date = strtotime($value[0]);
		if ($date > time()) {
			$reformatted_date = date("F d", $date);
		} else {
			$reformatted_date = "Now";
		}
	}
}
?>
	<div class="book-hero">
		<div class="book-hero-content">
			<div class="book-hero-title">
				<img src="<?php echo get_template_directory_uri() ?>/images/animal-purpose.svg" alt="Animal Purpose Poems" />
			</div>
			<div class="book-hero-photo">
				<img src="<?php echo get_template_directory_uri() ?>/images/book-hero-image.png" alt="" />
			</div>
			<div class="book-hero-details">
				<div class="book-availability"><span>Available</span> <?php echo $reformatted_date; ?></div>
				<div class="order-from">Order from:</div>

				<?php foreach ($order_from_values as $order_from_value) { ?>
				<a class="btn btn-hero" href="<?php echo $order_from_value[1]; ?>">
					<?php echo $order_from_value[0]; ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-book-page" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
