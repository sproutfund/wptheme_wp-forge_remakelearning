<div class="row">
	<div class="columns">
		<ul class="large-block-grid-5 medium-block-grid-4 portfolio">
			<?php while( have_rows('items', $post->ID) ) { the_row(); get_template_part( 'collection', 'item' ); } ?>
		</ul>
	</div>
</div>