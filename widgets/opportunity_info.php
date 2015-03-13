<?php
global $post, $display_post_type;

$widget_name  = 'opportunity_info';
$widget_title = 'Opportunity Info';
$acf_group = array(120, 2843);
$flexible_field_name = 'date_time,web';
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

//check quickfacts
$has_quickfacts	  = false;
$quick_facts = (array) get_field('quick_facts');
if (!empty($quick_facts[0])) $has_quickfacts = true; 

//check datetime
$has_datetime     = false;
$datetime_info = get_datetime_info($post->ID);
if (!empty($datetime_info)) $has_datetime = true; 

//check location
$has_location     = false;
$locations = get_locations($post->ID);
if (!empty($locations)) { $locations = get_location_details($locations); }
if (!empty($locations)) $has_location = true; 

//check web & social
$has_website      = false;
$has_social       = false;
$contact_details = get_contact_details($post->ID, array('public','network'));
if ($contact_details['email_address']) $has_email = true; 
if ($contact_details['phone_number']) $has_phone = true; 
if ($contact_details['website']) $has_website = true; 
if ($contact_details['social']) $has_social = true;

//if you have at least one thing, print it
if( $has_quickfacts || $has_datetime || $has_location || $has_website || $has_social ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';
	
	// First deal with optional quick facts
	if( $has_quickfacts ) {
		while(has_sub_field('quick_facts')) : 
			echo '<li class="icon-chevron-right">'.get_sub_field('quick_fact').'</li>';
		endwhile;
		if( $has_datetime || $has_location || $has_website ) { 
			echo '</ul>';
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}

	// Then deal with date/time info
	if( $has_datetime ) {
		if( !empty($datetime_info[0]['print']) ) {
			echo '<li class="icon-calendar">';
			if( $datetime_info[0]['print']['context'] != '' ) {
				echo $datetime_info[0]['print']['context'];
			}
			if( $datetime_info[0]['print']['dates'] != '' ) {
				echo $datetime_info[0]['print']['dates'];
			}
			echo '</li>';
			if( $datetime_info[0]['print']['times'] != '' ) {
				echo '<li class="icon-time">';
				echo $datetime_info[0]['print']['times'];
				echo '</li>';
			}
		}
		if( $has_location || $has_website ) {
			echo '</ul>';
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}
	
	if( $has_location ) {
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
		if( $has_website) {
			echo '</ul>';
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}

	// Add websites
	if( $has_website ) {
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
				$contact_print  = '<li class="icon-'.$contact_detail['icon'].'">';
				$contact_print .= '<a href="'.$contact_link.'" title="'.$contact_detail['title'].'" target="_blank">';
				$contact_print .= $contact_text;
				$contact_print .= '</a></li>';
				echo $contact_print;
			}
		}
	}
	
	echo '</ul>';
		
	if( $has_social ) :
		// Add social links
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
						$contact_print  = '<li class="sidebar_list_item">';
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