<?php /* Template Name: Calendar */ ?>
<?php
	$calendar_groups = array(
		'past'       => array(
			'id'       => 'past',
			'title'    => 'In the Past', // these posts should not display
			'items'    => array()
		),
		'ongoing'    => array(
			'id'       => 'ongoing',
			'title'    => 'Ongoing',
			'items'    => array()
		),
		'today-tomorrow'  => array(
			'id'       => 'today-tomorrow',
			'title'    => 'Today &amp; Tomorrow',
			'items'    => array()
		),
		'this-week'  => array(
			'id'       => 'this-week',
			'title'    => 'This Week',
			'items'    => array()
		),
		'next-week'  => array(
			'id'       => 'next-week',
			'title'    => 'Next Week',
			'items'    => array()
		),
		'this-month' => array(
			'id'       => 'this-month',
			'title'    => 'Later in the Month of '.date('F'),
			'items'    => array()
		),
		'next-month' => array(
			'id'       => 'next-month',
			'title'    => 'Next Month in '.date('F', strtotime('+1 month')),
			'items'    => array()
		),
		'later'      => array(
			'id'       => 'later',
			'title'    => 'In '.date('F', strtotime('+2 month')).' &amp; Beyond',
			'items'    => array()
		),
	);
	
	$today = getdate();
	$opp_args = array( 
		'nopaging'    => true, 
		'post_type'   => 'opportunity', 
		'post_status' => 'publish', 
		'orderby'     => 'post_date', 
		'order'       => 'ASC',
		'date_query'  => array( array(
			'after'     => array(
				'year'    => $today['year'],
				'month'   => $today['mon'],
				'day'     => $today['mday'],
			),
			'inclusive' => true,
		)),
		'tax_query'   => array( array( 
			'taxonomy'  => 'webdisplay', 
			'field'     => 'slug', 
			'terms'     => get_option('sprout_webdisplay') 
		)), 
	);
	global $post;
	$target_calendar = $post->post_name;
	if( $target_calendar == 'educators-innovators' ) {
		$opp_args['meta_query'] = array( array(
			'key'     => 'audience_filter',
			'value'   => 'a:1:{i:0;s:8:"educator";}',
			'compare' => '=',
		));
	} elseif( $target_calendar == 'youth-teens' ) {
		$opp_args['meta_query'] = array( array(
			'key'     => 'audience_filter',
			'value'   => 'a:1:{i:0;s:4:"teen";}',
			'compare' => '=',
		));
	} elseif( $target_calendar == 'children-families' ) {
		$opp_args['meta_query'] = array( array(
			'key'     => 'audience_filter',
			'value'   => 'a:1:{i:0;s:5:"child";}',
			'compare' => '=',
		));
	}
	
	$opportunities  = get_posts( $opp_args );
	
	$opportunities_arr = array();
	
	foreach( $opportunities as $opportunity ) {
		$datetime_info = get_datetime_info( $opportunity->ID );
		if( ($datetime_info[0]['date_status'] == 'today') || ($datetime_info[0]['date_status'] == 'tomorrow') ) {
			$calendar_group = 'today-tomorrow';
		} elseif( $datetime_info[0]['date_status'] != '' ) {
			$calendar_group = $datetime_info[0]['date_status'];
		} else {
			$calendar_group = 'ongoing';
		}
		$opportunities_arr[] = array(
			'post_id'        => $opportunity->ID,
			'db_datetime'    => $opportunity->post_date,
			'calendar_group' => $calendar_group,
			'datetime_type'  => $datetime_info[0]['type'],
			'date_start'     => $datetime_info[0]['date_start'],
			'date_end'       => $datetime_info[0]['date_end'],
			'time_start'     => $datetime_info[0]['time_start'],
			'time_end'       => $datetime_info[0]['time_end'],
			'is_deadline'    => ($datetime_info[0]['print']['context'] == 'Deadline: '),
			'datetime_print' => $datetime_info[0]['print']['dates'],
			'location_print' => opportunity_summary_get_location( $opportunity->ID ),
		);
	}
	foreach ($opportunities_arr as $key => $row) {
			$date_start[$key] = $row['date_start'];
			$time_start[$key] = $row['time_start'];
	}
	array_multisort($date_start, SORT_ASC, $time_start, SORT_ASC, $opportunities_arr);
	
	foreach ($opportunities_arr as $opportunity) {
		$calendar_groups[$opportunity['calendar_group']]['items'][] = $opportunity;
	}
	
	echo '<!--';
	print_r($calendar_groups);
	echo '-->';
?>


<?php get_header(); ?>

	<header id="header" class="row" role="banner"> 
		<div class="site-header columns small-12">
			<?php //get_template_part( 'header', 'breadcrumbs' ); ?>
			<div class="header-info">
				<p class="page-title"   ><?php the_title();   ?><a target="_blank" class="button secondary small" style="float: right; margin-bottom: 2px;" href="/calendar/add-event/" title="Add an event or opportunity to the Remake Learning calendar">Add Event</a></p>
				<?php the_excerpt(); ?>
			</div><!-- /.header-info -->
		</div><!-- .site-header -->
	</header><!-- #header -->
	
	<section class="container row" role="document">
		<div id="content" class="columns" role="main">

			<?php if( $target_calendar == 'calendar' ) : ?>
				<section id="browse-by-audience">
					<div class="row">
						<div class="columns medium-4">
							<div class="panel">
								<h4><a href="/calendar/educators-innovators/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Educators &amp; Innovators</a></h4>
								<p class="body-text">Funding deadlines, local and national conferences, professional development, meet ups and more</p>
							</div>
						</div>
						<div class="columns medium-4">
							<div class="panel">
								<h4><a href="/calendar/youth-teens/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Youth &amp; Teens</a></h4>
								<p class="body-text">Events, programs, drop-in learning activities, and workshops for youth and teens the Pittsburgh region</p>
							</div>
						</div>
						<div class="columns medium-4">
							<div class="panel">
								<h4><a href="/calendar/children-families/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Children &amp; Families</a></h4>
								<p class="body-text">Events, activities, programs, and family things to do with kids in the Pittsburgh region</p>
							</div>
						</div>
					</div>
				</section>
				<hr style="margin-left:  -0.9375rem; margin-right: -0.9375rem;" />
			<?php else : ?>
				<section id="browse-by-audience">
					<div class="row">
						<div class="columns medium-4">
							<?php if( $target_calendar == 'educators-innovators' ) : ?>
								<div class="panel callout">
									<h4><span class="filter-link">Showing Events <i class="fa fa-filter"></i></span>For Educators &amp; Innovators</h4>
								</div>
							<?php else : ?>
								<div class="panel">
									<h4><a href="/calendar/educators-innovators/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Educators &amp; Innovators</a></h4>
								</div>
							<?php endif; ?>
						</div>
						<div class="columns medium-4">
							<?php if( $target_calendar == 'youth-teens' ) : ?>
								<div class="panel callout">
									<h4><span class="filter-link">Showing Events <i class="fa fa-filter"></i></span>For Youth &amp; Teens</h4>
								</div>
							<?php else : ?>
								<div class="panel">
									<h4><a href="/calendar/youth-teens/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Youth &amp; Teens</a></h4>
								</div>
							<?php endif; ?>
						</div>
						<div class="columns medium-4">
							<?php if( $target_calendar == 'children-families' ) : ?>
								<div class="panel callout">
									<h4><span class="filter-link">Showing Events <i class="fa fa-filter"></i></span>For Children &amp; Families</h4>
								</div>
							<?php else : ?>
								<div class="panel">
									<h4><a href="/calendar/children-families/"><span class="filter-link">Filter <i class="fa fa-filter"></i></span>For Children &amp; Families</a></h4>
								</div>
							<?php endif; ?>
							</div>
					</div>
				</section>
				<hr style="margin-left:  -0.9375rem; margin-right: -0.9375rem;" />
			<?php endif; ?>
			<section id="browse-all" class="<?php if( $target_calendar == 'calendar' ) { echo 'hide-for-small-only'; } ?>">
				<?php foreach( $calendar_groups as $calendar_group ) : ?>
					<?php if( !empty($calendar_group['items']) ) : ?>
						<section id="<?php echo $calendar_group['id']; ?>">
							<header>
								<h3><?php echo $calendar_group['title']; ?></h3>
							</header>
							<div class="row">
								<div class="columns">
									<ul class="large-block-grid-5 medium-block-grid-4 small-block-grid-2 portfolio">
										<?php foreach( $calendar_group['items'] as $calendar_item ) : $post_id = $calendar_item['post_id']; ?>
											<?php
												$the_title     = get_the_title($post_id);
												$the_permalink = get_permalink($post_id);
												$the_title_attribute = esc_attr( strip_tags( get_the_title($post_id) ) );
												$image_id = get_post_thumbnail_id($post_id);
												if ( !empty($calendar_item['datetime_print']) && !empty($calendar_item['location_print']) ) {
													$the_summary_stmt = $calendar_item['datetime_print'].'<br/>'.$calendar_item['location_print'];
												} else {
													$the_summary_stmt = $calendar_item['datetime_print'].$calendar_item['location_print'];
												}

											?>
											<li id="post-<?php echo $post_id; ?>">
												<header class="entry-header">
													<?php if( $image_id ) : ?>
														<figure>
															<a href="<?php echo $the_permalink; ?>" title="<?php echo $the_title_attribute; ?>">
																<div class="portfolio_image_container">
																	<div class="dummy"></div>
																	<div data-content="" class="portfolio_image">
																		<?php the_responsive_image( $image_id, $image_type = 'portfolio', $image_classes = 'wp-post-image', $show_caption = false, $wrap_figure = false ); ?>
																	</div>
																</div>
															</a>
														</figure>
													<?php endif; ?>
													<p class="entry-title">
														<a href="<?php echo $the_permalink; ?>" title="<?php echo $the_title_attribute; ?>"><?php echo $the_title; ?></a>
													</p>
												</header>
												<div class="entry-summary"><?php echo $the_summary_stmt; ?></div>
											</li>
										<?php endforeach; ?>
									</ul>					
								</div>
							</div>
						</section>
						<hr style="margin-left:  -0.9375rem; margin-right: -0.9375rem;" />
					<?php endif; ?>
				<?php endforeach; ?>
				
			</section>
				
		</div><!-- #content -->
	</section>
	
<?php get_footer(); ?>