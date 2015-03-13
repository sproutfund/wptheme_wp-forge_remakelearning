<?php
/**
 * Summary Statement display for portfolio items
 *
 */
?>

<div class="entry-summary">
	<?php 
		if (get_post_type() == 'opportunity') {
			echo opportunity_summary($post->ID);
		} else {
			the_field('summary_statement');
		}
	?>				
</div><!-- .entry-summary -->