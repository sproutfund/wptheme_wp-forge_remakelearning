<?php
global $post, $display_post_type;

$widget_name  = 'for_more_info';
$widget_title = 'More Information';
$acf_group = array(92);
$flexible_field_name = 'more_info';
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

if( get_field($flexible_field_name) ) :

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';
	$more_infos = array();
	while(has_sub_field($flexible_field_name)) : 
		$this_id = 0;
		$this_name = '';
		$this_icon = '';
		if (get_row_layout() == 'network_member') {
			$this_obj  = get_sub_field('member_obj');
			$this_id   = $this_obj->ID;
			$this_name = get_the_title($this_id); 
		} elseif (get_row_layout() == 'external_contact') {
			$this_name = get_sub_field('external_name'); 
			$this_icon = 'user';
		} elseif (get_row_layout() == 'website') {
			$this_name = get_sub_field('description');
			$this_icon = 'folder-open';
		}
		$this_email = (get_sub_field('email') != '') ? get_sub_field('email') : '';
		$this_phone = (get_sub_field('phone') != '') ? get_sub_field('phone') : '';
		$this_url   = (get_sub_field('url')   != '') ? get_sub_field('url')   : '';
		if( $this_url == 'http://') { $this_url = ''; }
		$more_infos[] = array(
			'id'			=> $this_id,
			'name'			=> $this_name,
			'email_address' => $this_email,
			'phone_number'  => $this_phone,
			'website'       => $this_url,
			'action'        => get_sub_field('action'),
			'description'   => get_sub_field('description'),
			'icon'			=> $this_icon,
		);
	endwhile;
	
	$i = 1;
	$more_info_count = count($more_infos);
	foreach( $more_infos as $more_info ) {
		$this_icon			= $more_info['icon'];
		$this_name			= $more_info['name'];
		$this_email_address = $more_info['email_address'];
		$this_phone_number  = $more_info['phone_number'];
		$this_website       = $more_info['website'];
		if( $more_info['id'] != 0 ) {
			$contact_details = get_contact_details($more_info['id']);
			if( ($this_email_address == '') && (isset($contact_details['email_address'][0]['data'])) ) {
				$this_email_address = $contact_details['email_address'][0]['data'];
			}
			if( ($this_phone_number == '') && (isset($contact_details['phone_number'][0]['data'])) ) {
				$this_phone_number = $contact_details['phone_number'][0]['data'];
			}
			if( ($this_website == '') && (isset($contact_details['website'][0]['data'])) ) {
				$this_website = $contact_details['website'][0]['data'];
			}
			sprout_print_sidebar_contactinfo(array(
				'type' => 'intlink', 
				'data' => get_permalink($more_info['id']), 
				'text' => $this_name, 
				'icon' => $this_icon,
			));
		} elseif ( $this_name != '' ) {
			sprout_print_sidebar_contactinfo(array(
				'type' => 'text', 
				'text' => $this_name,
				'icon' => $this_icon,
			));
		}
		if( $this_email_address != '' ) {
			sprout_print_sidebar_contactinfo(array(
				'type' => 'email_address', 
				'data' => $this_email_address, 
			));
		}
		if( $this_phone_number != '' ) {
			sprout_print_sidebar_contactinfo(array(
				'type' => 'phone_number', 
				'data' => $this_phone_number, 
			));
		}
		if( $this_website != '' ) {
			sprout_print_sidebar_contactinfo(array(
				'type' => 'website', 
				'href' => $this_website, 
			));
		}
		if ($i < $more_info_count-1) {
			echo '</ul><div class="divider shortcode-divider thick"></div><ul>';
			$i++;
		}
	}
	echo '</ul>';

	sprout_sidebar_text_widget_close();

endif;
?>