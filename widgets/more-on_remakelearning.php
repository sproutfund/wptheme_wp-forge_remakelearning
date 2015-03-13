<?php
global $post, $display_post_type;

$widget_name  = 'more-on_remakelearning';
$widget_title = 'More on Remake Learning';

$post_id 	= get_the_ID();
$post_title = get_the_title($post_id);
$post_link  = str_replace('http://hivepgh.sproutfund.org', 'http://remakelearning.org', get_permalink($post_id));

sprout_sidebar_text_widget_open( $widget_name, $widget_title );
echo "<img src=\"http://cloudfront.sproutfund.org/images/small_petals.png\" style=\"width: 50px; float: right; border:0; margin-top: -1px;\"/><ul>Learn about the people and organizations who helped create this project and all of the other members of the Pittsburgh Kids+Creativity Network on <a href=\"$post_link\" target=\"_blank\">remakelearning.org</a>.</ul>";
sprout_sidebar_text_widget_close();
?>