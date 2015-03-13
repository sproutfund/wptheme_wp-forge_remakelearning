<?php
global $post, $display_post_type;

$widget_name  = 'author';
$widget_title = 'About the Author';
$acf_group = NULL;
$flexible_field_name = NULL;
$edit_link = NULL;

$authors = get_the_author_meta('display_name');
$acf_authors = get_field('author', $post_id);
$row_count = count($acf_authors);
if( $row_count > 1 ) { $widget_title .= 's'; }

if( ($authors != 'The Sprout Fund') || ($row_count >= 1) ) :

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

	if($acf_authors) : ?>
		<ul>
			<?php
				$i = 1;
				while(has_sub_field('author', $post_id)) {
					if (get_row_layout() == 'network_member') {
						$this_obj = get_sub_field('member_obj');
						$this_id = $this_obj->ID;
						echo custom_get_the_excerpt($this_id);
					} elseif (get_row_layout() == 'wordpress_user') {
						$this_user = get_sub_field('wp_user');
						$this_id   = $this_user->ID;
						echo get_the_author_meta('description', $this_id);
					} elseif (get_row_layout() == 'external_contact') {
						echo get_sub_field('external_name');
					}
					if ($i < $row_count) {
						echo '</ul><div class="divider shortcode-divider thick"></div><ul>';
						$i++;
					}
				}
			?>
		</ul>
	<?php else : ?>
		<p><?php echo get_the_author_meta('description'); ?></p>
	<?php 
	endif; 
	sprout_sidebar_text_widget_close();
endif;
?>