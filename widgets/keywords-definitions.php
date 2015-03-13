<?php
global $post, $display_post_type;

$widget_name  = 'keywords_definitions';
$widget_title = 'Keywords / Definitions';
$acf_group = array(12196);
$flexible_field_name = 'keywords';
$edit_link = NULL;

if ( current_user_can('edit_post', $post->ID) ) {
	$edit_box  = '&TB_iframe=true&width=910&height=600';
	if( isset($flexible_field_name) ) {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&acf_field='.$flexible_field_name.'&edit_id='.$post->ID.$edit_box;
	} else {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&edit_id='.$post->ID.$edit_box;
	}
	$edit_text = 'Edit '.ucwords($display_post_type).' '.$widget_title;
	$edit_link = '<a href="'.$edit_href.'" class="thickbox" title="<b>'.$edit_text.'</b> '.get_the_title().'"><i class="icon-edit"></i></a>';
}

$rows = get_field($flexible_field_name);
$row_count = count($rows);
if($row_count > 0) :

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';

	while(has_sub_field('keywords')) : 
		echo '<li class="icon-chevron-right"><b>'.get_sub_field('keyword').'</b> : '.get_sub_field('definition').'</li>';
	endwhile;


	echo '</ul>';

	sprout_sidebar_text_widget_close();

endif;
?>