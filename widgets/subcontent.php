<?php
function pax_resize_image($preview_image_url) {
	global $prime_frontend;

	// See if image resize has been turned on
	$image_resize = true; //get_prime_options('blog_image_resize') == 'Enable';

	// Determine the appropriate width and height
	if (PRIME_MOBILE_LAYOUT_BEHAVIOR == PrimeMobileLayoutBehavior::OnMobileDevices && !is_mobile_device()) {
		$width = 330;
		$height = 216;
	} elseif (PRIME_MOBILE_LAYOUT_BEHAVIOR == PrimeMobileLayoutBehavior::OnMobileDevices && is_mobile_device()) {
		$width = 440;
		$height = 272;
	} elseif (PRIME_MOBILE_LAYOUT_BEHAVIOR == PrimeMobileLayoutBehavior::OnSmallWindows) {
		$width = 440;
		$height = 272;
	} else {
		$width = 330;
		$height = 216;
	}

	// If ImageResize is enabled, get the resized image
	if ($image_resize) {
		$preview_image_url = $prime_frontend->get_resized_image_url($preview_image_url, $width, $height);
	}
	
	return $preview_image_url;
}


global $post, $display_post_type;

$widget_name  = 'subcontent';
$widget_title = 'Subcontent';
$flexible_field_name = 'subcontent';

$rows = get_field($flexible_field_name);
$row_count = count($rows);
if($row_count > 0) :
?>
</div>
<div class="page-content page-content-with-sidebar page-content-with-right-sidebar blog-medium-image">

<?php

	$subcontent_nodes = array();
	while(has_sub_field($flexible_field_name)) : 
		$this_id = 0;
		$this_excerpt = '';
		if (get_row_layout() == 'nondirectory_content') {
			// non-directory content
			$this_title = get_sub_field('prefix').': '.get_sub_field('title');
			$this_link = get_sub_field('URL');
			$this_excerpt = get_sub_field('excerpt');
			$this_image = wp_get_attachment_image_src(get_sub_field('image'), 'thumbnail-blog');
		} else {
			// project, organization, person, opportunity
			$this_obj   = get_sub_field('directory_obj');
			$this_id    = $this_obj->ID;
			$this_title = get_the_title( $this_id );
 			$this_link  = get_permalink( $this_id );
			$this_excerpt = ( get_sub_field('excerpt_override') != '' ? get_sub_field('excerpt_override') : get_the_excerpt($this_id) );
			$this_image = wp_get_attachment_image_src(get_post_thumbnail_id($this_id), 'thumbnail-blog');
		}
		$preview_image_url = pax_resize_image($this_image[0]);
		
		$subcontent_nodes[] = array(
			'id'			=> $this_id,
			'title'			=> $this_title,
			'link'			=> $this_link,
			'excerpt'		=> $this_excerpt,
			'image_url'		=> $preview_image_url,
		);
		//print_r($subcontent_nodes);
	endwhile;
	
	$i = 1;
	$node_count = count($subcontent_nodes);
	foreach( $subcontent_nodes as $subcontent_node ) :
		$the_id		 = $subcontent_node['id'];
		$the_title	 = $subcontent_node['title'];
		$the_link	 = $subcontent_node['link'];
		$the_excerpt = $subcontent_node['excerpt'];
		$the_preview_image_url = $subcontent_node['image_url'];
?>

<div class="post-preview <?php if( $the_preview_image_url != '' ) echo 'has-preview-image'; ?>">
	<?php if( $the_preview_image_url != '' ) : ?>
		<a class="image-link" href="<?php echo $the_link; ?>">
			<!--<span class="overlay-thumbnail btn"><i class="icon-link"></i></span>-->
			<img src="<?php echo $the_preview_image_url; ?>" class="post-preview-image">
		</a>
	<?php endif; ?>
	<div class="post-preview-heading">
		<h2 class="post-title">
			<a href="<?php echo $the_link; ?>"><?php echo $the_title; ?></a>
		</h2>
		<p class="post-meta"></p>
    </div>	

    <div class="post-content">
        <?php echo $the_excerpt; ?>
		<?php if( $the_id != 0 ) : ?>
			<p><a href="<?php echo $the_link; ?>">read more</a></p>
		<?php endif; ?>
	</div>

    <div class="clear"></div>	

</div>

<?php
	endforeach;
?>

</div>
<div class="page-content page-content-with-sidebar page-content-with-right-sidebar">

<?php endif; ?>
