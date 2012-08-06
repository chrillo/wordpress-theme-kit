<?php


	
	
add_theme_support( 'post-thumbnails',array('post','page') );
add_post_type_support('page', 'excerpt');
	
register_nav_menus( array(
		'primary' => __( 'Haupt Navigation' ),
));

/*

register_sidebar( array(
		'name' => __( 'Sidebar' ),
		'id' => 'side-widgets',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

*/

/*

Register Post type

register_post_type('type', array(
	'label' => __('Type'),
	'singular_label' => __('Kollektion'),
	'public' => true,
	'show_ui' => true, // UI in admin panel
	'_builtin' => false, // It's a custom post type, not built in!
	'_edit_link' => 'post.php?post=%d',
	'capability_type' => 'post',
	'hierarchical' => true,
	'rewrite' => array("slug" => "type"), // Permalinks format
	'supports' => array('title','excerpt','custom-fields','revisions','editor','thumbnail'),
));


register_taxonomy(  
    'type-tax',  
    'type',  
    array(  
        'hierarchical' => true,  
        'label' => 'Taxonomy',  
        'query_var' => true,  
        'rewrite' => true  
    )  
);

*/

// add_image_size('headerbg',760,170,true);


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

function ik_script($script,$url,$deps=array(),$ver=null,$footer=false){
	wp_register_script( $script, $url,$deps,$ver,$footer);
    wp_enqueue_script( $script );
}


?>
