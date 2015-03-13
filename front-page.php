<?php get_header(); ?>
<?php
	$homepage = get_posts( array( 
		'posts_per_page' => 1, 
		'post_type' => 'homepage', 
		'tax_query' => array( array( 
			'taxonomy' => 'webdisplay', 
			'field' => 'slug', 
			'terms' => get_option('sprout_webdisplay') 
		)) 
	));
	global $post;
	$post = $homepage[0];
	setup_postdata( $post );
	get_template_part( 'content', 'homepage' );
	wp_reset_postdata();
?>	
<?php get_footer(); ?>