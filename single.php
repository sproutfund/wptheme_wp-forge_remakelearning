<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header();
get_template_part( 'header', 'banner' );
?>

	<section class="container row" role="document">
		<div id="content" class="medium-8 large-8 columns" role="main">
			
		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php get_template_part( 'post', 'thumbnail' ); ?>
				</header><!-- .entry-header -->

				<div class="entry-summary">
					<?php
						if( get_field('summary_statement') ) {
							echo '<p>';
							the_field('summary_statement');
							echo '</p>';
						} else {
							the_excerpt();
						}
					?>
				</div><!-- .entry-summary -->

				<div class="entry-content">
					<?php
						$content = get_the_content();
						while( has_sub_field('post_content_alt') ) {
							if( in_array( 'casestudy', get_sub_field('post_content_alt_type') ) ) {
								// deal with case studies
							} elseif ( in_array( get_option('sprout_webdisplay'), get_sub_field('post_content_alt_type') ) ) {
								$content = get_sub_field('post_content');
								break;
							}
						}
						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]&gt;', $content);
						echo $content;
					?>
				</div><!-- .entry-content -->

				<footer class="entry-meta">
					<div class="entry-meta-footer">
						<?php wpforge_entry_meta_footer(); ?><br />
						<?php //edit_post_link( __( 'Edit', 'wpforge' ), '<span class="edit-link"><span class="genericon genericon-edit"></span> ', '</span>' ); ?>
					</div><!-- end .entry-meta-footer -->
				</footer><!-- .entry-meta -->

			</article><!-- #post -->

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

		<div id="secondary" class="medium-4 large-4 columns widget-area" role="complementary">

			<?php
				global $display_post_type; 
				$display_post_type = $post->post_type; 

					switch ($display_post_type) {
						case 'post' :
						case 'documentation' :
							locate_template( 'widgets/share.php', true );
							locate_template( 'widgets/author.php', true );
							locate_template( 'widgets/subscribe_blog.php', true );
							locate_template( 'widgets/recent_posts.php', true );
							//get_sidebar();
							break;
						case 'newsletter' :
							locate_template( 'widgets/share.php', true );
							//get_sidebar();
							break;
						case 'person' :
							locate_template( 'widgets/contact_info.php', true );
							locate_template( 'widgets/affiliations.php', true );
							locate_template( 'widgets/projects.php', true );
							break;
						case 'project' :
							switch (get_option( 'sprout_webdisplay' )) {
								case 'remakelearning' :
									locate_template( 'widgets/quick_facts-project.php', true );
									locate_template( 'widgets/parent_org.php', true );
									locate_template( 'widgets/team.php', true );
									locate_template( 'widgets/partners.php', true );
									locate_template( 'widgets/funders.php', true );
									break;
								case 'hivepgh' :
								case 'sparkpgh' :
									locate_template( 'widgets/quick_facts-project.php', true );
									locate_template( 'widgets/parent_org.php', true );
									locate_template( 'widgets/partners.php', true );
									//locate_template( 'widgets/related_projects.php', true );
									locate_template( 'widgets/more-on_remakelearning.php', true );
									break;
							}
							break;
						case 'organization' :
							locate_template( 'widgets/contact_info.php', true );
							locate_template( 'widgets/projects.php', true );
							locate_template( 'widgets/people.php', true );
							break;
						case 'place' :
							locate_template( 'widgets/contact_info.php', true );
							break;
						case 'opportunity' :
							locate_template( 'widgets/opportunity_info.php', true );
							locate_template( 'widgets/registration.php', true );
							//locate_template( 'widgets/contact_info.php', true );
							//locate_template( 'widgets/affiliations.php', true );
							locate_template( 'widgets/for_more_info.php', true );
							locate_template( 'widgets/host.php', true );
							locate_template( 'widgets/partners.php', true );
							locate_template( 'widgets/funders.php', true );
							break;
						case 'resource' :
							locate_template( 'widgets/resource_info.php', true );
							//locate_template( 'widgets/keywords-definitions.php', true );
							locate_template( 'widgets/resource_equip_req.php', true );
							locate_template( 'widgets/resource_digital_literacies.php', true );
							locate_template( 'widgets/for_more_info.php', true );
							break;
						default:
							//get_sidebar();
							break;
					}
			?>

		</div><!-- #secondary -->
	</section>
		
<?php get_footer(); ?>