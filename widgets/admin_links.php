<?php
global $post, $display_post_type;

$widget_name  = 'adminlinks';
$widget_title = 'Admin Links';

$mailviewlink = get_permalink();
if ( in_str( '?', $mailviewlink ) ) {
	$mailviewlink .= '&mail-format=';
} else {
	$mailviewlink .= '?mail-format=';
}

sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );

?>
	<div style="clear: both;">
		<div class="icon-shortcode " style="background-color: transparent">
			<i class="icon-picture" style="color: #212121"></i>
		</div>
		<div class="icon-shortcode-content">
			<a target="_blank" href="<?php echo $mailviewlink.'html'; ?>" style="color: #212121">
				<span style="font-weight: 700">View as HTML email</span>
			</a>
		</div>
	</div>
	<div style="clear: both;">
		<div class="icon-shortcode " style="background-color: transparent">
			<i class="icon-font" style="color: #212121"></i>
		</div>
		<div class="icon-shortcode-content">
			<a target="_blank" href="<?php echo $mailviewlink.'text'; ?>" style="color: #212121">
				<span style="font-weight: 700">View as plain text email</span>
			</a>
		</div>
	</div>
<?php
sprout_sidebar_text_widget_close();
?>