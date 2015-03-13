<?php
//check for eblast format switch
$newsletter_format = $wp_query->query_vars['mail-format'];
if (isset($newsletter_format)) :
	if ($newsletter_format == 'html') : 
		locate_template( 'single-newsletter_mail-format=html.php', true );
	elseif ($newsletter_format == 'text') : 
		locate_template( 'single-newsletter_mail-format=text.php', true );
	endif;
else :
?>
<?php get_header(); ?>
<?php global $display_post_type; $display_post_type = $post->post_type; ?>


	<div id="content" class="medium-8 large-8 columns" role="main">
			
				<?php while (have_posts()) : the_post(); /* start the loop */ ?>
				
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
						<div class="post">
							<div class="post-excerpt" style="border-bottom: 0;">
								<?php echo get_the_excerpt(); ?> Your round up for the week ending <b><?php echo get_the_date('F j, Y');?></b>.
							</div>
							<div class="post-content">
								<h3 class="newsletter-heading newsletter-heading-feature-story">Feature Story</h3>
								<h4><?php the_title(); ?></h4>
								<p class="post-meta" style="font-style: italic;"><?php the_field('feature_story_byline'); ?></p>
								<?php the_content(); ?>
								<p><a href="<?php the_field('feature_story_url'); ?>">read more</a></p>

								<h3 class="newsletter-heading newsletter-heading-learning_innovation_news">Learning Innovation News</h3>
								<table>
								<?php if( get_field('learning_innovation_news_upper') ) : $i = 1; while( has_sub_field('learning_innovation_news_upper') ) : ?>
									<td valign="top" style="width: 230px; margin: 0; padding: 0; border: 0;">
										<a class="news-link" style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 14px; font-weight: bold; color: #fdb82f; text-decoration: none; width: 200px; margin: 0; padding: 0; border: 0;" href="<?php the_sub_field('url'); ?>"><img src="<?php the_sub_field('image'); ?>" style="margin: 0; padding: 0; border: 0;"/><br/><?php the_sub_field('headline'); ?></a>
									</td>
									<?php if ($i < 3) { echo '<td style="width: 10px;"></td>'; } ?>
								<? $i++; endwhile; endif; ?>
								</table>
								<br/>
								<?php if( get_field('learning_innovation_news_lower') ) : while( has_sub_field('learning_innovation_news_lower') ) : ?>
									<div class="news-item">
										<?php echo do_shortcode('[icon icon="chevron-right" color="#9f6097" show_background="false"][/icon]'); ?>
										<a class="news-link" href="<?php the_sub_field('url'); ?>"><?php the_sub_field('headline'); ?></a>: <?php the_sub_field('description'); ?>
									</div>
								<? endwhile; endif;	?>
								<div class="newsletter-action" style="border-color: #9f6097;">
									<?php echo do_shortcode('[icon icon="share" color="#ffffff" show_background="true" background="#9f6097"][/icon]'); ?>
									Have a news item to share? <a href="mailto:news@sproutfund.org">Forward it to news@sproutfund.org.</a>
								</div>

								<h3 class="newsletter-heading newsletter-heading-upcoming_events_opportunities">Upcoming Events &amp; Opportunities</h3>
								
								<?php if( get_field('feature_upcoming_events_opportunities') ) : while( has_sub_field('feature_upcoming_events_opportunities') ) : ?>
									<table>
										<td valign="top" style="width: 210px; margin: 0; padding: 0; border: 0;">				
											<a class="news-link" style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 14px; font-weight: bold; color: #fdb82f; text-decoration: none; width: 190px; margin: 0; padding: 0; border: 0;" href="<?php the_sub_field('url'); ?>"><img src="<?php the_sub_field('image'); ?>" style="margin: 0; padding: 0; border: 0;"/></a>
										</td>
										<td valign="top" style="width: 480px; margin: 0; padding: 0; border: 0;">		
											<a class="opportunity-link" style="font-family: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 14px; font-weight: bold; color: #fdb82f; text-decoration: none; width: 400px; margin: 0; padding: 0; border: 0;" href="<?php the_sub_field('url'); ?>"><?php the_sub_field('date'); ?><br/><?php the_sub_field('headline'); ?></a><br/><span class="opportunity-item"><?php the_sub_field('description'); ?> </span>
										</td>
									</table>
								<? endwhile; endif;	?>
								
								<?php if( get_field('upcoming_events_opportunities') ) : while( has_sub_field('upcoming_events_opportunities') ) : ?>
									<div class="opportunity-item">
										<?php echo do_shortcode('[icon icon="chevron-right" color="#b5c234" show_background="false"][/icon]'); ?>
										<span class="opportunity-date" style="font-weight: bold;"><?php the_sub_field('date'); ?></span>: <a class="opportunity-link" href="<?php the_sub_field('url'); ?>"><span class="opportunity-title" style="font-weight: normal;"><?php the_sub_field('headline'); ?></span></a>
										<div style="margin-left: 2em; clear:both;">
										<?php the_sub_field('description'); ?><!--<a class="opportunity-link" href="<?php the_sub_field('url'); ?>"><?php the_sub_field('url_text'); ?></a></span>-->
										</div>
									</div>
								<? endwhile; endif;	?>
								
								<div class="newsletter-action" style="border-color: #b5c234;">
									<?php echo do_shortcode('[icon icon="share" color="#ffffff" show_background="true" background="#b5c234"][/icon]'); ?>
									Have an upcoming event or opportunity to share? <a href="/calendar/add-event/">Add it to the calendar.</a>
								</div>
									
							</div>
						</div><!-- .post -->
						
					</article>
				
				<?php endwhile; /* end the loop */ ?>

	</div>
	<div id="secondary" class="medium-4 large-4 columns widget-area" role="complementary">

		<?php switch ($display_post_type) {
			case 'post' :
			case 'documentation' :
				locate_template( 'widgets/share.php', true );
				locate_template( 'widgets/author.php', true );
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
		} ?>

	</div><!-- #secondary -->
		
<?php get_footer(); endif; ?>