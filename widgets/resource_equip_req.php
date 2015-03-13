<?php
global $post, $display_post_type;
$icon_path = 'http://s3.amazonaws.com/sproutfund_webcontent/icons/';

$widget_name  = 'resource_equip_req';
$widget_title = 'Equipment Required';
$acf_group = array(2843);
$flexible_field_name = 'quick_facts,web';
$edit_link = NULL;

if ( current_user_can('edit_post', $post->ID) ) {
	$edit_box  = '&TB_iframe=true&width=910&height=600';
	if( isset($flexible_field_name) ) {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&acf_field='.$flexible_field_name.'&edit_id='.$post->ID.$edit_box;
	} else {
		$edit_href = '/directory-edit/?acf_group='.implode(',', $acf_group).'&edit_id='.$post->ID.$edit_box;
	}
	$edit_text = 'Edit '.ucwords($display_post_type).' '.$widget_title;
	$edit_link = '<a href="'.$edit_href.'" class="thickbox" title="<b>'.$edit_text.'</b> '.get_the_title().'"><i class="icon-edit"></i></a>';
}

$internet_web_req    = get_field('internet_web');
$computer_req        = get_field('computer_req');
$software_req        = get_field('software_req');
$mobile_req          = get_field('mobile_req');
$mobileapp_req       = get_field('mobileapp_req');
$gamesystem_req      = get_field('gamesystem_req');
$other_req_materials = get_field('other_req_materials');

$has_internet_web_req    = empty($internet_web_req) ? false : true;
$has_computer_req        = empty($computer_req) ? false : true;
$has_software_req        = empty($software_req) ? false : true;
$has_mobile_req          = empty($mobile_req) ? false : true;
$has_mobileapp_req       = empty($mobileapp_req) ? false : true;
$has_gamesystem_req      = empty($gamesystem_req  ) ? false : true;
$has_other_req_materials = empty($other_req_materials) ? false : true;

if( true ) : 

	sprout_sidebar_text_widget_open( $widget_name, $widget_title, $edit_link );
	
	echo '<ul>';

	if( $has_internet_web_req ) {
		$requirements = $internet_web_req;
		//$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			echo '<li class="sidebar_list_item">';
			if ($requirement === 'internet') echo 'Internet Access';
			if ($requirement === 'browser')  echo 'Web Browser';
			echo '</li>';
			//if ($i < $reqs_count) echo '';
			//$i++;
		}
	}	

	if( $has_computer_req ) {
		echo '<li class="sidebar_list_item">';
		echo 'Computer ';
		$requirements = $computer_req;
		$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			if ($requirement === 'winPC')  echo '<img src="'.$icon_path.'windows.png" title="Windows/PC-compatible" class="fugue-icon"/>';
			if ($requirement === 'mac')    echo '<img src="'.$icon_path.'mac-os.png" title="Mac-compatible" class="fugue-icon"/> ';
			if ($requirement === 'linux')  echo '<img src="'.$icon_path.'animal-penguin.png" title="Linux-compatible" class="fugue-icon"/>';
			if ($requirement === 'chrome') echo '<img src="'.$icon_path.'question.png" title="Chromebook" class="fugue-icon"/>';
			if ($i < $reqs_count) echo ' ';
			$i++;
		}
		echo '</li>';
	}	

	if( $has_software_req ) {
		echo '<li class="sidebar_list_item">';
		$requirements = $software_req;
		$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			if ($requirement === 'free')       echo 'Free';
			if ($requirement === 'paid')       echo 'Paid';
			if ($requirement === 'subscript')  echo 'Subscription';
			if ($i < $reqs_count) echo '/';
			$i++;
		}
		echo ' Software';
		echo '</li>';
	}	

	if( $has_mobile_req ) {
		$requirements = $mobile_req;
		$has_apple     = false;
		$has_android   = false;
		$has_blackbery = false;
		$has_textphone = false;
		foreach ($requirements as $requirement) {
			if ($requirement === 'iOS_iPad')         $has_apple = true;
			if ($requirement === 'iOS_iPhone')       $has_apple = true;
			if ($requirement === 'android_tablet')   $has_android = true;
			if ($requirement === 'android_phone')    $has_android = true;
			if ($requirement === 'blackberry_phone') $has_blackbery = true;
			if ($requirement === 'text_phone')       $has_textphone = true;
		}
		if( $has_apple ) {
			echo '<li class="sidebar_list_item">';
			echo 'Mobile Device (Apple) ';
			foreach ($requirements as $requirement) {
				if ($requirement === 'iOS_iPad')  echo '<img src="'.$icon_path.'e-book-reader.png" title="Apple iPad" class="fugue-icon"/>';
				if ($requirement === 'iOS_iPhone')  echo '<img src="'.$icon_path.'media-player-phone.png" title="Apple iPhone" class="fugue-icon"/>';
			}
			echo '</li>';
		}
		if( $has_android ) {
			echo '<li class="sidebar_list_item">';
			echo 'Mobile Device (Android) ';
			foreach ($requirements as $requirement) {
				if ($requirement === 'android_tablet')  echo '<img src="'.$icon_path.'e-book-reader.png" title="Android tablet" class="fugue-icon"/>';
				if ($requirement === 'android_phone')  echo '<img src="'.$icon_path.'media-player-phone.png" title="Android phone" class="fugue-icon"/>';
			}
			echo '</li>';
		}
		if( $has_blackberry ) {
			echo '<li class="sidebar_list_item">';
			echo 'Mobile Device (Blackberry) ';
			foreach ($requirements as $requirement) {
				if ($requirement === 'blackberry_phone')  echo '<img src="'.$icon_path.'media-player-phone.png" title="Blackberry phone" class="fugue-icon"/>';
			}
			echo '</li>';
		}
		if( $has_textphone ) {
			echo '<li class="sidebar_list_item">';
			echo 'Mobile Phone (text message-capable) ';
			echo '<img src="'.$icon_path.'mobile-phone.png" title="Mobile phone" class="fugue-icon"/>';
			echo '</li>';
		}
	}

	if( $has_mobileapp_req ) {
		echo '<li class="sidebar_list_item">';
		$requirements = $mobileapp_req;
		$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			if ($requirement === 'free')       echo 'Free';
			if ($requirement === 'paid')       echo 'Paid';
			if ($requirement === 'subscript')  echo 'Subscription';
			if ($i < $reqs_count) echo '/';
			$i++;
		}
		echo ' Mobile App';
		echo '</li>';
	}	

	if( $has_gamesystem_req ) {
		echo '<li class="sidebar_list_item">';
		echo 'Game System (';
		$requirements = $gamesystem_req;
		$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			if ($requirement === 'xbox360') echo 'Xbox 360';
			if ($requirement === 'ps3')     echo 'PlayStation 3';
			if ($requirement === 'wii')     echo 'Nintendo Wii';
			if ($i < $reqs_count) echo '/';
			$i++;
		}
		echo ')';
		echo '</li>';
	}	

	if( $has_other_req_materials ) {
		$requirements = $other_req_materials;
		//$reqs_count   = count($requirements); $i = 1;
		foreach ($requirements as $requirement) {
			echo '<li class="sidebar_list_item">';
			echo $requirement['item'];
			echo '</li>';
			//if ($i < $reqs_count) echo '';
			//$i++;
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