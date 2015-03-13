<?php
global $post, $display_post_type;

//if(($reg_status != 'closed') && (get_field('cost'))) :
if(false) : 

	sprout_sidebar_text_widget_open( 'costs', 'Costs', $edit_link );

	while(the_flexible_field('cost')) : 
		if (get_row_layout() == 'free') {
			echo '<li>Free / Open to the public</li>';
		} elseif (get_row_layout() == 'included') {
			echo '<li>Included with admission</li>';
		} elseif (get_row_layout() == 'phone') {
			if (get_sub_field('description')) {
				echo '<li>'.get_sub_field('description').': '.get_sub_field('phone').'</li>';
			} else {
				echo '<li>Call '.get_sub_field('phone').'</li>';
			}
		} elseif (get_row_layout() == 'notes') {
			echo '<li><i>Please Note</i>: '.get_sub_field('registration_notes').'</li>';
		}
	endwhile;

	sprout_sidebar_text_widget_close();

endif;
?>