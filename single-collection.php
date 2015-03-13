<?php
/**
 * The Template for displaying single collection posts.
 *
 */
get_header();
get_template_part( 'header', 'banner' );

echo '<section class="container row" role="document">';
echo '<div id="content" class="columns collection" role="main">';

while ( have_posts() ) { the_post();

	if( have_rows('collection', $post->ID) ) {
	
		while( have_rows('collection', $post->ID) ) { the_row();
		
			$collection_title       = get_sub_field('heading');
			$collection_description = get_sub_field('description');
			$collection_id          = rand(10000000, 99999999);
			
			$parent_html_before     = get_sub_field('html_before');
			$parent_html_after      = get_sub_field('html_after' );
			
			if( get_sub_field('heading') ) { $collection_id = sanitize_title(get_sub_field('heading')); }
			
			if( get_sub_field('build_method') == 'import' ) {
				$import = get_sub_field('import');
				$post = get_post($import->ID);
				setup_postdata( $post );
				if( empty($collection_title)       ) { $collection_title       = get_the_title(); }
				if( empty($collection_description) ) { $collection_description = get_the_excerpt(); }
				$collection_id = sanitize_title(get_the_title());
				wp_reset_postdata();
			}
			
			// open new section
			echo '<section id="'.$collection_id.'">';

			if( get_sub_field('html_before') ) echo get_sub_field('html_before');
			
			// print collection hero
			if( get_sub_field('build_method') == 'hero' ) {
				get_template_part( 'collection', 'hero' );
			}
			else {
				// print header area with collection title and description
				if( !empty($collection_title) || !empty($collection_description) ) {
					echo '<header>';
					if( !empty($collection_title)       ) echo "<h3>$collection_title</h3>";
					if( !empty($collection_description) ) echo wpautop($collection_description);
					echo '</header>';
				}
				// print copy & paste HTML
				if( get_sub_field('build_method') == 'html' ) {
					echo get_sub_field('html');
				}
				// print items
				elseif( get_sub_field('build_method') == 'items' ) {
					echo '<div class="row">';
					echo '<div class="columns">';
					echo '<ul class="large-block-grid-5 medium-block-grid-4 small-block-grid-2 portfolio">';
					while( have_rows('items', $post->ID) ) { the_row(); 
						get_template_part( 'collection', 'item' ); 
					}
					echo '</ul>';
					echo '</div>';
					echo '</div>';
				}
				// print imported colleciton
				elseif( get_sub_field('build_method') == 'import' ) {
					
					$import_limit  = get_sub_field('import_limit') ?: 999999;
					$import_random = get_sub_field('import_random');
					
					if( have_rows('collection', $import->ID) ) {
						while( have_rows('collection', $import->ID) ) { the_row();
							if( get_sub_field('html_before') && ( get_sub_field('html_before') != $parent_html_before ) ) echo get_sub_field('html_before');
							
							// print collection hero
							if( get_sub_field('build_method') == 'hero' ) {
								get_template_part( 'collection', 'hero' );
							}
							else {
								// print copy & paste HTML
								if( get_sub_field('build_method') == 'html' ) {
									echo get_sub_field('html');
								}
								// print items
								elseif( get_sub_field('build_method') == 'items' ) {
									echo '<div class="row">';
									echo '<div class="columns">';
									echo '<ul class="large-block-grid-5 medium-block-grid-4 small-block-grid-2 portfolio">';
									$printed_items = 0;
									if( $import_random == 'randomized' ) {
										$array_position   = 0;
										$random_positions = UniqueRandomNumbersWithinRange(0, count( get_sub_field( 'items', $import->ID ) )-1, $import_limit);
										while( have_rows('items', $import->ID) && $printed_items < $import_limit ) { the_row();
											if( in_array( $array_position, $random_positions, true ) ) {
												get_template_part( 'collection', 'item' );
												$printed_items++;
											}
											$array_position++;
										}
									} else {
										while( have_rows('items', $import->ID) && $printed_items < $import_limit ) { the_row(); 
											get_template_part( 'collection', 'item' );
											$printed_items++;
										}
									}
									echo '</ul>';
									echo '</div>';
									echo '</div>';
								}
							}
							
							if( get_sub_field('html_after') && ( get_sub_field('html_after') != $parent_html_after ) ) echo get_sub_field('html_after');
						}
					}
				}
			}
			
			if( get_sub_field('html_after') ) echo get_sub_field('html_after');
			
			echo '</section>'; // close collection
			echo '<hr/>'; // close collection

		}
				
	} // end if collection

} // end of the loop. 

echo '</div><!-- #content -->';
echo '</section>';

get_footer();
?>