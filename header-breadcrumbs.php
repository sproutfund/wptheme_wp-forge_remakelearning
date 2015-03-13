<?php
if (function_exists('sprout_breadcrumb')) {
	$print_breadcrumb = sprout_breadcrumb('<p id="breadcrumbs">', '</p>', false);
	if( is_singular(array( 'post', )) ) {
		$print_breadcrumb = str_replace(
			'Home</a></span> > <span typeof="v:Breadcrumb">',
			'Home</a></span> > <span typeof="v:Breadcrumb"><a href="/blog/" rel="v:url" property="v:title">Blog</a></span> > <span typeof="v:Breadcrumb">',
			$print_breadcrumb);
	}
	if( is_singular(array( 'newsletter', )) ) {
		$print_breadcrumb = str_replace(
			'Newsletters</a></span> > <span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">',
			'Newsletters</a></span> > <span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">'.get_the_date('n/j/Y').': ',
			$print_breadcrumb);
	}
	echo $print_breadcrumb;
}
?>