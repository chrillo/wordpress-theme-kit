<?php

/*

	shortcodes
	----------------------------------------
	
	Columns [col width="X" class="X"] Content [/column]
	
	Clear [clear class="X"]
	
	Horizontal Line [hline class="X"]
	
	Map [map width="X" height="Y" url="GOOGLE_MAPS_URL"]
	
	Tabs [tabs class="X"]
	
	Tab [tab title="X"] Content [/tab]

	Vimeo [vimeo id="X"]

	Youtube [vimeo id="X"]
	
*/

/*

	Register Editor Plugin

*/
if(is_admin()){
add_action('init', 'add_button'); 
} 
function add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_plugin');  
     add_filter('mce_buttons', 'register_button');  
   }  
}  
function register_button($buttons) {  
   array_push($buttons, "ikshortcodes");  
   return $buttons;  
}  
function add_plugin($plugin_array) {  
   $plugin_array['ikshortcodes'] = get_bloginfo('template_directory').'/ik-framework/js/shortcodes.js';  
   return $plugin_array;  
}

/*

	P Tag Formatting fix inside of shortcodes

*/

function ik_formatter($content){
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
	foreach ($pieces as $piece) {
	if (preg_match($pattern_contents, $piece, $matches)) {
	$new_content .= $matches[1];
	} else {
	$new_content .= wptexturize(wpautop($piece));
	}
}

return $new_content;
}
function ik_raw($content){
	return "[raw]".$content."[/raw]";
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'ik_formatter', 99);

/*

	Column

*/

function ik_renderColumns($atts,$content) {
	extract(shortcode_atts(array(
		'class' => '',
		'width' =>'50%'
	), $atts));
	$html=do_shortcode($content);
	return ik_raw("<div class='ik-column ".$class."' style='width:".$width.";'><div class='ik-column-content'>".$html."</div></div>");
}
add_shortcode('column','ik_renderColumns');

/*

	Clear
	
*/
function ik_clear($atts){
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$output='<div class="clear '.$class.'"></div>';
	return ik_raw($output);
}
add_shortcode('clear','ik_clear');


/*

	Horizontal Line
	
*/
function ik_hline($atts){
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	return ik_raw('<div class="ik-hline '.$class.'"></div>');
}
add_shortcode('hline','ik_hline');

/*

	Map

*/
function ik_map($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '640',
      "height" => '480',
      "url" => ''
   ), $atts));
   return ik_raw('<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$url.'&amp;output=embed"></iframe>');
}
add_shortcode("map", "ik_map");

/*

	Tabs

*/
function ik_tabs($atts,$content = null){
	$id = time()+" "+rand(0,999999);
	extract(shortcode_atts(array(
      'class' => '',
   ), $atts));
	
  $html = "<div id='ik-tabs-".$id."' class='ik-tabs ".$class."'><div class='ik-tab-btns'></div><div class='ik-tab-panels'>".do_shortcode($content)."</div></div><script type='text/javascript'>
  				$=jQuery
  				$(function(){
  					var id = '".$id."';
  					var tabs = $('#ik-tabs-".$id."');
  					var btns = $('.ik-tab-btn',tabs);
  					var panels = $('.ik-tab',tabs)
  					
  					$('.ik-tab-btns',tabs).append(btns.detach());
  					
  					btns.each(function(index,btn){
  						$(btn).click(function(){
  							(function(){
  								showTab(index)
  							})()
  						})
  					})
  					
  					var showTab = function(index){
  						btns.removeClass('active');
  						btns.eq(index).addClass('active');
  						panels.hide();
  						panels.eq(index).show()	
  					}
  					showTab(0)
  					
  				})
</script>";
  
  return ik_raw($html);	
}
add_shortcode("tabs", "ik_tabs");
function ik_tab($atts,$content = null){
	extract(shortcode_atts(array(
      "title" => 'Tab'
   ), $atts));
	return "<div class='ik-tab'><div class='ik-tab-btn'>".$title."</div><div class='tab-panel'>".do_shortcode($content)."</div></div>";
}
add_shortcode("tab", "ik_tab");

function ik_vimeo($atts) {

	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' => '640px',
		'height' =>'480px'
 	), $atts));
	$output='';
	
	return ik_raw('<div class="video-wrap"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>');
	
	
}
add_shortcode('vimeo', 'ik_vimeo');

function ik_youtube($atts) {

	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' => '640px',
		'height' =>'480px'
	), $atts));
	$output='';
	

	return ik_raw('<div class="video-wrap"><iframe src="http://www.youtube.com/embed/'.$id.'" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe></div>');
		
}
add_shortcode('youtube', 'ik_youtube');

?>
