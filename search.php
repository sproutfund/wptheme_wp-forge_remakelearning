<?php
/**
 * The template for displaying Search Results pages.
 *
 */
get_header();
get_template_part( 'header', 'banner' );
?>
<section class="container row" role="document">
	<div id="content" class="columns" role="main">
    
		<?php if ( have_posts() ) : ?>

			<div class="row">
				<div class="columns">
					<ul class="large-block-grid-4 medium-block-grid-4 small-block-grid-2 portfolio">
						<?php while ( have_posts() ) : the_post(); if( has_post_thumbnail() ) : ?>
							<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<?php get_template_part( 'portfolio_item', 'image' ); ?>
									<p class="entry-title">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									</p>
								</header><!-- .entry-header -->
								<div class="entry-summary">
									<?php
										if( get_post_type() == 'post' ) {
											$source = sprout_shared_get_source();
											if( !empty($source) ) echo $source.', ';
											the_time('F j, Y');
										}
										elseif( get_post_type() == 'opportunity' ) {
											echo opportunity_summary($post->ID);
										}
										else {
											the_field('summary_statement');
										}
									?>				
								</div><!-- .entry-summary -->
							</li><!-- #post -->
						<?php endif; endwhile; // end of the loop ?>
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

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</section>
<?php get_footer(); ?>