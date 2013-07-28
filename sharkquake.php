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

function addthis_enqueue_script(){
	//load the AddThis script in the footer
	wp_enqueue_script(
		'sharkquake-addthis',
		'//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f4f4fd3bb159a0',
		array(),
		null,
		true,
		);
}
add_action(  'wp_enqueue_script', 'addthis_enqueue_script'  );

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