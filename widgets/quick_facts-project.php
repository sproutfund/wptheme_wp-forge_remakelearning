<?php
global $post, $display_post_type;

$widget_name  = 'quick_facts';
$widget_title = 'Quick Facts &amp; Links;';
$acf_group = array(96, 120, 2843);
$flexible_field_name = 'quick_facts,cost,web';
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

//check costinfo
$has_costinfo     = get_field('cost');

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


if( $has_quickfacts || $has_locations ) {
	if( !$has_quickfacts && $has_locations ) {
		$widget_title = 'Location';
	} else {
		$widget_title = 'Quick Facts';
	}
	if ($has_website || $has_social) {
		$widget_title .= ' &amp; Links';
	}
} else {
	$widget_title = 'Links';
}

if( $has_quickfacts || $has_costinfo || $has_locations || $has_website || $has_social ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	echo '<ul>';
	if( $has_quickfacts ) {
		while(has_sub_field('quick_facts')) : 
			echo '<li class="icon-chevron-right">'.get_sub_field('quick_fact').'</li>';
		endwhile;
		echo '</ul>';
		if( $has_costinfo || $has_locations || $has_website ) { 
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}
	if( $has_costinfo ) {
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
		echo "<li class=\"icon-asterisk\">$cost_notes_print</li>";
		echo '</ul>';
		if( $has_locations || $has_website ) { 
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
		if( $has_website ) {
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}
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