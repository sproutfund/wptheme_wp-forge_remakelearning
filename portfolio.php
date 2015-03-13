<?php
/*
Template Name: Portfolio Display
*/
get_header();
?>

	<header id="header" class="row" role="banner"> 
		<div class="site-header columns small-12">
			<?php //get_template_part( 'header', 'breadcrumbs' ); ?>
			<div class="header-info">
				<p class="page-title">
					<?php the_title(); ?>
					<?php if( is_page('people') || is_page('projects') || is_page('organizations') ) : ?>
						<a target="_blank" class="button small" style="float: right; margin-bottom: 2px;"
							<?php if( is_page('people') ) : ?>
								href="/people/add-person/" title="Request a new person profile in the Remake Learning directory">Add Person</a
							<?php elseif( is_page('projects') ) : ?>
								href="/projects/add-project/" title="Request a new project profile in the Remake Learning directory">Add Project</a
							<?php elseif( is_page('organizations') ) : ?>
								href="/organizations/add-organization/" title="Request a new organization profile in the Remake Learning directory">Add Organization</a
							<?php /*elseif( is_page('digital-learning-tools') ) :
								href="/resources/add-resource/" title="Add a tool to the library">Add Tool</a*/ ?>
							<?php endif; ?>
						>
					<?php endif; ?>	
				</p>
				<?php the_excerpt(); ?>
			</div><!-- /.header-info -->
		</div><!-- .site-header -->
	</header><!-- #header -->
	
	<section class="container row" role="document">
		<div id="content" class="medium-12 large-12 columns" role="main">
			<?php
				global $wp_query;
				$page    = get_queried_object();
				$page_id = $page->ID;

				// set portfolio default options
				$portfolio_args = array();
				$portfolio_args['filter_taxonomy'] = NULL;
				$portfolio_args['display' ]['show_filter'] = false;
				$portfolio_args['display' ]['show_excerpt'] = false;
				$portfolio_args['display' ]['show_shuffle'] = false;
				$portfolio_args['wp_query'] = array(
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'order'          => 'ASC',
					'orderby'        => 'name',
					'meta_query'     => array( array(
						'key' => '_thumbnail_id'
					)),
					'tax_query'      => array( array(
						'taxonomy' => 'webdisplay',
						'field' => 'slug',
						'terms' => get_option( 'sprout_webdisplay' )
					))
				);

				// set options by portfolio type (replace these with site editable options at a later date)
				$portfolio_options = array (
					'people' => array (
						'post_type' => 'person',
					),
					'projects' => array (
						'post_type' => 'project',
					),
					'organizations' => array (
						'post_type' => 'organization',
					),
					'events-opportunities' => array (
						'post_type' => 'opportunity',
						'order'     => 'ASC',
						'orderby'   => 'date'
					),
					'events-activities' => array (
						'post_type' => 'opportunity',
						'order'     => 'ASC',
						'orderby'   => 'date'
					),
					'digital-learning-tools' => array (
						'post_type' => 'resource',
					)
				);
				$portfolio_args['wp_query']['post_type'] = $portfolio_options[$page->post_name]['post_type'];
				define('PORTFOLIO_TYPE', $portfolio_args['wp_query']['post_type']);

				// update options based on post_type info
				if( isset($portfolio_options[$page->post_name]['order']) ) {
					$portfolio_args['wp_query']['order'] = $portfolio_options[$page->post_name]['order'];
				}
				if( isset($portfolio_options[$page->post_name]['orderby']) ) {
					$portfolio_args['wp_query']['orderby'] = $portfolio_options[$page->post_name]['orderby'];
				}

				// make adjustments for opportunity posts
				if( $portfolio_args['wp_query']['post_type'] === 'opportunity' ) {
					$portfolio_args['wp_query']['post_status'] = array( 'publish', 'future' );
					/*if( function_exists('get_postids_by_date_relative') ) {
						$portfolio_args['wp_query']['post__in'] = get_postids_by_date_relative('future');
					}*/
				}

				// if the portfolio is of a post_type, get custom stickies
				/*
				if ( class_exists( 'Post_Type_Spotlight' ) &&  isset($portfolio_args['wp_query']['post_type']) ) {
					$featured_posts = new WP_Query( array(
						'post_type' => $portfolio_args['wp_query']['post_type'],
						'meta_query' => array(
							array(
								'key' => '_pts_featured_post'
							)
						)
					) );
					foreach ($featured_posts as $featured_post) {
						array_push($portfolio_args['wp_query']['post__in'], $featured_post->ID);
					}
				}*/

				$wp_query = new WP_Query($portfolio_args['wp_query']);

				$portfolio_post_ids = array();
				$portfolio_post_letters_raw = array();
				foreach($wp_query->posts as $post) {
					$portfolio_post_ids[] = $post->ID;
					$portfolio_post_letters_raw[] = substr($post->post_name, 0, 1);
				}
				$portfolio_post_letters = array_unique($portfolio_post_letters_raw, SORT_STRING);

				$portfolio_args['results']['request_str' ] = $wp_query->request;
				$portfolio_args['results']['post_ids'    ] = $portfolio_post_ids;
				$portfolio_args['results']['post_letters'] = $portfolio_post_letters;
			?>

		<?php if ( have_posts() ) : ?>
		
			<?php /* echo '<!--'; print_r($portfolio_args); echo '-->'; */ ?>
			
			<ul class="large-block-grid-5 medium-block-grid-4 portfolio">

				<?php while ( have_posts() ) : the_post(); /* Start the Loop */ ?>
				
					<?php get_template_part( 'portfolio_item' ); ?>
					
				<?php endwhile; wp_reset_query(); /* End the Loop */ wpforge_content_nav( 'nav-below' ); ?>

			</ul>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section>

<?php get_footer(); ?>