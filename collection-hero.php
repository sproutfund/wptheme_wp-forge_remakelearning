<?php $hero_image_id = get_sub_field('hero_image'); ?>
<?php if( $hero_image_id ) : ?>
<div class="row collection-hero" style="padding-bottom:0.5rem;">
	<div class="columns medium-6 <?php if( get_sub_field('hero_image_position') == 'right' ) echo 'medium-push-6'; ?>">
		<?php if( get_sub_field('hero_overlay') == 'none' ) : ?>
			<?php the_responsive_image( $hero_image_id, $image_type = 'collection-hero', $image_classes = '', $show_caption = false, $wrap_figure = true ); ?>
		<?php else : ?>
			<?php 
				$hero_rand = rand(10000000, 99999999); 
				switch( get_sub_field('hero_overlay') ) {
					case 'video' :
						$hero_overlay_icon = '';
						break;
					case 'slideshow' :
						$hero_overlay_icon = '';
						break;
					case 'audio' :
						$hero_overlay_icon = '';
						break;
				}
			?>
			<figure class="collection-hero">
				<a href="#" data-reveal-id="heroModal_<?php echo $hero_rand; ?>">
					<?php the_responsive_image( $hero_image_id, $image_type = 'collection-hero', $image_classes = '', $show_caption = false, $wrap_figure = false ); ?>
					<div class="hero-modal-overlay">
						<span class="hero-modal-overlay-icon"><?php echo $hero_overlay_icon; ?></span>
					</div>
				</a>
			</figure>
			<div id="heroModal_<?php echo $hero_rand; ?>" class="reveal-modal large" data-reveal="">
				<?php echo get_sub_field('hero_modal'); ?>
				<p><a class="close-reveal-modal">×</a></p>
			</div>
		<?php endif; ?>
	</div>
	<div class="columns entry-content medium-6 <?php if( get_sub_field('hero_image_position') == 'right' ) echo 'medium-pull-6'; ?>">
<?php else : ?>
<div class="row">
	<div class="columns entry-content">
<?php endif; ?>
	<?php if( get_sub_field('heading')     ) echo '<h3>'.get_sub_field('heading').'</h3>'; ?>
	<?php if( get_sub_field('description') ) echo wpautop(get_sub_field('description'));   ?>
	</div> <!--end .columns -->
</div> <!-- end .row -->