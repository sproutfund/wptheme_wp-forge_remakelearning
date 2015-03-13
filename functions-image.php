<?php

function get_image_caption( $image_id ) {

	$image_caption = get_post($image_id)->post_title;
	$image_credit  = get_post($image_id)->post_excerpt;
	$image_db_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	$image_source  = '';
	$image_alt     = '';
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
	if( empty($image_alt) ) $image_alt = $image_db_alt;
	
	return array(
		'display' => $caption_display,
		'title'   => $image_caption,
		'credit'  => $image_credit,
		'source'  => $image_source,
		'alt'     => $image_alt,
	);

}

/*
	add_image_size( 'thumbnail-90px',      90,   90, true ); // "thumbnail" / mini-square
	add_image_size( 'thumbnail-120px',    120,   80, true ); // front-page-more-blog-posts
	add_image_size( 'thumbnail-180px',    180,  120, true ); // small portfolio
	add_image_size( 'thumbnail-240px',    240,  160, true ); // 
	add_image_size( 'thumbnail-360px',    360,  240, true ); // small collection-hero, small single-feature, small retina portfolio
	add_image_size( 'thumbnail-480px',    480,  320, true ); // front-page-opportunities
	add_image_size( 'thumbnail-600px',    600,  400, true ); // collection hero 
	add_image_size( 'thumbnail-720px',    720,  480, true ); // small retina collection-hero
	add_image_size( 'thumbnail-900px',    900,  600, true ); // "large" & single feature image
	add_image_size( 'thumbnail-1200px',  1200,  800, true ); // 2x collection hero
	add_image_size( 'thumbnail-1800px',  1800, 1200, true ); // 2x "large"& single feature image
*/

if( !function_exists('get_responsive_image') ) {

	function get_responsive_image( $image_id, $image_type = 'single-feature', $image_classes = '', $show_caption = true, $wrap_figure = true ) {

		$responsive_sizes = array(
			'small' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-180px',
				'collection-hero' => 'thumbnail-360px',
				'single-feature'  => 'thumbnail-360px',),
			'small retina' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-360px',
				'collection-hero' => 'thumbnail-720px',
				'single-feature'  => 'thumbnail-720px',),
			'medium' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-180px',
				'collection-hero' => 'thumbnail-360px',
				'single-feature'  => 'thumbnail-600px',),
			'medium retina' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-360px',
				'collection-hero' => 'thumbnail-720px',
				'single-feature'  => 'thumbnail-1200px',),
			'large' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-360px',
				'collection-hero' => 'thumbnail-600px',
				'single-feature'  => 'thumbnail-900px',),
			'large retina' => array(
				'miniature'       => 'thumbnail-180px',
				'portfolio'       => 'thumbnail-720px',
				'collection-hero' => 'thumbnail-1200px',
				'single-feature'  => 'thumbnail-1800px',),
		);
		
		$image_data           = wp_get_attachment_metadata( $image_id );
		$image_default        = wp_get_attachment_image_src( $image_id, 'medium' ); //medium size specified by WP--not the medium responsive size
		$image_default_url    = $image_default[0];

		$image_responsive_urls = array();
		foreach( $responsive_sizes as $responsive_size => $thumbnails ) {
			if( !empty($image_data['sizes'][$thumbnails[$image_type]]['file']) ) {
				$thumbnail = wp_get_attachment_image_src( $image_id, $thumbnails[$image_type] );
				$image_responsive_urls[$responsive_size] = $thumbnail[0];
			}
		}

		$data_interchange  = '['.$image_default_url.' (default)]';
		foreach( $image_responsive_urls as $image_responsive_size => $image_responsive_url ) {
			$data_interchange .= ', ['.$image_responsive_url.' ('.$image_responsive_size.')]';
		}
		
		$image_caption = get_image_caption( $image_id );
		
		$return_value  = '';
		if( $wrap_figure ) $return_value .= '<figure class="'.$image_type.'">';		
		$return_value .= '<img alt="'.$image_caption['alt'].'" class="'.$image_type.' '.$image_classes.'" data-interchange="'.$data_interchange.'" />';
		$return_value .= '<noscript><img src="'.$image_default_url.'" /></noscript>';
		if( $show_caption && !empty($image_caption['display']) ) $return_value .= '<figcaption>'.$image_caption['display'].'</figcaption>';
		if( $wrap_figure ) $return_value .= '</figure>';  
		
		return $return_value;
	}


	function the_responsive_image( $image_id, $image_type = 'single-feature', $image_classes = '', $show_caption = true, $wrap_figure = true ) {
		echo apply_filters( 'the_responsive_image', get_responsive_image($image_id, $image_type, $image_classes, $show_caption, $wrap_figure) );
	}
}

?>

