<?php if( get_row_layout() == 'nondirectory_content' ) : ?>
	<li>
		<header class="entry-header">
			<?php $image_id = get_sub_field('image'); ?>
			<?php if( $image_id ) : ?>
				<a href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('title'); ?>" target="_blank">
					<div class="portfolio_image_container">
						<div class="dummy"></div>
						<div data-content="" class="portfolio_image">
							<?php the_responsive_image( $image_id, $image_type = 'portfolio', $image_classes = 'wp-post-image', $show_caption = false, $wrap_figure = false ); ?>
						</div>
					</div>
				</a>
			<?php endif; ?>
			<p class="entry-title">
				<a href="<?php the_sub_field('url'); ?>" target="_blank"><?php the_sub_field('title'); ?></a>
			</p>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_sub_field('summary_stmt'); ?>			
		</div><!-- .entry-summary -->

	</li><!-- #post -->
<?php else : ?>
<?php
	$post_type   = get_sub_field('post_type');
	$post_object = get_sub_field($post_type.'_id');
	if( $post_object ) :
		$post = $post_object;
		setup_postdata( $post );
?>
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		
			<?php if( get_sub_field('image') ) : ?>
				<?php $image_id = get_sub_field('image'); ?>
				<?php if( $image_id ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="portfolio_image_container">
							<div class="dummy"></div>
							<div data-content="" class="portfolio_image">
								<?php the_responsive_image( $image_id, $image_type = 'portfolio', $image_classes = 'wp-post-image', $show_caption = false, $wrap_figure = false ); ?>
							</div>
						</div>
					</a>
				<?php else : ?>
					<?php get_template_part( 'portfolio_item', 'image' ); ?>
				<?php endif; ?>
			<?php else : ?>
				<?php get_template_part( 'portfolio_item', 'image' ); ?>
			<?php endif; ?>
			
			<?php if( get_sub_field('title') ) : ?>
				<p class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_sub_field('title'); ?></a>
				</p>
			<?php else : ?>
				<?php get_template_part( 'portfolio_item', 'title' ); ?>
			<?php endif; ?>
			
		</header><!-- .entry-header -->

		<?php if( get_sub_field('summary_stmt') ) : ?>
			<div class="entry-summary">
				<?php echo get_sub_field('summary_stmt'); ?>		
			</div><!-- .entry-summary -->
		<?php else : ?>
			<?php get_template_part( 'portfolio_item', 'summary_stmt' ); ?>
		<?php endif; ?>

	</li><!-- #post -->
<?php
			wp_reset_postdata();
		endif;
	endif;
?>