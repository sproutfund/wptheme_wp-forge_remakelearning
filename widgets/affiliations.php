<?php
global $post, $display_post_type;

$widget_name  = 'affiliations';
$widget_title = 'Affiliations';
$acf_group = array(13);
$flexible_field_name = 'employment';
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

	$i = 1;
	while(has_sub_field($flexible_field_name)) :
		$this_id = 0;
		$this_name = '';
		if (get_row_layout() == 'network_member') {
			$this_obj = get_sub_field('member_obj');
			$this_id = $this_obj->ID;
			$this_name = get_the_title($this_id);
		} elseif (get_row_layout() == 'external_contact') {
			$this_name = get_sub_field('external_name');
		}
		$this_role = get_sub_field('role');
		$this_status = get_sub_field('status');
		if ($this_status == 'previous') {
			$this_role .= " (past)";
		}
		$this_title = $this_name;
		$this_subtitle = $this_role;
		$this_link = _sidebar_post_object_link($this_id, $this_title, $this_subtitle, '<br/>');
		echo "<p>$this_link</p>";
		if ($i < $row_count) {
			echo '<div class="divider shortcode-divider thick"></div>';
			$i++;
		}
	endwhile;

	sprout_sidebar_text_widget_close();

endif;
?>