<header id="header" class="row" role="banner"> 
	<div class="site-header columns small-12">
		<?php //get_template_part( 'header', 'breadcrumbs' ); ?>
		<div class="header-info">
			<?php
				$title         = '';
				$subtitle      = '';
				$show_title    = true;
				$show_subtitle = true;
				
				// main blog page
				if( is_home('blog') ) {
					$title           = 'Remake Learning';
					$subtitle        = 'Blog of the Pittsburgh Kids+Creativity Network';
				}
				// search results
				elseif( is_search() ) {
					$title = sprintf( __( 'Search Results for: %s', 'wpforge' ), '<span>' . get_search_query() . '</span>' );
					$show_subtitle = false;
				}
				// listing of blog posts or news shares
				elseif( is_archive() ) {
					if( is_category('shared') ) {
						$title         = 'In the News';
						$subtitle      = 'Local and national coverage of Pittsburgh’s learning innovators.';
					} else {
						$title         = 'Remake Learning';
					}
					if( empty($subtitle) ) {
						// daily archive
						if( is_day() ) {
							$subtitle = sprintf( __( 'Daily Archives: %s', 'wpforge' ), '<span>' . get_the_date() . '</span>' );
						}
						// monthly archive
						elseif( is_month() ) {
							$subtitle = sprintf( __( 'Monthly Archives: %s', 'wpforge' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'wpforge' ) ) . '</span>' );
						}
						// yearly archive
						elseif ( is_year() ) {
							$subtitle = sprintf( __( 'Yearly Archives: %s', 'wpforge' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'wpforge' ) ) . '</span>' );
						}
					}
				}
				// individual blog posts & news shares
				elseif( is_singular(array( 'post', )) ) {
					$subtitle = sprout_print_post_meta($post->ID);
				}
				// directory content
				elseif( is_singular(array( 'person', 'project', 'organization', 'place', 'resource')) ) {
					$subtitle = get_field('summary_statement', $post->ID) ? : 'Member of the Pittsburgh Kids+Creativity Network';
				}
				// opportunity
				elseif( is_singular(array( 'opportunity', )) ) {
					$datetime_info = get_datetime_info($post->ID);
					$subtitle  = '';
					if ($datetime_info[0]) {
						if ($datetime_info[0]['print']['context'] != '') {
							$subtitle .= $datetime_info[0]['print']['context'];
						}
						$subtitle .= $datetime_info[0]['print']['dates'];
						if ($datetime_info[0]['print']['times'] != '') {
							$subtitle .= ', '.$datetime_info[0]['print']['times'];
						}
					} else {
						$subtitle .= 'Pittsburgh Kids+Creativity Network Event or Opportunity';
					}
				}
				
				if( $show_title ) {
					if( !empty($title) ) {
			?>
						<p class="page-title"><?php echo $title; ?></p>
			<?php
					} else {
			?>
						<p class="page-title"   ><?php the_title(); ?></p>
			<?php
					}
				}
				if( $show_subtitle ) {
					if( !empty($subtitle) ) {
			?>
						<p class="page-subtitle"><?php echo $subtitle; ?></p>
			<?php
					} else {
						the_excerpt();
					}
				}
			?>
		</div><!-- /.header-info -->
	</div><!-- .site-header -->
</header><!-- #header -->