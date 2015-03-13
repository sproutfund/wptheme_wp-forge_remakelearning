<?php
global $post, $display_post_type;

$widget_name  = 'projects';
$widget_title = 'Projects';
$acf_group = NULL;
$flexible_field_name = NULL;
$edit_link = NULL;

$these_posts = $wpdb->get_results( $wpdb->prepare(
	"SELECT pm.meta_value, pm.meta_key, pm.post_id, p.post_type, p.post_name, p.post_title, p.post_date, p.post_modified ".
	"FROM $wpdb->postmeta pm INNER JOIN $wpdb->posts p ON pm.post_id = p.ID ".
	"WHERE ".
	"pm.meta_key LIKE '%%member_obj' ".
	"AND pm.meta_value = %d ".
	"AND (p.post_type = 'organization' OR p.post_type = 'project') ".
	"AND (p.post_status = 'publish') ".
	"ORDER BY p.post_date DESC",
	get_the_ID()
) ); //sorted by post date (reverse)

$row_count = count($these_posts);
if ($row_count > 0) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	$i = 1;
	$printed_posts = array();
	foreach ($these_posts as $this_post) {
		$this_id = $this_post->post_id;
		if (!(in_array($this_id, $printed_posts))) {
			$this_name = $this_post->post_title;
			//$this_role = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $this_id, str_replace('member_obj', 'role', $this_post->meta_key) ) );
			//$this_description = '';
			//$this_status = '';
			$this_title = $this_name;
			$this_subtitle = get_field('summary_statement',$this_id);
			$this_link = _sidebar_post_object_link($this_id, $this_title, $this_subtitle, '<br/>');
			echo "<p>$this_link</p>";
			$printed_posts[] = $this_id;
			if ($i < $row_count) {
				echo '<div class="divider shortcode-divider thick"></div>';
				$i++;
			}
		}
	}

	sprout_sidebar_text_widget_close();

endif;
?>