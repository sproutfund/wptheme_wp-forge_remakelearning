<?php
	$import = get_sub_field('import');
	$import_limit = get_sub_field('import_limit') ?: 999999;
	
	if( have_rows('collection', $import->ID) ) {
		while( have_rows('collection', $import->ID) ) { the_row();
			if( get_sub_field('html_before') ) echo get_sub_field('html_before');

			// hero
			if( get_sub_field('build_method') == 'hero' ) {

				get_template_part( 'collection', 'hero' );

			// html or items
			} elseif( ( get_sub_field('build_method') == 'html' ) || ( get_sub_field('build_method') == 'items' ) ) {
				echo '<div class="row">';
				echo '<div class="columns">';
				if( get_sub_field('heading')     ) echo '<h4>'.get_sub_field('heading').'</h4>';
				if( get_sub_field('description') ) echo wpautop(get_sub_field('description'));
				
				// html
				if( get_sub_field('build_method') == 'html' ) {
					echo get_sub_field('html');
				// items
				} elseif( get_sub_field('build_method') == 'items' ) {
					$printed_items = 0;
					echo '<ul class="large-block-grid-5 medium-block-grid-4 portfolio">';
					while( have_rows('items', $import->ID) && $printed_items < $import_limit ) { the_row();
						get_template_part( 'collection', 'item' );
						$printed_items++;
					}
					echo '</ul>';
				}
				
				echo '</div>'; // end .columns
				echo '</div>'; // end .row
			}

			if( get_sub_field('html_after') ) echo get_sub_field('html_after');
		}
	}
?>					
