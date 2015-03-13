<?php
/*
header('content-type:text/html;charset:utf-8');
function compress($buffer) {
	return preg_replace('~>\s*\n\s*<~', '><', $buffer);
}
ob_start("compress");
*/
?>
<?php
/**
 * The Header template of our theme.
 *
 * Displays all of the <head> section and everything up till <section class="container row" role="document">
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.3.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="google-site-verification" content="zdDnx8XjyNgbOLBS-A6HqjjUPShzh2uCdHlyVx-VAec" />
	<title><?php wp_title('&ndash;', true, 'right'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>    
	<!--Search Modal-->
	<div id="searchModal" class="reveal-modal large" data-reveal="">
		<div class="row">
			<div class="columns">
				<h2>Search</h2>
				<?php get_template_part( 'searchform' ); ?>
			</div>
		</div>
		<a class="close-reveal-modal">x</a>
	</div>
	<?php get_template_part( 'content', 'off_canvas' ); ?>
	<?php if( get_theme_mod( 'wpforge_nav_position' ) == 'top') { ?>
		<?php get_template_part( 'content', 'nav' ); ?>
	<?php } // end if ?>
	<?php if( get_theme_mod( 'wpforge_nav_position' ) == 'fixed') { ?>
			<?php get_template_part( 'content', 'nav' ); ?>
	<?php } // end if ?>    
	<div id="wrapper">
		<?php if( get_theme_mod( 'wpforge_nav_position' ) == 'normal') { ?>
				<?php get_template_part( 'content', 'nav' ); ?>
		<?php } // end if ?>
		<?php if( get_theme_mod( 'wpforge_nav_position' ) == 'sticky') { ?>
				<?php get_template_part( 'content', 'nav' ); ?>
		<?php } // end if ?>