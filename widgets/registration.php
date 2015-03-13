<?php
global $post, $display_post_type;

$widget_name  = 'registration_participation';
$widget_title = 'How to Participate';
$acf_group = array(120);
$flexible_field_name = 'cost,registration';
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

$has_registration = false;
$has_costinfo     = false;

$registration_rows = get_field('registration');
$registration_row_count = count($registration_rows);
if ($registration_row_count) $has_registration = true; 

$costinfo_rows = get_field('cost');
$costinfo_row_count = count($costinfo_rows);
if ($costinfo_row_count) $has_costinfo = true; 

if( $has_registration || $has_costinfo ) : 

	// Then tackle the registration info
	if( $has_registration ) {
		$reg_required = '';
		$reg_eligibility = '';
		$reg_website_print = '';
		$reg_email_print = '';
		$reg_phone_print = '';
		$reg_notes_print = '';
		$registration_details = '';
		while(the_flexible_field('registration')) {
			if (get_row_layout() == 'status_requirements_eligibility') {
				$reg_status = get_sub_field('status');
				$reg_required = get_sub_field('registration_required');
				$reg_eligibility = get_sub_field('eligibility_info');
				if ($reg_eligibility != '') {
					$registration_details .= "<li class=\"sidebar_list_item\">$reg_eligibility</li>";
				}
			} elseif (get_row_layout() == 'website') {
				$reg_website = get_sub_field('url');
				$reg_website_descript = (get_sub_field('description') == '') ? clean_website_url(url_to_domain($reg_website)) : get_sub_field('description');
				$reg_website_print .= "<li class=\"icon-external-link\"><a href=\"$reg_website\">$reg_website_descript</a></li>";
			} elseif (get_row_layout() == 'email') {
				$reg_email = trim(get_sub_field('email'));
				$reg_email_descript = (get_sub_field('description') == '') ? 'Email' : get_sub_field('description');
				$reg_email_print .= c2c_obfuscate_email("<li class=\"icon-envelope\"><a href=\"mailto:$reg_email\">$reg_email_descript</a></li>");	
			} elseif (get_row_layout() == 'phone') {
				$reg_phone = clean_phone(get_sub_field('phone'));
				$reg_phone_descript = (get_sub_field('description') == '') ? 'Phone' : get_sub_field('description');
				$reg_email_print .= "<li class=\"sidebar_list_item\">$reg_phone_descript: $reg_phone</li>";
			} elseif (get_row_layout() == 'notes') {
				$reg_notes = get_sub_field('registration_notes');
				$reg_notes_print .= "<li class=\"sidebar_list_item\">$reg_notes</li>";
			}
		}

		if (has_term('funding-available', 'opportunity-type') || has_term('call-competition', 'opportunity-type')) {
			$registration_heading = 'Application ';
		} else {
			$registration_heading = 'Registration ';
		}
		$registration_details .= $reg_website_print.$reg_email_print.$reg_phone_print.$reg_notes_print;
		if (($reg_status == 'open') || ($reg_status == 'door')) {
			if ($reg_required == 'required') {
				$registration_heading .= 'Required';
			} elseif ($reg_required == 'none') {
				$registration_heading .= 'Not Required';
			} else { 
				$registration_heading .= 'Requested';
				if ($reg_status == 'door') {
					$registration_details = '<li class="sidebar_list_item">Registration available at the door</li>'.$registration_details;
				}
			}
		} elseif ($reg_status == 'future') {
			$registration_heading .= 'TBA';
			$registration_details = '<li class="sidebar_list_item">Registration information for this event/opportunity is not yet available</li>'.$registration_details;
		} elseif ($reg_status == 'invite') {
			$registration_heading .= 'by Invitation Only';
			$registration_details = '<li class="sidebar_list_item">Registration for this event is limited to invited guests</li>';
		} elseif ($reg_status == 'closed') {
			$registration_heading .= 'Closed';
			$registration_details = '<li class="sidebar_list_item">This event/opportunity is closed or sold-out</li>';
		}
	}


	// Then tackle the cost info
	/*if( $has_costinfo ) {
		if( $has_registration ) {
			echo '</ul>';
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
		$cost_notes_print = '';
		while(the_flexible_field('cost')) {
			if (get_row_layout() == 'free') {
				$cost_note = '';
				switch (get_sub_field('free')) {
					case 'public' :
						$cost_note = 'Free and open to the public';
						break;
					case 'network' :
						$cost_note = 'Free for Network members';
						break;
				}
				if( $cost_notes_print !== '' ) $cost_notes_print .= "<br/>";
				$cost_notes_print .= $cost_note;
			} elseif (get_row_layout() == 'included') {
				$cost_note = get_sub_field('included');
				if( $cost_notes_print !== '' ) $cost_notes_print .= "<br/>";
				$cost_notes_print .= $cost_note;
			} elseif (get_row_layout() == 'price_set') {
				$cost_note = 'Cost: '.get_sub_field('cost').' '.get_sub_field('description');
				if( $cost_notes_print !== '' ) $cost_notes_print .= "<br/>";
				$cost_notes_print .= $cost_note;
			} elseif (get_row_layout() == 'notes') {
				$cost_note = get_sub_field('notes');
				if( $cost_notes_print !== '' ) $cost_notes_print .= "<br/>";
				$cost_notes_print .= $cost_note;
			}
		}
		echo "<li class=\"sidebar_list_item\">$cost_notes_print</li>";
	}*/

	$widget_title = $registration_heading;
	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	echo '<ul>';
	echo $registration_details;
	echo '</ul>';
		
	sprout_sidebar_text_widget_close();
endif;
?>