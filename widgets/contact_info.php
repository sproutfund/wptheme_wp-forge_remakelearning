<?php
global $post, $display_post_type;

$widget_name  = 'contact_info';
$widget_title = 'Contact Info';
$acf_group = array(2843);
$flexible_field_name = NULL;
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

$contact_details = get_contact_details($post->ID, array('public','network'));
$locations = get_locations($post->ID);

if (!empty($locations)) { $locations = get_location_details($locations); }
if( !empty($contact_details) || !empty($locations) ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	echo '<ul>';
	if ($contact_details['email_address'] || $contact_details['phone_number']) {
		if($contact_details['email_address']) {
			$email_count = count($contact_details['email_address']);
			foreach($contact_details['email_address'] as $contact_detail) {
				if ($contact_detail['ID'] == $post->ID) {
					// display only emails directly associated with contact
					sprout_print_sidebar_contactinfo(array(
						'type' => 'email_address', 
						'data' => $contact_detail['data'], 
						'icon' => $contact_detail['icon'],
					));
				}
			}
		}
		if($contact_details['phone_number']) {
			$phone_count = count($contact_details['phone_number']);
			foreach($contact_details['phone_number'] as $contact_detail) {
				$contact_text = '';
				if ($contact_detail['ID'] == $post->ID) {
					// display all phones directly associated with contact
					// but only display directdial and companymain
					if ($contact_detail['type'] == 'directdial') {
						$contact_text .= clean_phone($contact_detail['data']);
						if ($phone_count > 1) {
							$contact_text .=  ' direct';
						}
					} elseif ($contact_detail['type'] == 'companymain') {
						$contact_text .= clean_phone($contact_detail['data']);
						if ($phone_count > 1) {
							$contact_text .=  ' company';
						}
					}
				} else {
					// display only parent phones of the type 'companymain'
					if ($contact_detail['type'] == 'companymain') {
						$contact_text .= clean_phone($contact_detail['data']);
						if ($phone_count > 1) {
							$contact_text .=  ' company';
						}
					}
				}
				if ($contact_text != '') {
					sprout_print_sidebar_contactinfo(array(
						'type' => 'phone_number', 
						'text' => $contact_text, 
						'icon' => $contact_detail['icon'],
					));
				}
			}
		}
		echo '</ul>';
		if(!empty($locations) || $contact_details['website']) {
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}
	if(!empty($locations)) {
		$location_count = count($locations);
		foreach($locations as $location) {
			echo '<li class="icon-map-marker">';
			if ($location['ID'] != $post->ID) {
				if ($location['part']) { echo $location['part'].', '; }
				$post_title = $location['name'];
				$post_link  = $location['link'];
				echo "<a href=\"$post_link\" class=\"widget-link\">$post_title</a><br/>";
			}
			echo $location['print']['break'];
			echo '</li>';
		}
		echo '</ul>';
		if($contact_details['website']) {
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}
	if($contact_details['website']) {
		$website_count = count($contact_details['website']);
		foreach($contact_details['website'] as $contact_detail) {
			$contact_text = '';
			if ($contact_detail['ID'] == $post->ID) {
				// display all websites directly associated with contact
				$contact_text .= clean_website_url(url_to_domain($contact_detail['data']));
			} else {
				// display only parent websites of the type 'www'
				if ($contact_detail['type'] == 'www') {
					$contact_text .= clean_website_url(url_to_domain($contact_detail['data']));
				}
			}
			if ($contact_text != '') {
				$contact_link = 'http://'.clean_website_url($contact_detail['data']);
				sprout_print_sidebar_contactinfo(array(
					'type' => 'website', 
					'href' => $contact_link, 
					'text' => $contact_text, 
					'title' => $contact_detail['title'], 
					'icon' => $contact_detail['icon'],
				));
			}
		}
	}
	echo '</ul>';
	if($contact_details['social']) : 
		$social_count = count($contact_details['social']); 
	?>
		<div class="divider shortcode-divider thick">
		</div>
		<ul class="social-icons-shortcode small-size">
			<?php
				foreach($contact_details['social'] as $contact_detail) {
					$contact_text = '';
					if ($contact_detail['ID'] == $post->ID) {
						// display only websites directly associated with contact
						$contact_text .= clean_website_url($contact_detail['data']);
					}
					if ($contact_text != '') {
						$contact_link = 'http://'.$contact_detail['data'];
						$contact_print  = '<li>';
						$contact_print .= '<a class="social-link '.$contact_detail['icon'].'-link" ';
						$contact_print .= 'title="'.$contact_detail['title'].'" href="';
						$contact_print .= $contact_link;
						$contact_print .= '" target="_blank">';
						$contact_print .= '<i class="icon-'.$contact_detail['icon'].'"></i>';
						$contact_print .= '</a></li>';
						echo $contact_print;
					}
				}
			?>
		</ul>
	<?php endif; ?>
	<div class="spacer" style="height:5px;"></div>
<?php
	sprout_sidebar_text_widget_close();
endif;
?>