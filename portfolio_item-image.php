<?php
/**
 * Feature image display for portfolio items
 *
 */
?>

<?php $image_id = get_post_thumbnail_id($post->ID); ?>
<?php if( $image_id ) : ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<div class="portfolio_image_container">
			<div class="dummy"></div>
			<div data-content="" class="portfolio_image">
				<?php the_responsive_image( $image_id, $image_type = 'portfolio', $image_classes = 'wp-post-image', $show_caption = false, $wrap_figure = false ); ?>
			</div>
		</div>
	</a>
<?php endif; ?>