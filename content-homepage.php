<?php
	global $id;
	
	$blog_entries_max = 5;
	$recent_news_max  = 4;
	
	$homepage_items = array(
		'blog_entries',
		'recent_news',
		'network_spotlight'
	);
	$homepage_post_ids = array(
		'blog_entries',
		'recent_news',
		'network_spotlight'
	);
	$homepage_content = array();
	foreach( $homepage_items as $homepage_item ) {
		while( has_sub_field( $homepage_item, $id ) ) {
			$post_id   = 0;
			$post_date = '9999-12-31';
			$image_id  = 0;
			$title     = '';
			$subtitle  = '';
			$excerpt   = '';
			$author    = '';
			$url       = '';
			if( get_row_layout() == 'post_object' ) {
				$post_type = get_sub_field('post_type');
				$post_obj  = get_sub_field($post_type.'_id');
				$post_id   = $post_obj->ID;
				$post_date = $post_obj->post_date;
				$image_id  = get_sub_field('image')    ?: get_post_thumbnail_id($post_id);
				$title     = get_sub_field('title')    ?: get_the_title($post_id);
				$subtitle  = get_sub_field('subtitle') ?: get_the_summary_stmt($post_id, true, false, false);
				$excerpt   = get_sub_field('excerpt')  ?: $post_obj->post_excerpt;
				$author    = sprout_get_custom_author_info($post_id);
				$url       = get_sub_field('url')      ?: get_permalink($post_id);
				$anchor    = get_sub_field('page_anchor');
				if( $anchor ) {
					if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
					$url .= $anchor;
				}
				$homepage_post_ids[$homepage_item][] = $post_id;
			}
			elseif( get_row_layout() == 'nondirectory_content' ) {
					$image_id = get_sub_field('image');
					$title    = get_sub_field('title');
					$subtitle = get_sub_field('subtitle');
					$excerpt  = get_sub_field('excerpt');
					$url      = get_sub_field('url');
					$anchor   = get_sub_field('page_anchor');
					if( $anchor ) {
						if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
						$url .= $anchor;
					}
			}
			$homepage_content[$homepage_item][] = array(
				'post_id'   => $post_id,
				'post_date' => $post_date,
				'image_id'  => $image_id,
				'title'     => $title,
				'subtitle'  => $subtitle,
				'excerpt'   => wpautop($excerpt),
				'author'    => $author,
				'url'       => $url
			);
		}
	}
	while( has_sub_field( 'featured_opportunities', 'option' ) ) {
		$post_id   = 0;
		$post_date = '9999-12-31';
		$image_id  = 0;
		$title     = '';
		$subtitle  = '';
		$excerpt   = '';
		$author    = '';
		$url       = '';
		if( get_row_layout() == 'post_object' ) {
			$post_type = 'opportunity';
			$post_obj  = get_sub_field($post_type.'_id');
			$post_id   = $post_obj->ID;
			$post_date = $post_obj->post_date;
			$image_id  = get_sub_field('image')    ?: get_post_thumbnail_id($post_id);
			$title     = get_sub_field('title')    ?: get_the_title($post_id);
			$subtitle  = get_sub_field('subtitle') ?: get_the_summary_stmt($post_id, true, false, false);;
			$excerpt   = get_sub_field('excerpt')  ?: $post_obj->post_excerpt;
			$author    = sprout_get_custom_author_info($post_id);
			$url       = get_sub_field('url')      ?: get_permalink($post_id);
			$anchor    = get_sub_field('page_anchor');
			if( $anchor ) {
				if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
				$url .= $anchor;
			}
			$homepage_post_ids[] = $post_id;
		}
		elseif( get_row_layout() == 'nondirectory_content' ) {
				$image_id = get_sub_field('image');
				$title    = get_sub_field('title');
				$subtitle = get_sub_field('subtitle');
				$excerpt  = get_sub_field('excerpt');
				$url      = get_sub_field('url');
				$anchor   = get_sub_field('page_anchor');
				if( $anchor ) {
					if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
					$url .= $anchor;
				}
		}
		if( strtotime($post_date) >= time() ) {
			$homepage_content['featured_opportunities'][] = array(
				'post_id'   => $post_id,
				'post_date' => $post_date,
				'image_id'  => $image_id,
				'title'     => $title,
				'subtitle'  => $subtitle,
				'excerpt'   => wpautop($excerpt),
				'author'    => $author,
				'url'       => $url
			);
		}		
	}

	if( count( $homepage_content['blog_entries'] ) < $blog_entries_max ) {
		$blog_entries_auto = new WP_Query( array( 
			'post_type' => 'post',
			'post__not_in' => $homepage_post_ids['blog_entries'],
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => array('blog', 'commissioned'),
				),
			),
			'posts_per_page' => ( $blog_entries_max - count( $homepage_content['blog_entries'] ) ),
			'orderby' => 'date',
			'order' => 'DESC'
		));
		foreach( $blog_entries_auto->posts as $post_obj ) {
			$post_type = $post_obj->post_type;
			$post_id   = $post_obj->ID;
			$post_date = $post_obj->post_date;
			$image_id  = get_sub_field('image')    ?: get_post_thumbnail_id($post_id);
			$title     = get_sub_field('title')    ?: get_the_title($post_id);
			$subtitle  = get_sub_field('subtitle') ?: get_the_summary_stmt($post_id, true, false, false);
			$excerpt   = get_sub_field('excerpt')  ?: $post_obj->post_excerpt;
			$author    = sprout_get_custom_author_info($post_id);
			$url       = get_sub_field('url')      ?: get_permalink($post_id);
			$anchor    = get_sub_field('page_anchor');
			if( $anchor ) {
				if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
				$url .= $anchor;
			}
			$homepage_post_ids['blog_entries'][] = $post_id;
			$homepage_content['blog_entries'][] = array(
				'post_id'   => $post_id,
				'post_date' => $post_date,
				'image_id'  => $image_id,
				'title'     => $title,
				'subtitle'  => $subtitle,
				'excerpt'   => wpautop($excerpt),
				'author'    => $author,
				'url'       => $url
			);
		}
	}
	
	if( count( $homepage_content['recent_news']  ) < $recent_news_max ) {
		$recent_news_auto  = new WP_Query( array( 
			'post_type' => 'post',
			'post__not_in' => array_merge( $homepage_post_ids['blog_entries'], $homepage_post_ids['recent_news']),
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => array('shared'),
				),
			),
			'posts_per_page' => ( $recent_news_max - count( $homepage_content['recent_news'] ) ),
			'orderby' => 'date',
			'order' => 'DESC'
		));
		foreach( $recent_news_auto->posts as $post_obj ) {
			$post_type = $post_obj->post_type;
			$post_id   = $post_obj->ID;
			$post_date = $post_obj->post_date;
			$image_id  = get_sub_field('image')    ?: get_post_thumbnail_id($post_id);
			$title     = get_sub_field('title')    ?: get_the_title($post_id);
			$subtitle  = get_sub_field('subtitle') ?: get_the_summary_stmt($post_id, true, false, false);
			$excerpt   = get_sub_field('excerpt')  ?: $post_obj->post_excerpt;
			$author    = sprout_get_custom_author_info($post_id);
			$url       = get_sub_field('url')      ?: get_permalink($post_id);
			$anchor    = get_sub_field('page_anchor');
			if( $anchor ) {
				if( left($anchor,1) != '#' ) { $anchor = '#'.$anchor; }
				$url .= $anchor;
			}
			$homepage_post_ids['recent_news'][] = $post_id;
			$homepage_content['recent_news'][] = array(
				'post_id'   => $post_id,
				'post_date' => $post_date,
				'image_id'  => $image_id,
				'title'     => $title,
				'subtitle'  => $subtitle,
				'excerpt'   => wpautop($excerpt),
				'author'    => $author,
				'url'       => $url
			);
		}
	}
	
	echo '<!--';
	print_r($homepage_content);
	echo '-->';
	
?>
	<section class="container row" role="document">
		<div id="content" class="columns medium-12" role="main">
		
			<div id="front-page-content">

				<section id="above-the-fold">
				
					<!--Ryan edit styles here-->
					<style type="text/css">
						#front-page-content #about-rml .row {
							/*padding-top:      .75rem;
							padding-bottom:   .25rem;*/
						}
						#front-page-content #about-rml p {
							color: #333333;
							margin-bottom: .5rem;
							font-weight: 400;
						}
						#front-page-content #about-rml p a:link,
						#front-page-content #about-rml p a:active,
						#front-page-content #about-rml p a:visited {
							color: #333333;
							font-weight: 600;
						}
					</style>
				
					<section id="about-rml"><!--About Remake Full[yellow]-->
						<div class="row white">
							<div class="columns medium-12 no-pad-both">
								<p><span style="font-weight: 600; font-size: 120%; color: #333333;">Remake Learning</span> is a resource for the people, organizations, and ideas shaping the future of teaching and learning in the greater Pittsburgh region. Read stories about learning innovation on our <a href="/blog/">blog</a> and in the <a href="/news/">news</a>, browse upcoming <a href="/calendar/">events and opportunities</a>, and connect to <a href="/resources/">resources</a> and network <a href="/people/">members</a> in Pittsburgh, West Virginia, and beyond.</p>
							</div>
						</div>
					</section>

					<section id="blog-entries"><!--Cover Stories [blue]-->

						<div class="row dark-blue">
							<div class="columns medium-7 no-pad-both blue" id="cover_story_primary-area">
								<div class="columns medium-12 no-pad-both" id="cover_story_primary-image">
									<figure class="image-container">
										<a href="<?php echo $homepage_content['blog_entries'][0]['url']; ?>">
											<?php the_responsive_image( $homepage_content['blog_entries'][0]['image_id'], $image_type = 'single-feature', $image_classes = 'post-featured-image', $show_caption = false, $wrap_figure = false ); ?>
											<div class="overlay-caption dark-blue double-size hide-for-small-only">
												<figcaption>
													<span class="caption-primary"><?php echo $homepage_content['blog_entries'][0]['title']; ?></span>
													<span class="caption-secondary right show-for-large-up" style="font-style: italic;"><?php echo $homepage_content['blog_entries'][0]['subtitle']; ?></span>
													<!--<span class="caption-secondary"><?php echo $homepage_content['blog_entries'][0]['subtitle']; ?></span>-->
												</figcaption>
											</div>
										</a>
									</figure>
								</div>
								<div class="columns medium-5 blue" id="cover_story_primary-excerpt" style="display: none;">
									<aside class="hide-for-small-only" >
										<?php echo $homepage_content['blog_entries'][0]['excerpt']; ?>
										<?php echo '<p class="right" style="font-style: italic;">'.date('F j, Y', strtotime($homepage_content['blog_entries'][0]['post_date'])).'</p>'; ?>
									</aside>
								</div>
							</div>
							<div class="columns medium-5 dark-blue" id="more-blog_entries">
								<div class="row blue hide-for-small-only">
									<div class="columns medium-12">
										<div class="front-page-heading right">
											Recent Blog Posts
										</div>
									</div>
								</div>
								<div class="row dark-blue">
									<div class="columns medium-12">
										<?php foreach( $homepage_content['blog_entries'] as $blog_entry ) : ?>
											<?php $hide_first_item = ( $homepage_content['blog_entries'][0] === $blog_entry ) ? 'show-for-small-only' : ''; ?>
											<?php $hide_fifth_item = ( $homepage_content['blog_entries'][4] === $blog_entry ) ? 'show-for-large-up' : ''; ?>
											<div class="row <?php echo $hide_first_item; echo $hide_fifth_item; ?>" style="padding-top: .6rem;">
												<div class="columns medium-8">
													<i class="fa fa-chevron-right"></i>
													<a href="<?php echo $blog_entry['url']; ?>">
														<?php echo $blog_entry['title']; ?>
													</a>
												</div>
												<div class="columns medium-4 hide-for-small-only">
													<?php the_responsive_image( $blog_entry['image_id'], $image_type = 'miniature', $image_classes = '', $show_caption = false, $wrap_figure = false ); ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>

					</section>

				</section>
				
				<section id="below-the-fold">

					<div class="row">

						<div class="columns medium-4 medium-push-8" id="medium-right-sidebar">
						
							<section id="get-involved">
								<div class="row"><!--Get Involved Top [grey]-->
									<div class="columns medium-12 dark-grey">
										<div class="front-page-heading right">
											Get Involved
										</div>
									</div>
									<div class="columns medium-12 grey">
										<ul style="font-weight: 600; font-size: 120%; list-style-type: none; margin-left: 0; color: #bababa; margin-top: .75rem;">
											<!--<li><i class="fa fa-star"></i>&nbsp;&nbsp;<a href="#"  data-reveal-id="homeModal-join" title="Join">About Remake Learning</a></li>-->
											<li><i class="fa fa-users"></i>&nbsp;&nbsp;<a href="#"  data-reveal-id="homeModal-join" title="Join">Join the Network</a></li>
											<li><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;<a href="#" data-reveal-id="homeModal-follow">Follow Us Online</a></li>
											<li><i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="#" data-reveal-id="homeModal-subscribe">Subscribe to Blog/Newsletter</a></li>
											<li><i class="fa fa-dollar"></i>&nbsp;&nbsp;&nbsp;<a href="#"  data-reveal-id="homeModal-funding" title="Funding">Seek Funding</a></li>
											<li><i class="fa fa-share-square"></i>&nbsp;&nbsp;<a href="#" data-reveal-id="homeModal-partners">Visit Partner Websites</a></li>
										</ul>
									</div>
								</div>
								
								<!--HOME MODALS START-->
								
								<!--Join Modal-->
								<div id="homeModal-join" class="reveal-modal medium" data-reveal="">
									<div class="row">
										<div class="small-12 columns">
											<h2 id="Join">Join the Network</h2>
											<h5 class="subheader">Be part of the movement to remake learning in the greater Pittsburgh region.</h5>
											<div class="row">
												<div class="small-12 columns">
													<div class="row circle-list">
														<div class="medium-4 columns">
															<h4>Get Listed</h4>
															<p>Browse a full directory of people, projects, and organizations active in the network.</p>
															<ul>
																<li><a href="/people/add-person/" target="_blank">Add a person</a></li>
																<li><a href="/organizations/add-organization/" target="_blank">Add an organization</a></li>
																<li><a href="/projects/add-project/" target="_blank">Add a project or program</a></li>
															</ul>
														</div>
														<div class="medium-4 columns">
															<h4>Get Involved</h4>
															<p>Meet other network members face to face at upcoming events and activities, or host your own.</p>
															<ul>
																<li><a href="/calendar/" target="_blank">Attend an upcoming event</a></li>
																<li><a href="/calendar/add-event/" target="_blank">Add an event to the calendar</a></li>
															</ul>
														</div>
														<div class="medium-4 columns">
															<h4>Get Connected</h4>
															<p>Find collaborators, share ideas, and inquire about additional support services.</p>
															<ul>
																<!--<li><a href="#" target="_blank">Join the Remake Learning Google Community</a></li>-->
																<li><a href="mailto:connect@sproutfund.org">Contact The Sprout Fund</a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<a class="close-reveal-modal">x</a>
								</div>
								
								<!--Follow Modal-->
								<div id="homeModal-follow" class="reveal-modal medium" data-reveal="">
									<div class="row">
										<div class="columns">
											<h2>Follow Remake Learning Online</h2>
											<h5 class="subheader">Stay connected and join the conversation on social media.</h5>
											<div class="row">
												<div class="medium-4 columns">
													<h4>Twitter</h4>
													<p>Follow <a href="http://twitter.com/remakelearning" target="_blank">@RemakeLearning</a> on Twitter and join the conversation. Show us what <strong>#LearningRemade</strong> looks like.</p>
												</div>
												<div class="medium-4 columns">
													<h4>Facebook</h4>
													<p>Like <a href="http://www.facebook.com/remakelearning" target="_blank">Remake Learning</a> on Facebook and share stories about learning in the 21st century.</p>
												</div>
												<div class="medium-4 columns">
													<h4>Follow our Partners</h4>
													<ul>
														<li><a href="https://twitter.com/cntr4creativity" target="_blank">@cntr4creativity</a></li>
														<li><a href="https://twitter.com/FredRogersCtr" target="_blank">@FredRogersCtr</a></li>
														<li><a href="https://twitter.com/hivepgh" target="_blank">@hivepgh</a></li>
														<li><a href="https://twitter.com/pghtech" target="_blank">@pghtech</a></li>
														<li><a href="https://twitter.com/sproutfund" target="_blank">@sproutfund</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<a class="close-reveal-modal">x</a>
								</div>									
								
								<!--Subscribe Modal-->
								<div id="homeModal-subscribe" class="reveal-modal medium" data-reveal="">
									<div class="row">
										<div class="large-12 medium-12 columns">
											<h4>Subscribe to the blog</h4>
											<form action="#" method="post" accept-charset="utf-8" id="subscribe-blog-blog_subscription-2">
												<p class="lead">Enter your email address below to get the latest posts from the Remake Learning blog.</p>
												<p id="subscribe-email">
													<input id="subscribe-field" type="text" onblur="if ( this.value == '' ) { this.value = 'Email Address'; }" onclick="if ( this.value == 'Email Address' ) { this.value = ''; }" value="Email Address" name="email"></input>
												</p>
												<p id="subscribe-submit">
													<input type="hidden" name="action" value="subscribe">
													<input type="hidden" name="source" value="http://remakelearning.org/">
													<input type="hidden" name="sub-type" value="widget">
													<input type="hidden" name="redirect_fragment" value="blog_subscription-2">
													<input type="hidden" id="_wpnonce" name="_wpnonce" value="3ef0ced440">
													<input type="submit" value="Subscribe to Blog" name="jetpack_subscriptions_widget" class="tiny button round">
												</p>
											</form>											
										</div>
									</div>
									<div class="row">
										<div class="large-12 medium-12 columns">
											<!-- Begin MailChimp Signup Form -->
											<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css" />
											<style type="text/css">
												#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
												/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
												 We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
											</style>
											<div id="mc_embed_signup">
												<form action="//sparkpgh.us4.list-manage.com/subscribe/post?u=d88590060b35162f56ec6156c&amp;id=bdb42114c1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
													<h4>Sign up to email list</h4>
													<p class="lead">Enter your email address below to receive the weekly Remake Learning newsletter and occasional event alerts.</p>
													<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
													<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
													<div style="position: absolute; left: -5000px;"><input type="text" name="b_d88590060b35162f56ec6156c_bdb42114c1" tabindex="-1" value=""></div>
													<div class="clear"><input type="submit" value="Sign up for Email" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
												</form>
											</div>
											<!--End mc_embed_signup-->
										</div>
									</div>
									<a class="close-reveal-modal">x</a>
								</div>
								
								<!--Funding Modal-->
								<div id="homeModal-funding" class="reveal-modal medium" data-reveal="">
									<div class="row">
										<div class="small-12 columns">
											<h2 id="Join">Seek Funding</h2>
											<h5 class="subheader">Take advantage of new funding opportunities are available to help advance learning innovation.</h5>
											<div class="row">
												<div class="small-12 columns">
												<div class="row circle-list">
													<div class="medium-4 columns">
														<h4>For Schools</h4>
														<p>Transform a classroom, a school building, or a whole district with the help of these funding sources.</p>
														<ul>
														<li><p><a href="http://centerforcreativity.net/steam-grants/" target="_blank">STEAM Grants</a> support classroom and curricular transformation.</p></li>
														<li><p><a href="http://www.theconsortiumforpubliceducation.org/great_idea.html" target="_blank">Great Idea Grants</a> help educators implement creative ideas for deeper learning.</p></li>
														</ul>
														</div>
													<div class="medium-4 columns">
														<h4>For Nonprofits</h4>
														<p>Catalyze learning innovation at museums, libraries, and informal learning sites (and in schools, too!).</p>
														<ul>
														<li><p><a href="http://www.sproutfund.org/apply/catalytic-funding/spark/" target="_blank">Spark grants</a> for children ages 10 and younger.</p></li>
														<li><p><a href="http://www.sproutfund.org/apply/catalytic-funding/hive/" target="_blank">Hive grants</a> for youth ages 10 and older.</p></li>
														</ul>
													</div>
													<div class="medium-4 columns">
														<h4>For People</h4>
														<p>Develop your own educational practice or leadership potential with.</p>
														<ul>
														<li><p><a href="http://www.sproutfund.org/apply/#stipends-fellowships" target="_blank">Conference Stipends</a> help send people to national events.</p></li>
														<li><p><a href="http://www.sproutfund.org/apply/#stipends-fellowships" target="_blank">Research Fellowships</a> support scholars studying learning innovation.</p></li>
														</ul>
													</div>
												</div>
												</div>
											</div>
										</div>
									</div>
									<a class="close-reveal-modal">x</a>
								</div>

								<!--Partner Modals-->
								<div id="homeModal-partners" class="reveal-modal medium" data-reveal="">
									<div class="row">
										<div class="large-12 medium-12 columns">
											<h3>Partners</h3>
											<p>Remake Learning is the voice of the Kids+Creativity Network: more than 200 organizations working together to advance learning innovation in Pittsburgh and the surrounding communities of Southwevern Pennsylvania and West Virginia.</p>
											<p>Learn more about the people, projects, and organizations that make up the <a href="/network/">network</a>, including these:</p>
											<?php include 'content-homepage_partner-logos.php'; ?>
										</div>
									</div>
									<a class="close-reveal-modal">x</a>
								</div>

								<!--HOME MODALS END-->
								
							</section>

							<section id="upcoming-events">
						
								<div class="row"><!--Events Top [orange]-->
									<div class="columns medium-12 orange">
										<div class="front-page-heading right">
											What's Happening
										</div>
									</div>
								</div>
							
								<?php $opp_count = 0; foreach( $homepage_content['featured_opportunities'] as $featured_opportunity ) : ?>
									<?php if( $opp_count < 4 ) : ?>
									<div class="row"><!--Event [orange]-->
										<div class="columns medium-12 no-pad-both dark-grey">
											<figure class="image-container">
												<a href="<?php echo $featured_opportunity['url']; ?>">
													<?php the_responsive_image( $featured_opportunity['image_id'], $image_type = 'collection-hero', $image_classes = 'post-featured-image', $show_caption = false, $wrap_figure = false ); ?>
													<div class="overlay-caption dark-orange">
														<figcaption>
															<span class="caption-primary"><?php echo $featured_opportunity['title']; ?></span>
															<span class="caption-secondary"><?php echo $featured_opportunity['subtitle']; ?></span>
														</figcaption>
													</div>
												</a>
											</figure>
										</div>
									</div>
									<?php $opp_count++; endif; ?>
								<?php endforeach; ?>
								
								<div class="row"><!--Events Bottom [orange]-->
									<div class="columns medium-12 dark-orange no-pad-both">
										<div class="front-page-heading" id="upcoming-events-more">
											<a href="/calendar"><i class="fa fa-calendar"></i>&nbsp;&nbsp;all events, activities &amp; opportunities</a>
										</div>
									</div>
								</div>
							
							</section>
						
						</div>

						<div class="columns medium-8 medium-pull-4">
						
							<section id="recent-news"><!--News [purple]-->
								<div class="row dark-purple hide-for-large-up">
									<div class="columns">
										<div class="front-page-heading">
											In the News
										</div>
									</div>
								</div>
								<div class="row purple">
									<div class="columns large-8 large-push-4 no-pad-both purple" id="cover_story_secondary-area">
										<div class="columns large-12 no-pad-both" id="cover_story_secondary-image">
											<figure class="image-container">
												<a href="<?php echo $homepage_content['recent_news'][0]['url']; ?>" target="_blank">
													<?php the_responsive_image( $homepage_content['recent_news'][0]['image_id'], $image_type = 'collection-hero', $image_classes = 'post-featured-image', $show_caption = false, $wrap_figure = false ); ?>
													<div class="overlay-caption dark-purple hide-for-small-only">
														<figcaption>
															<span class="caption-primary"><?php echo $homepage_content['recent_news'][0]['title']; ?></span>
															<span class="caption-secondary"><?php echo $homepage_content['recent_news'][0]['subtitle']; ?></span>
														</figcaption>
													</div>
												</a>
											</figure>
										</div>
										<div class="columns large-4 large-pull-8 purple" id="cover_story_secondary-excerpt" style="display: none;">
											<aside class="hide-for-small-only" ><?php echo $homepage_content['recent_news'][0]['excerpt']; ?></aside>
										</div>
									</div>
									<div class="columns large-4 large-pull-8 purple" id="more-recent_news">
										<div class="row dark-purple show-for-large-up">
											<div class="columns large-12">
												<div class="front-page-heading">
													In the News
												</div>
											</div>
										</div>
										<div class="row purple">
											<div class="columns large-12">
												<ul>
													<?php foreach( $homepage_content['recent_news'] as $news_item ) : ?>
														<?php $hide_first_item = ( $homepage_content['recent_news'][0] === $news_item ) ? 'show-for-small-only' : ''; ?>
														<?php //$hide_fourth_item = ( $homepage_content['recent_news'][3] === $news_item ) ? 'show-for-large-up' : ''; ?>
														<li class="<?php echo $hide_first_item; //echo $hide_fourth_item; ?>" style="padding-top: .4rem;">
															<a href="<?php echo $news_item['url']; ?>" target="_blank">
																<?php echo $news_item['title']; ?><?php echo ( $news_item['subtitle'] != '' ) ? '<span style="opacity: 0.8" class="show-for-large-up">—<i>'.$news_item['subtitle'].'</i></span>' : ''; ?> 
															</a>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							
							</section>

							<section id="case-studies"><!--Learning Remade [red]-->
								<div class="row">
									<div class="columns medium-12">
										<div class="row">
											<div class="columns medium-12 red">
												<a href="/case-studies/">
													<div class="front-page-heading">
														Learning Remade
													</div>
												</a>
											</div>
											<div class="columns medium-4 no-pad-both white">
												<figure class="image-container">
													<a href="/case-studies/#case-studies-in-schools">
														<img src="http://cloudfront.sproutfund.org/files/2014/09/home-solder.jpg">
														<div class="overlay-caption dark-red">
															<figcaption>in the classroom</figcaption>
														</div>
													</a>
												</figure>
											</div>
											<div class="columns medium-4 no-pad-both white">
												<figure class="image-container">
													<a href="/case-studies/#case-studies-at-museums-libraries">
														<img src="http://cloudfront.sproutfund.org/files/2014/09/home-dino.jpg">
														<div class="overlay-caption dark-red">
															<figcaption>at the museum</figcaption>
														</div>
													</a>
												</figure>
											</div>
											<div class="columns medium-4 no-pad-both white">
												<figure class="image-container">
													<a href="/case-studies/#case-studies-in-communities-online">
														<img src="http://cloudfront.sproutfund.org/files/2014/09/home-interview.jpg">
														<div class="overlay-caption dark-red">
															<figcaption>in the community</figcaption>
														</div>
													</a>
												</figure>
											</div>
										</div>								
									</div>
								</div>
							</section>

							<section id="network-spotlight" class="white"><!--Network Spotlight Heading [green]-->
								<div class="row dark-green"><!--Network Spotlight Heading [green]-->
									<div class="columns medium-12">
										<a href="/network/">
											<div class="front-page-heading">
												Get to Know the Network
											</div>
										</a>
									</div>
								</div>
								<div class="row green"><!--Network Spotlight 1 [green]-->
									<div class="columns large-8 no-pad-both">
										<figure class="image-container">
											<a href="<?php echo $homepage_content['network_spotlight'][0]['url']; ?>">
												<?php the_responsive_image( $homepage_content['network_spotlight'][0]['image_id'], $image_type = 'collection-hero', $image_classes = 'post-featured-image', $show_caption = false, $wrap_figure = false ); ?>
												<div class="overlay-caption dark-green">
													<figcaption>
														<span class="caption-primary"  ><?php echo $homepage_content['network_spotlight'][0]['title']; ?></span>
														<span class="caption-secondary"><?php echo $homepage_content['network_spotlight'][0]['subtitle']; ?></span>
													</figcaption>
												</div>
											</a>
										</figure>
									</div>
									<div class="columns large-4 green hide-for-small-only">
										<aside><?php echo $homepage_content['network_spotlight'][0]['excerpt']; ?></aside>
									</div>
								</div>
								<div class="row green"><!--Network Spotlight 2 [green]-->
									<div class="columns large-8 large-push-4 no-pad-both">
										<figure class="image-container">
											<a href="<?php echo $homepage_content['network_spotlight'][1]['url']; ?>">
												<?php the_responsive_image( $homepage_content['network_spotlight'][1]['image_id'], $image_type = 'collection-hero', $image_classes = 'post-featured-image', $show_caption = false, $wrap_figure = false ); ?>
												<div class="overlay-caption dark-green">
													<figcaption>
														<span class="caption-primary"  ><?php echo $homepage_content['network_spotlight'][1]['title']; ?></span>
														<span class="caption-secondary"><?php echo $homepage_content['network_spotlight'][1]['subtitle']; ?></span>
													</figcaption>
												</div>
											</a>
										</figure>
									</div>
									<div class="columns large-4 large-pull-8 green hide-for-small-only">
										<aside><?php echo $homepage_content['network_spotlight'][1]['excerpt']; ?></aside>
									</div>
								</div>
								<div class="row white"><!--Events Bottom [orange]-->
									<div class="columns medium-12 dark-green">
										<div class="front-page-heading" id="network-spotlight-more">
											<a href="/network"><i class="fa fa-users"></i>&nbsp;&nbsp;browse all projects, people, and organizations</a>
										</div>
									</div>
								</div>									
							</section>
							

						</div>

					</div>

				</section>

			</div>
					
		</div><!-- #content -->
	</section>
