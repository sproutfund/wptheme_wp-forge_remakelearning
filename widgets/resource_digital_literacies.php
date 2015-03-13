<?php
global $post, $display_post_type;

$widget_name  = 'resource_digital_literacies';
$widget_title = 'Digital Literacies';

$content_lit      = get_field('content');
$webmaking_lit    = get_field('webmaking');
$programming_lit  = get_field('programming');
$coding_lit       = get_field('coding');
$electronics_lit  = get_field('electronics');
$sensors_lit      = get_field('sensors');
$other_lit        = get_field('other');

if( true ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';

	if( !empty($content_lit) ) {
		echo '<li class="sidebar_list_item">';
		$literacies = $content_lit;
		$lits_count   = count($literacies); $i = 1;
		foreach ($literacies as $literacy) {
			if ($literacy === 'source') echo 'Source';
			if ($literacy === 'create') echo 'Create';
			if ($literacy === 'remix')  echo 'Remix';
			if ($i < $lits_count) echo '/';
			$i++;
		}
		echo ' Content';
		echo '</li>';
	}	

	if( $webmaking_lit != 'none' ) {
		$literacy = $webmaking_lit;
		echo '<li class="sidebar_list_item">';
		echo 'Webmaking (';
		if ($literacy === 'basic')     echo 'Basic HTML, CSS';
		if ($literacy === 'advanced')  echo 'Advanced HTML, CSS';
		echo ')';
		echo '</li>';
	}	

	if( $programming_lit != 'none' ) {
		$literacy = $programming_lit;
		echo '<li class="sidebar_list_item">';
		echo 'Programming (';
		if ($literacy === 'basic')     echo 'Basic Concepts';
		if ($literacy === 'advanced')  echo 'Advanced';
		echo ')';
		echo '</li>';
	}	

	if( $coding_lit != 'none' ) {
		$literacy = $coding_lit;
		echo '<li class="sidebar_list_item">';
		echo 'Coding/Scripting (';
		if ($literacy === 'basic')     echo 'Basic Concepts';
		if ($literacy === 'advanced')  echo 'Advanced';
		echo ')';
		echo '</li>';
	}	

	if( $electronics_lit != 'none' ) {
		$literacy = $electronics_lit;
		echo '<li class="sidebar_list_item">';
		echo 'Electronics (';
		if ($literacy === 'basic')     echo 'Basic Concepts';
		if ($literacy === 'advanced')  echo 'Advanced';
		echo ')';
		echo '</li>';
	}	

	if( $sensors_lit != 'none' ) {
		$literacy = $electronics_lit;
		echo '<li class="sidebar_list_item">';
		echo 'Electronics (';
		if ($literacy === 'basic')     echo 'Basic Concepts';
		if ($literacy === 'advanced')  echo 'Advanced';
		echo ')';
		echo '</li>';
	}	

	if( !empty($other_lit) ) {
		$literacies = $other_lit;
		foreach ($literacies as $literacy) {
			echo '<li class="sidebar_list_item">';
			if ($literacy === 'mixedmedia') echo 'Mixed Media Surfaces';
			if ($literacy === 'gamedev') echo 'Game Development Environments';
			if ($literacy === 'java')  echo 'Java';
			if ($literacy === 'badges')  echo 'Achievement Badges';
			echo '</li>';
		}
	}	

	if( false ) { 
		echo '</ul>';
		echo '<div class="divider shortcode-divider thick"></div>';
		echo '<ul>';
	}
	
	echo '</ul>';
?>
		
	<div class="spacer" style="height:5px;"></div>
<?php
	sprout_sidebar_text_widget_close();
endif;
?>