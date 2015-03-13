<?php

include_once 'functions-image.php';
include_once 'shortcodes.php';
/**
 * WP-Starter functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage WP_Starter
 * @since WP-Starter 1.0
 */

/**
 * Setup WP-Starter's textdomain.
 *
 * Declare a textdomain for WP-Starter.
 * Translations can be filed in the /languages/ directory.
 */
function wpstarter_theme_setup() {
	load_child_theme_textdomain( 'wpstarter', get_stylesheet_directory() . '/language' );
}
add_action( 'after_setup_theme', 'wpstarter_theme_setup' );


/**
 * add custom stylesheets as needed
 */
function sproutfund_enqueue_scripts() {
	global $id;
	
	
	// required styles for Google Fonts
	wp_enqueue_style ( 'google-font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
	wp_enqueue_style ( 'google-font-roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic');

	// required styles for every page; eventually replace these with a single, consolidated file
	wp_enqueue_style ( 'rml-helpers',    get_stylesheet_directory_uri() .'/css/!helper-classes.css');
	wp_enqueue_style ( 'rml-colors',     get_stylesheet_directory_uri() .'/css/colors.css');
	wp_enqueue_style ( 'rml-nav',        get_stylesheet_directory_uri() .'/css/nav.css');
	wp_enqueue_style ( 'rml-header',     get_stylesheet_directory_uri() .'/css/header.css');
	wp_enqueue_style ( 'rml-footer',     get_stylesheet_directory_uri() .'/css/footer.css');
	wp_enqueue_style ( 'rml-subfooter',  get_stylesheet_directory_uri() .'/css/subfooter.css');
	wp_enqueue_style ( 'rml-button',     get_stylesheet_directory_uri() .'/css/button.css');
	wp_enqueue_style ( 'rml-icons',      get_stylesheet_directory_uri() .'/css/icons.css');
	wp_enqueue_style ( 'rml-portfolio',  get_stylesheet_directory_uri() .'/css/portfolio.css');
	
	// gravity styles
	wp_enqueue_style ( 'gforms_reset_css-css', 'http://www.sproutfund.org/wp-content/plugins/gravityforms/css/formreset.css');
	wp_enqueue_style ( 'gforms_formsmain_css-css', 'http://www.sproutfund.org/wp-content/plugins/gravityforms/css/formsmain.css');
	wp_enqueue_style ( 'gforms_ready_class_css-css', 'http://www.sproutfund.org/wp-content/plugins/gravityforms/css/readyclass.css');
	wp_enqueue_style ( 'gforms_browsers_css-css', 'http://www.sproutfund.org/wp-content/plugins/gravityforms/css/browsers.css');
	
	
	// optional styles for certain pages
	wp_register_style( 'rml-homepage',   get_stylesheet_directory_uri() .'/css/homepage.css');
	if ( is_front_page() || (get_post_type($id) == 'homepage') ) {
		wp_enqueue_style ( 'rml-homepage' );
	}
	
	wp_enqueue_style ( 'rml-custom',     get_stylesheet_directory_uri() .'/css/!custom.css');
	
	if( !is_admin() ) {
		wp_dequeue_style( 'wp-admin' );
	}
}
add_action( 'wp_enqueue_scripts', 'sproutfund_enqueue_scripts' );



/**
 * suppress shortcodes from content
 */
function sprout_remove_shortcodes( $content ) {
  $content = strip_shortcodes( $content );
  return $content;
}
//add_filter( 'the_content', 'sprout_remove_shortcodes' );

/**
 * Register additional scripts or styles exclusive to WP-Starter.
 */
function wpstarter_scripts_styles() {
	
	// The wpstarter-functions.js file will allow you to add functions to make any additional scripts you add work, i.e. lightbox or maybe a carousel script
    wp_enqueue_script( 'wpstarter-js', get_stylesheet_directory_uri() . '/js/wpstarter-functions.js', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'wpstarter_scripts_styles', 0 );

function modify_nav_menu_args( $args ) {
	$args['items_wrap'] = '<ul class="left" id="nav-menu-text-items">%3$s<li class="divider"></li><li class="menu-item menu-item-main-menu menu-item-search"><a href="#" class="" data-reveal-id="searchModal">Search</a></li></ul>';
	return $args;
}
add_filter( 'wp_nav_menu_args', 'modify_nav_menu_args' );


/*--------------------------------------------------------------------------------------
*
*	Try to get Select2 working
* 
*-------------------------------------------------------------------------------------*/
function sproutfund_enqueue($hook) {
	wp_register_style( 'select2_wp_admin_css', get_stylesheet_directory_uri() . '/js/select2.css', false, '1.0.0' );
	wp_enqueue_style ( 'select2_wp_admin_css' );
	wp_enqueue_script( 'select2_wp_admin_js', get_stylesheet_directory( __FILE__ ) . '/select2-3.5.1/select2.min.js' );
}
add_action( 'admin_enqueue_scripts', 'sproutfund_enqueue' );

function sproutfund_admin_js() { ?>
	<script type="text/javascript">
		jQuery(document).ready( function () { 
			jQuery("#acf_17888 select.post_object").select2();
		});
	</script>
<?php }
//add_action('admin_footer', 'sproutfund_admin_js');


/*--------------------------------------------------------------------------------------
*
*	Create ACF Options Pages
* 
*-------------------------------------------------------------------------------------*/
if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title' => 'Featured Opportunities',
        'parent' => 'edit.php?post_type=opportunity',
        'capability' => 'manage_options'
    ));
    acf_add_options_sub_page(array(
        'title' => 'Manage Modals',
        'parent' => 'edit.php?post_type=homepage',
        'capability' => 'manage_options'
    ));
    acf_add_options_sub_page(array(
        'title' => 'Manage Authors',
        'parent' => 'edit.php',
        'capability' => 'manage_options'
    ));
}

/*--------------------------------------------------------------------------------------
*
*	sprout_custom_home_categories()
* 
*-------------------------------------------------------------------------------------*/
/*function sprout_custom_home_categories( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'cat', '3, 1412' );
	}
}
add_action( 'pre_get_posts', 'sprout_custom_home_categories' );*/
function myprefix_query_offset(&$query) {
	
	//Before anything else, make sure this is the right query...
	if ( ! $query->is_posts_page ) {
			return;
	}
	
	if ( $query->is_home() && $query->is_main_query() ) {

		//only the desired categories
		$query->set( 'cat', '3, 1412' );

    //First, define your desired offset...
    $offset = 1;
    
    //Next, determine how many posts per page you want (we'll use WordPress's settings)
    $ppp = get_option('posts_per_page');

    //Next, detect and handle pagination...
    if ( $query->is_paged ) {

        //Manually determine page query offset (offset + current page (minus one) x posts per page)
        $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

        //Apply adjust page offset
        $query->set('offset', $page_offset );

    }
    else {

        //This is the first page. Just use the offset...
        $query->set('offset',$offset);

    }

	}
}
add_action('pre_get_posts', 'myprefix_query_offset', 1 );
function myprefix_adjust_offset_pagination($found_posts, $query) {

    //Define our offset again...
    $offset = 1;

    //Ensure we're modifying the right query object...
    if ( $query->is_posts_page ) {
        //Reduce WordPress's found_posts count by the offset... 
        return $found_posts - $offset;
    }
    return $found_posts;
}
add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );


/*--------------------------------------------------------------------------------------
*
*	sprout_shared_get_source()
* 
*-------------------------------------------------------------------------------------*/
function sprout_shared_get_source( $post_id = null ) {
	global $post;
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	$source = '';
	if( have_rows('source_referrer', $post_id) ) { 
		while( have_rows('source_referrer', $post_id) && empty($source) ) { the_row();
			if( get_row_layout() == 'web' ) {
				$source = get_sub_field('name');
			}
		}
	}
	return $source;
}

/*--------------------------------------------------------------------------------------
*
*	sprout_strip_source_from_post_title()
* 
*-------------------------------------------------------------------------------------*/
function sprout_strip_source_from_post_title( $title, $post_id = null ) {
	global $post;
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	
	$source = sprout_shared_get_source($post_id);
	
	if( !empty($source) ) {
		return str_replace(" [$source]", "", $title );
	} else {
		return $title;
	}
	
}
add_filter( 'the_title', 'sprout_strip_source_from_post_title', 10, 2 );


/*--------------------------------------------------------------------------------------
*
*	sprout_print_post_meta()
* 
*-------------------------------------------------------------------------------------*/
function sprout_print_post_meta( $post_id = null ) {
	if( empty($post_id) ) {
		global $post;
		if( empty($post) ) {
			return ''; // No global $post var available.
		}
		$post_id = $post->ID;
	}

	if (in_category('shared')) {
		$attribution = 'Shared';
		$acf_referrers = get_field('source_referrer', $post_id);
		$row_count = count($acf_referrers);
		if( $acf_referrers ) {
			$i = 1;
			while(has_sub_field('source_referrer', $post_id)) {
				if (get_row_layout() == 'web') {
					$attribution .= ' from ';
					if( (get_sub_field('url') != '') && (get_sub_field('url') != '') ) {
						$attribution .= '<a target="_blank" href="'.get_sub_field('url').'">';
						$attribution .= get_sub_field('name');
						$attribution .= '</a>';
					} else {
						$attribution .= get_sub_field('name');
					}
				} elseif (get_row_layout() == 'network_member') {
					$attribution .= ' by ';
					$this_obj = get_sub_field('name'); // should be fixed 'member_obj'
					$this_id  = $this_obj->ID;
					$attribution .= '<a target="_blank" href="'.get_permalink($this_id).'">';
					$attribution .= get_the_title($this_id);
					$attribution .= '</a>';
				}
				if ($i < $row_count) {
					$attribution .= ', ';
					$i++;
				}
			}
		}
		
	} else {
		$attribution = 'Posted';
		if( has_term('guest-posts', 'documentation-type') )
			{ $attribution = 'Guest Post by'; }
		elseif( has_term('interviews', 'documentation-type') ) 
			{ $attribution = 'Interview by'; }
		elseif( has_term('photos', 'documentation-type') )
			{ $attribution = 'Photos taken by'; }
		elseif( has_term('recaps', 'documentation-type') )
			{ $attribution = 'Event recap by'; }
		elseif( has_term('sounds', 'documentation-type') )
			{ $attribution = 'Podcast edited by'; }
		elseif( has_term('stories', 'documentation-type') )
			{ $attribution = 'Written by'; }
		elseif( has_term('videos', 'documentation-type') )
			{ $attribution = 'Video produced by'; }

		$authors = sprout_get_custom_author_info($post->ID, 'display_name', $separator = ', ');
		if( $authors != '' ) {
			if( $attribution == 'Posted') { $attribution .= ' by'; }
			$attribution .= ' '.$authors;
		}
	}
	
	return '<span class="author">'.$attribution.'</span><span> on </span><span class="date"><a href="'.get_day_link(get_the_time('Y'), get_the_time('n'), get_the_time('j')).'">'.get_the_time(get_option('date_format')).'</a></span>';
}

/*--------------------------------------------------------------------------------------
*
*	sprout_get_custom_author_info($post_id, $meta_field = 'display_name', $separator = ', ')
* 
*-------------------------------------------------------------------------------------*/
function sprout_get_custom_author_info($post_id, $meta_field = 'display_name', $separator = ', ') {
	$target_post = get_post($post_id);
	$author_id = $target_post->author;

	$external_authors = array(
		'Courtney Patterson' => '<b>Courtney Patterson</b> has lived in Pittsburgh long enough to feel like a native, but she still sings the praises of her hometown, Toledo, OH. She’s a writer, drummer and Rustbelt advocate. She looks for any excuse to dance, share food with friends, or escape to the woods.',
		'Joshua Barnes' => '<b>Joshua Barnes</b> is the senior editorial assistant at Sampsonia Way magazine. In 2010 he earned a bachelor’s degree in Fiction Writing and Literature at the University of Pittsburgh, where he won 2009′s Ossip Award in Critical Writing. He is now interested in forms of writing that combine literary elements with music.',
		'Kelsey Herron' => '<b>Kelsey Herron</b> is a freelance journalist who blogs regularly about national and local trends in technology and education for Remake Learning.',
		'Caroline Combemale' => '<b>Caroline Combemale</b> is a high school sophomore and Assemble intern who wants to give fellow teens a voice in their communities. Caroline teaches technology classes, debates and plays guitar and piano.',
		'Kathleen Costanza' => '<b>Kathleen Costanza</b> is a freelance journalist who blogs regularly about national and local trends in technology and education for Remake Learning.',
	);
	
	$authors = get_the_author_meta($meta_field, $author_id);
	$acf_authors = get_field('author', $post_id);
	$row_count = count($acf_authors);
	if( $row_count > 0 ) {
		$authors = '';
		$i = 1;
		while(has_sub_field('author', $post_id)) {
			if (get_row_layout() == 'network_member') {
				$this_obj = get_sub_field('member_obj');
				$this_id  = $this_obj->ID;
				if( $meta_field == 'display_name' ) {
					$authors .= get_the_title($this_id);
				} elseif( $meta_field == 'description' ) {
					$authors .= custom_get_the_excerpt($this_id);
				}
			} elseif (get_row_layout() == 'wordpress_user') {
				$this_user = get_sub_field('wp_user');
				$this_id   = $this_user->ID;
				if( $meta_field == 'display_name' ) {
					$authors .= get_the_author_meta('display_name', $this_id);
				} elseif( $meta_field == 'description' ) {
					$authors .= get_the_author_meta('description', $this_id);
				}
			} elseif (get_row_layout() == 'external_contact') {
				if( $meta_field == 'display_name' ) {
					$authors .= get_sub_field('external_name');
				} elseif( $meta_field == 'description' ) {
					$external_author_bio = $external_authors[get_sub_field('external_name')];
					if($external_author_bio) {
						$authors .= $external_author_bio;
					} else {
						$authors .= '<b>'.get_sub_field('external_name').'</b> is a writer in Pittsburgh, Pennsylvania.';
					}
				}
			}
			if ($i < $row_count) {
				echo $separator;
				$i++;
			}
		}
	}
	return $authors;
}


/*--------------------------------------------------------------------------------------
*
*	sprout_sidebar_text_widget_open()
*	Prints the HTML to open a new sidebar text widget
* 
*-------------------------------------------------------------------------------------*/
function sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link = '' ) {
?>
<article class="widget widget_text widget_<?php echo $widget_name;?>" id="<?php echo $widget_name;?>" >
	<div class="container panel sidebar-widget widget_<?php echo $widget_name;?>">
		<h3 class="widget-title sidebar-widget-title"><?php echo $widget_title.$edit_link; ?></h3>
		<div class="textwidget">
<?php
}


/*--------------------------------------------------------------------------------------
*
*	sprout_sidebar_text_widget_close()
*	Prints the HTML to close a new sidebar text widget
* 
*-------------------------------------------------------------------------------------*/
function sprout_sidebar_text_widget_close() {
?>
		</div>
	</div>
</article>
<div class="divider sidebar-divider"></div>
<div class="clear"></div>
<?php
}


/*--------------------------------------------------------------------------------------
*
*	custom get_the_excerpt
*	http://www.sean-barton.co.uk/2011/11/getting-the-wordpress-excerpt-outside-of-the-loop/
* 
*-------------------------------------------------------------------------------------*/

function custom_get_the_excerpt($id=false) {
	global $post;

	$old_post = $post;
	if ($id != $post->ID) {
		$post = get_page($id);
	}

	if (!$excerpt = trim($post->post_excerpt)) {
		$excerpt = $post->post_content;
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');

		$words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$excerpt = implode(' ', $words);
			$excerpt = $excerpt . $excerpt_more;
		} else {
			$excerpt = implode(' ', $words);
		}
	}

	$post = $old_post;

	return $excerpt;
}

/*--------------------------------------------------------------------------------------
*
*	Set theme thumbnail sizes
* 
*-------------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );

	/*
	$responsive_sizes = array(
		'small' => array(
			'portfolio'       => 'thumbnail-180px',
			'collection-hero' => 'thumbnail-360px',
			'single-feature'  => 'thumbnail-360px',),
		'small retina' => array(
			'portfolio'       => 'thumbnail-360px',
			'collection-hero' => 'thumbnail-720px',
			'single-feature'  => 'thumbnail-720px',),
		'medium' => array(
			'portfolio'       => 'thumbnail-180px',
			'collection-hero' => 'thumbnail-360px',
			'single-feature'  => 'thumbnail-600px',),
		'medium retina' => array(
			'portfolio'       => 'thumbnail-360px',
			'collection-hero' => 'thumbnail-720px',
			'single-feature'  => 'thumbnail-1200px',),
		'large' => array(
			'portfolio'       => 'thumbnail-360px',
			'collection-hero' => 'thumbnail-600px',
			'single-feature'  => 'thumbnail-900px',),
		'large retina' => array(
			'portfolio'       => 'thumbnail-720px',
			'collection-hero' => 'thumbnail-1200px',
			'single-feature'  => 'thumbnail-1800px',),
	);
	*/

	//standard Sprout thumbnails; assumes 6x4 landscape uploads
	add_image_size( 'thumbnail-90px',      90,   90, true ); // "thumbnail" / mini-square
	add_image_size( 'thumbnail-120px',    120,   80, true ); // front-page-more-blog-posts
	add_image_size( 'thumbnail-180px',    180,  120, true ); // small portfolio
	add_image_size( 'thumbnail-240px',    240,  160, true ); // 
	add_image_size( 'thumbnail-360px',    360,  240, true ); // small collection-hero, small single-feature, small retina portfolio
	add_image_size( 'thumbnail-480px',    480,  320, true ); // front-page-opportunities
	add_image_size( 'thumbnail-600px',    600,  400, true ); // collection hero 
	add_image_size( 'thumbnail-720px',    720,  480, true ); // small retina collection-hero
	add_image_size( 'thumbnail-900px',    900,  600, true ); // "large" & single feature image
	add_image_size( 'thumbnail-1200px',  1200,  800, true ); // 2x collection hero
	add_image_size( 'thumbnail-1800px',  1800, 1200, true ); // 2x "large"& single feature image

}

/*--------------------------------------------------------------------------------------
*
*	This theme's Sprout Directory contact info to print in sidebar 
* 
*-------------------------------------------------------------------------------------*/

function sprout_print_sidebar_contactinfo($args, $echo = true) {
	$type = $args['type'];
	$data = isset($args['data']) ? $args['data'] : '';
	$text = isset($args['text']) ? $args['text'] : '';
	$href = isset($args['href']) ? $args['href'] : '';
	$title = isset($args['title']) ? $args['title'] : '';
	if( !isset($args['icon']) ) { 
		if( $type == 'email_address' ) { $icon = 'envelope'; }
		if( $type == 'phone_number' )  { $icon = 'phone'; }
		if( $type == 'website' )       { $icon = 'external-link'; }
	} else {
		$icon = $args['icon'];
	}
	$contact_print  = '<li class="icon-'.$icon.'">';
	switch( $type ) {
		case 'text' :
		case 'phone_number' :
			if( $data != '' ) {
				$contact_print .= $data;
			} elseif( $text != '' ) {
				$contact_print .= $text;
			}
			break;
		case 'email_address' :
			$link = '<a href="mailto:'.$data.'">'.$data.'</a>';
			if( function_exists( 'c2c_obfuscate_email' ) ) {
				$link = c2c_obfuscate_email( $link );
			}
			$contact_print .= $link;
			break;
		case 'website' :
		case 'intlink' :
			if( $href == '' ) { $href = $data; };
			if( $text == '' ) { 
				if( function_exists( 'url_to_domain' ) ) {
					$text = url_to_domain( $href );
				} else {
					$text = $href;
				}
			}
			$contact_print .= '<a href="'.$href.'" title="'.$title.'"';
			if( $type == 'website' ) { $contact_print .= ' target="_blank"'; };
			$contact_print .= '>';
			$contact_print .= $text;
			$contact_print .= '</a>';	
			break;
	}
	$contact_print .= '</li>';
	if($echo) { echo $contact_print; } else { return $contact_print; }
}


/*--------------------------------------------------------------------------------------
*
*	Add thickbox support to front-end
* 
*-------------------------------------------------------------------------------------*/

function add_themescript(){
    if(!is_admin()){
    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox',null,array('jquery'));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
    }
}
add_action('init','add_themescript');


/*--------------------------------------------------------------------------------------
*
*	Removes unnecessary clutter from dashboard
* 
*-------------------------------------------------------------------------------------*/

function remove_dashboard_widgets(){
  global$wp_meta_boxes;
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


/*--------------------------------------------------------------------------------------
*
*	Sidebar functions
* 
*-------------------------------------------------------------------------------------*/

function _sidebar_post_object_link($post_id, $post_title, $post_subtitle = '', $separator = '<br/>', $show_thumb = false) {
	$link_text  = '';
	if ($post_id) {
		if ($show_thumb && has_post_thumbnail($post_id)) { 
			$link_text .= get_the_post_thumbnail($post_id, 'thumbnail-mini');
		}
		$link_text .= '<a title="'.$post_title.'" href="'.get_permalink($post_id).'">';
		$link_text .= '<span class="title">'.$post_title.'</span>';
		$link_text .= '</a>';
	} else {
		$link_text .= '<span class="title">'.$post_title.'</span>';
	}
	if ($post_subtitle != '') {
		$link_text .= $separator;
		$link_text .= '<span class="subtitle">'.$post_subtitle.'</span>';
	}
	return $link_text;
}

function _sidebar_taxonomy_object_link($term_id, $taxonomy, $title = '', $subtitle = '', $separator = '<br/>') {
	if (($link == '') || ($subtitle == '') || ($subtitle == '')) {
		$term = get_term_by ('id', $term_id, $taxonomy);
		if ($href == '') { $href  = get_term_link( $term ); }
		if ($title == '') { $title = $term->name; }
		if ($subtitle == '') { $title = $term->description; }
	}
	$link_text  = sprintf(__('<a href="%s" title="%s">'), $href, $title);
	//if (has_post_thumbnail($post_id)) { 
	//	$link_text .= get_the_post_thumbnail($post_id, 'thumbnail-mini');
	//}
	$link_text .= sprintf(__('<span class="title">%s</span>'), $title);
	if ($subtitle != '') {
		$link_text .= $separator;
		$link_text .= sprintf(__('<span class="subtitle">%s</span>'), $subtitle);
	}
	$link_text .= "</a>";
	return $link_text;
}

function _sidebar_little_icon_link ( $href = '', $title = '', $subtitle = '', $separator = '<br/>', $thumnbnail = '' ) {
	$link_text  = sprintf(__('<a href="%s" title="%s">'), $href, $title);
	$link_text .= $thumnbnail;
	$link_text .= sprintf(__('<span class="title">%s</span>'), $title);
	if ($subtitle != '') {
		$link_text .= $separator;
		$link_text .= sprintf(__('<span class="subtitle">%s</span>'), $subtitle);
	}
	$link_text .= "</a>";
	return $link_text;
}


/*--------------------------------------------------------------------------------------
*
*	Update term counts (call this if term updates are made on the DB directly
* 
*-------------------------------------------------------------------------------------*/

//$myterms = array (790, 791, 792, 793, 794, 795, 796, 797, 798, 799, 800, 801, 802, 803, 804, 805, 806, 807, 808, 809);
//wp_update_term_count($myterms);


?>