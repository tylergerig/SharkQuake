<?php
/*
Plugin Name: Sharkquake AddThis Buttons
Author: Tyler Gerig
Version: 1.0
Description: AddThis buttons added to your pages!
License: GNU General Public License v2 or later
*/

/**
* Add the AddThis Buttons script prior to closing body tag.
*
* @since 1.0.
*
* @return void
*/

function addthis01_enqueue_script(){
	//load the AddThis script in the footer
	wp_enqueue_script(
		'sharkquake-addthis',
		'var addthis_config = {"data_track_addressbar":true};',
		array(),
		null,
		true
		);
}
add_action( 'wp_enqueue_script', 'addthis01_enqueue_script' );

function addthis02_enqueue_script(){
	//load the AddThis script in the footer
	wp_enqueue_script(
		'sharkquake-addthis',
		'//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f4f4fd3bb159a0',
		array(),
		null,
		true
		);
}
add_action( 'wp_enqueue_script', 'addthis02_enqueue_script' );

/**
* Append the AddThis Button group on single post pages.
*
*@since 1.0.
*
*@param  string		$content 	The original content.
*@return string 				The modified content.
*/

function addthis_add_button($content){
	if( is_single() ){
		//Create the AddThis button HTML
		$button_html  = '<div class="addthis_toolbox addthis_floating_style addthis_32x32_style" style="left:50px;top:50px;">';
		$button_html .= '<a class="addthis_button_preferred_1"></a>';
		$button_html .= '<a class="addthis_button_preferred_2"></a>';
		$button_html .= '<a class="addthis_button_preferred_3"></a>';
		$button_html .= '<a class="addthis_button_preferred_4"></a>';
		$button_html .= '<a class="addthis_button_compact"></a>';
		$button_html .= '</div>';

		$content .= $button_html;
	}
	return $content;
}

add_filter(  'the_content', 'addthis_add_button', 20);

/**
*Add an options page for the plugin.
*
*@since 1.0.
*
*@return void
*/
function addthis_add_options_page(){
	//Add new page under the "Settings tab"
	add_options_page(
		__( 'Sharkquake Options' ),
		__( 'Sharkquake Options' ),
		'manage_options',
		'sharkquake_options_page'
		'sharkquake_render_options_page'
	);
}

add_action( 'admin_menu', 'addthis_add_options_page' );

/*
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_32x32_style" style="left:50px;top:50px;">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f4f4fd3bb159a0"></script>
<!-- AddThis Button END -->
*/