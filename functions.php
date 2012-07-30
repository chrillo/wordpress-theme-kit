<?php


	
	
	add_theme_support( 'post-thumbnails',array('post','page') );
	add_post_type_support('page', 'excerpt');
	
	// add_image_size('headerbg',760,170,true);

	
	wp_enqueue_script( 'jquery' );

	register_nav_menus( array(
		'primary' => __( 'Haupt Navigation' ),

	) );




function ik_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'twentyten' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'ik_wp_title', 10, 2 );


function ik_renderColumns($atts,$content) {
	extract(shortcode_atts(array(
		'class' => '',
		'width' =>'50%'
	), $atts));
	$html=do_shortcode($content);
	return "<div class='column ".$class."' style='width:".$width.";'><div class='column-content'>".$html."</div></div>";
}
add_shortcode('col','ik_renderColumns');

function ik_renderClear($atts){
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$output='<div class="clear '.$class.'"></div>';
	return $output;
}
add_shortcode('clear','ik_renderClear');

?>
