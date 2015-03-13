<?php
global $post, $display_post_type;

$widget_name  = 'recent_posts';
$widget_title = 'More Recent Posts from the Blog';
$acf_group = NULL;
$flexible_field_name = NULL;
$edit_link = NULL;

$these_posts = new WP_Query( array( 
	'post_type' => 'post',
	'post__not_in' => array( $post->ID ),
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => 3,
	'paged' => 1,
	'tax_query' => array( 
		array(
			'taxonomy' => 'webdisplay',
			'field' => 'slug',
			'terms' => get_option( 'sprout_webdisplay' )
		),
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => array('blog', 'commissioned'),
		)
	),
));
$these_posts = $these_posts->posts;

$row_count = count($these_posts);
if ($row_count > 0) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	$i = 1;
	$printed_posts = array();
	foreach ($these_posts as $this_post) {
		$this_id = $this_post->ID;
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
	echo '<p class="text-right"><a href="/blog/">View all blog posts <i class="fa fa-arrow-right"></i></a></p>';

	sprout_sidebar_text_widget_close();

endif;
?>