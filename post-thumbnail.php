<?php 
global $post;
if( function_exists('has_post_video') && has_post_video()) {

	the_post_thumbnail();

} elseif (has_post_thumbnail()) {

	if( is_singular(array( 'newsletter', )) ) {
		// newsletter content
		$feature_image_id = get_field('feature_image');
	} else {
		$feature_image_id = get_post_thumbnail_id($post->ID);
	}
	
	the_responsive_image( $feature_image_id, $image_type = 'single-feature', $image_classes = 'wp-post-image post-featured-image', $show_caption = true, $wrap_figure = true );
	
	/*

	$image_caption = get_post($feature_image_id)->post_title;   // Post Title
	$image_credit  = get_post($feature_image_id)->post_excerpt; // "Caption"
	$image_db_alt  = get_post_meta( $feature_image_id, '_wp_attachment_image_alt', true );

	$image_source  = '';
	if( substr($image_db_alt,0,4) == 'http' ) $image_source = $image_db_alt;

	if( !empty($image_caption) && !empty($image_credit) ) {
		$image_alt = $image_caption.' / '.$image_credit;
		if( !empty($image_source) ) { 
			$caption_display = $image_caption.' / <a href="'.$image_source.'" target="_blank">'.$image_credit.'</a>';
		} else {
			$caption_display = $image_alt;
		}
	} elseif( !empty($image_caption) ) {
		$image_alt = $image_caption;
		if( !empty($image_source) ) { 
			$caption_display = $image_caption.' / <a href="'.$image_source.'" target="_blank">credit</a>';
		} else {
			$caption_display = $image_alt;
		}
	} elseif( !empty($image_credit) ) {
		$image_alt = $image_credit;
		if( !empty($image_source) ) { 
			$caption_display = '<a href="'.$image_source.'" target="_blank">'.$image_credit.'</a>';
		} else {
			$caption_display = $image_alt;
		}
	}
	
	echo '<!--'.get_responsive_image($feature_image_id, 'single-feature').'-->';
		
	$image = wp_get_attachment_image_src($feature_image_id, 'full');
	$thumb = wp_get_attachment_image_src($feature_image_id, 'thumbnail-feature');
	
	$feature_image_url = $image[0];
	$feature_thumb_url = $thumb[0];

	// Print preview image
	echo '<figure>';
	//echo '<a style="float: none;width: 100%;" class="image-link image-shortcode full-width-image" rel="prettyPhoto"';
	//echo ' href="'.$feature_image_url.'"';
	//echo ' title="'.$image_alt.'" >';
	echo '<img class="wp-post-image post-featured-image" alt="' . $image_alt . '" src="' . $feature_thumb_url . '" data-fl-original-src="' . $feature_image_url . '"  />';
	//echo '</a>';
	echo '<div class="entry-meta-header text-right" style="margin-top: -1rem;">'.$caption_display.'</div>';
	echo '</figure>';
	
	*/

}
?>