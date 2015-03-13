<?php
global $post, $display_post_type;

$widget_name  = 'author';
$widget_title = 'About the Author';
$acf_group = NULL;
$flexible_field_name = NULL;
$edit_link = NULL;

$author_display_name = sprout_get_custom_author_info($post->ID, 'display_name');
$author_description  = sprout_get_custom_author_info($post->ID, 'description', $separator = '</ul><div class="divider shortcode-divider thick"></div><ul>');

if( ($author_display_name != 'The Sprout Fund') && ($author_description != '') ) : 
	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	echo "<ul>$author_description</ul>";
	sprout_sidebar_text_widget_close();
endif;
?>