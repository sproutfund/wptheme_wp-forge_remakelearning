<?php /* Template Name: Blog */ ?>
<?php

get_header();
get_template_part( 'header', 'banner' );

function wpsites_exclude_latest_post($query) {
	if ($query->is_home() && $query->is_main_query()) {
		$query->set( 'offset', '1' );
	}
}
add_action('pre_get_posts', 'wpsites_exclude_latest_post');

?>

	<section class="container row" role="document">
		<div id="content" class="columns" role="main">
			<?php
				global $featured_posts;
				$featured_posts = new WP_Query( array(
					'posts_per_page' => 1,
					'category'       => array('3, 1412'),
					'post_type'      => 'post',
				) );
				while( $featured_posts->have_posts() ) : $featured_posts->the_post();
			?>
				<section id="featured-blog-post">
					<div class="row">
						<div class="columns medium-6 medium-push-6">
							<?php get_template_part( 'post', 'thumbnail' ); ?>
						</div>
						<div class="columns entry-content medium-6 medium-pull-6">
							<header class="entry-header">
								<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							</header>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
							<footer class="entry-footer">
								<?php echo sprout_print_post_meta(); ?>
							</footer>
						</div>
					</div>
				</section>
				<hr style="margin-left:  -0.9375rem; margin-right: -0.9375rem;" />
			<?php
				endwhile;
				wp_reset_postdata();
			?>
			<section id="more-blog-posts">
				<header>
					<h3>More Blog Posts</h3>
					<p></p>
				</header>
				<div class="row">
					<div class="columns">
						<ul class="large-block-grid-4 medium-block-grid-4 small-block-grid-2 portfolio">
							<?php while ( have_posts() ) : the_post(); ?>
								<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="entry-header">
										<?php get_template_part( 'portfolio_item', 'image' ); ?>
										<p class="entry-title">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
										</p>
									</header><!-- .entry-header -->
									<div class="entry-summary">
										<?php
											$source = sprout_shared_get_source();
											if( !empty($source) ) echo $source.', ';
											the_time('F j, Y');
										?>				
									</div><!-- .entry-summary -->
								</li><!-- #post -->
							<?php endwhile; // end of the loop ?>
						</ul>						
					</div>
				</div>
				<div class="row">
					<div class="columns">
						<div class="pagination-centered">
							<?php wpforge_content_nav( 'nav-below' ); ?>
						</div>
					</div>
				</div>

			</section>
				
		</div><!-- #content -->
	</section>

<?php get_footer(); ?>