<?php
/**
 * Display posts as list items of a portfolio
 *
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part( 'portfolio_item', 'image' ); ?>
		<?php get_template_part( 'portfolio_item', 'title' ); ?>
	</header><!-- .entry-header -->
	<?php get_template_part( 'portfolio_item', 'summary_stmt' ); ?>
</li><!-- #post -->