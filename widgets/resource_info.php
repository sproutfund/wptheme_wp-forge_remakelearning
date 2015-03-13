<?php
global $post, $display_post_type;

$widget_name  = 'resource_info';
$widget_title = 'Quick Facts &amp; Links';
$acf_group = array(2843);
$flexible_field_name = 'quick_facts,web';
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

$has_quickfacts	  = false;
$has_skilllevel   = false;
$has_timereq      = false;
$has_costinfo     = false;
$has_outputinfo   = false;
$has_website      = false;
$has_social       = false;

$quick_facts = (array) get_field('quick_facts');
if (!empty($quick_facts[0])) $has_quickfacts = true;

if (get_field('skill_level') != '') $has_skilllevel = true;
if (get_field('time') != '') $has_timereq = true;
if (get_field('cost') != '') $has_costinfo = true;
if (get_field('output') != '') $has_outputinfo = true;
 
$contact_details = get_contact_details($post->ID, array('public','network'));
if ($contact_details['website']) $has_website = true; 
if ($contact_details['social']) $has_social = true; 

if( $has_quickfacts || $has_skilllevel || $has_timereq || $has_costinfo || $has_outputinfo || $has_website || $has_social ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';
	
	// First deal with optional quick facts
	if( $has_quickfacts ) {
		while(has_sub_field('quick_facts')) : 
			echo '<li class="icon-chevron-right">'.get_sub_field('quick_fact').'</li>';
		endwhile;
		if( $has_timeinfo || $has_costinfo || $has_outputinfo || $has_website ) { 
			echo '</ul>';
			echo '<div class="divider shortcode-divider thick"></div>';
			echo '<ul>';
		}
	}

	// Add Time Required and Cost
	if( $has_skilllevel || $has_timereq || $has_costinfo || $has_outputinfo ) {
		if( $has_skilllevel ) {
			$skill_level = get_field('skill_level');
			echo "<li class=\"icon-trophy\"><span class=\"widget-emphasis\">Level</span>: ";
			if ($skill_level === 'beginner') echo 'Beginner';
			if ($skill_level === 'beginner-intermediate') echo 'Beginner–Intermediate';
			if ($skill_level === 'intermediate') echo 'Intermediate';
			if ($skill_level === 'intermediate-advanced') echo 'Intermediate–Advanced';
			if ($skill_level === 'advanced') echo 'Advanced';
			echo "</li>";
		}
		if( $has_timereq ) {
			echo "<li class=\"icon-time\"><span class=\"widget-emphasis\">Time</span>: ".get_field('time')."</li>";
		}
		if( $has_costinfo ) {
			echo "<li class=\"icon-money\"><span class=\"widget-emphasis\">Cost</span>: ".get_field('cost')."</li>";
		}
		if( $has_outputinfo ) {
			echo "<li class=\"icon-cogs\"><span class=\"widget-emphasis\">Outputs</span>: ".get_field('output')."</li>";
		}
		echo '</ul>';
		if( $has_website ) { 
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