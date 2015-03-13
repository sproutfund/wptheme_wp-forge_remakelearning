<?php

// dropcap
function pax_remove_shortcode( $atts, $content = null ) {
	return do_shortcode($content);
}
add_shortcode( 'dropcap',           'pax_remove_shortcode' );
add_shortcode( 'one_third',         'pax_remove_shortcode' );
add_shortcode( 'one_third_last',    'pax_remove_shortcode' );
add_shortcode( 'two_third',         'pax_remove_shortcode' );
add_shortcode( 'two_third_last',    'pax_remove_shortcode' );

// blockquote
function pax_shortcode_blockquote( $atts , $content = null ) {
	return "<blockquote>$content</blockquote>";
}
add_shortcode( 'blockquote', 'pax_shortcode_blockquote' );

// list
function pax_shortcode_list( $atts , $content = null ) {
	$defaults = array(
		'icon' => 'star',
	);
  extract(shortcode_atts($defaults, $atts));
	
	global $styled_list_icon;
	$styled_list_icon = $icon;
		
	return '<ul>'.do_shortcode($content).'</ul>';
}
add_shortcode( 'list', 'pax_shortcode_list' );

// list-item
function pax_shortcode_list_item( $atts , $content = null ) {
	$defaults = array(
		'icon' => 'star',
	);
  extract(shortcode_atts($defaults, $atts));
	
	global $styled_list_icon;
	if ($icon == null) {
		$icon = $styled_list_icon;
	}
	$icon = 'icon-' . $icon;
		
	return '<li class="'.$icon.'">'.do_shortcode($content).'</li>';
}
add_shortcode( 'list_item', 'pax_shortcode_list_item' );


?>