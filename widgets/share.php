<?php
global $post, $display_post_type;

$widget_name  = 'share';
$widget_title = 'Share This';

$title     = get_the_title();
$titlesite = $title.' | remakelearning.org';
$permalink = get_permalink();
$twitter_share   = "http://twitter.com/home?status=$title%20$permalink";
$facebook_share  = "http://www.facebook.com/sharer/sharer.php?u=$permalink";
$google_share    = "http://google.com/bookmarks/mark?op=edit&amp;bkmk=$permalink";
$linkedin_share  = "http://linkedin.com/shareArticle?mini=true&amp;url=$permalink";
$pinterest_share = "http://pinterest.com/pin/create/button/?url=$permalink&media=";
$email_share     = "mailto:?subject=$titlesite&body=$permalink";

sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
?>
	<div class="row">
		<div class="columns small-6">
			<p><a target="_blank" class="twitter-share"  href="<?php echo $twitter_share; ?>">Twitter</a></p>
			<p><a target="_blank" class="facebook-share" href="<?php echo $facebook_share; ?>">Facebook</a></p>
			<p><a target="_blank" class="google-share" href="<?php echo $google_share; ?>">Google</a></p>
		</div>
		<div class="columns small-6">
			<p><a target="_blank" class="linkedin-share" href="<?php echo $linkedin_share; ?>">LinkedIn</a></p>
			<p><a target="_blank" class="pinterest-share" href="<?php echo $pinterest_share; ?>">Pinterest</a></p>
			<p><a class="email-share" href="<?php echo $email_share; ?>">Email</a></p>	
		</div>
	</div>
<?php
sprout_sidebar_text_widget_close();
?>