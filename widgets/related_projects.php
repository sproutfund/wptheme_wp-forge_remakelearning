<?php
global $post, $display_post_type;

$widget_name  = 'related_projects';
$widget_title = 'Related Projects';
$acf_group = array(114);
$relationship_field_name = 'related_project';
$edit_link = NULL;

if ( current_user_can('edit_post', $post->ID) ) {
	$edit_box  = '&TB_iframe=true&width=910&height=600';
	if( isset($relationship_field_name) ) {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&acf_field='.$relationship_field_name.'&edit_id='.$post->ID.$edit_box;
	} else {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&edit_id='.$post->ID.$edit_box;
	}
	$edit_text = 'Edit '.ucwords($display_post_type).' '.$widget_title;
	$edit_link = '<a href="'.$edit_href.'" class="thickbox" title="<b>'.$edit_text.'</b> '.get_the_title().'"><i class="icon-edit"></i></a>';
}

$raw_relationships = get_field($relationship_field_name);
$relationships = array();
foreach( $raw_relationships as $post_object ) {
	if( $post_object->post_status === 'publish' ) {
		$relationships[] = $post_object;
	}
}
$row_count = count($relationships);
if ($row_count > 0) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	$i = 1;
	foreach($relationships as $post_object) {
		$post_id       = $post_object->ID;
		$post_name     = $post_object->post_title;
		$post_title    = $post_name;
		$post_subtitle = get_field('summary_statement',$post_id);
		$post_link     = _sidebar_post_object_link($post_id, $post_title, $post_subtitle, '<br/>');
		echo "<p>$post_link</p>";
		if ($i < $row_count) {
			echo '<div class="divider shortcode-divider thick"></div>';
			$i++;
		}
	}

	sprout_sidebar_text_widget_close();

endif;
?>