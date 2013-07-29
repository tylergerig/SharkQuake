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

/*
function addthis01_enqueue_script(){
	if('0' === get_option( 'sharkquake_disable_button', '0')){
		//load the AddThis script in the footer
		wp_enqueue_script(
			'sharkquake-addthis',
			'var addthis_config = {"data_track_addressbar":true};',
			array(),
			null,
			true
		);
	}
}
add_action( 'wp_enqueue_script', 'addthis01_enqueue_script' );

function addthis02_enqueue_script(){
	if('0' === get_option( 'sharkquake_disable_button', '0')){
		//load the AddThis script in the footer
		wp_enqueue_script(
			'sharkquake-addthis',
			'//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f4f4fd3bb159a0',
			array(),
			null,
			true
		);
	}
}
add_action( 'wp_enqueue_script', 'addthis02_enqueue_script' );
*/

/**
* Append the AddThis Button group on single post pages.
*
*@since 1.0.
*
*@param  string		$content 	The original content.
*@return string 				The modified content.
*/

function addthis_add_button($content){
	if( is_single() && '0' === get_option( 'sharkquake_disable_button', '0')){
		//Create the AddThis button HTML
		$button_html  = '<div class="addthis_toolbox addthis_floating_style addthis_32x32_style" ' if('0' === get_option ( 'sharkquake_right_button', '0')){'style="right:50px;top:50px;">' }else{'style="left:50px;top:50px;">};
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
		'sharkquake_options_page',
		'sharkquake_render_options_page'
	);
}

add_action( 'admin_menu', 'addthis_add_options_page' );

/**
*Render the options page.
*
*@since 1.0.
*
*@return void
*/
function sharkquake_render_options_page(){
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php_e( 'Sharkquake Options'); ?></h2>
		<form action="options.php" method="post">
			<?php settings_fields( 'sharkquake_disable_button' ); ?>
			<?php do_settings_sections( 'sharkquake_options_page' ); ?>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php_e( 'Save Changes' ); ?>">
			</p>
		</form>
	</div>
	<?php

}

/**
 * Setup a setting for disabling the AddThis button.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_add_disable_button_setting() {
    // Register a binary value called "sharkquake_disable"
    register_setting(
        'sharkquake_disable_button',
        'sharkquake_disable_button',
        'absint'
    );

    // Add the settings section to hold the interface
    add_settings_section(
        'sharkquake_main_settings',
        __( 'Sharkquake Controls' ),
        'sharkquake_render_main_settings_section',
        'sharkquake_options_page'
    );

    // Add the settings field to define the interface
    add_settings_field(
        'sharkquake_disable_button_field',
        __( 'Disable AddThis Buttons' ),
        'sharkquake_render_disable_button_input',
        'sharkquake_options_page',
        'sharkquake_main_settings'
    );
}

add_action( 'admin_init', 'sharkquake_add_disable_button_setting' );

function sharkquake_left_right_button_setting() {
    // Register a binary value called "sharkquake_right"
    register_setting(
        'sharkquake_right_button',
        'sharkquake_right_button',
        'absint'
    );

/*    // Add the settings section to hold the interface
    add_settings_section(
        'sharkquake_main_settings',
        __( 'Sharkquake Controls' ),
        'sharkquake_render_main_settings_section',
        'sharkquake_options_page'
    );*/

    // Add the settings field to define the interface
    add_settings_field(
        'sharkquake_right_button_field',
        __( 'Float Right AddThis Buttons' ),
        'sharkquake_render_right_button_input',
        'sharkquake_options_page',
        'sharkquake_main_settings'
    );
}

add_action( 'admin_init', 'sharkquake_left_right_button_setting' );

/**
 * Render text to be displayed in the "sharkquake_main_settings" section.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_main_settings_section() {
    echo '<p>Main settings for the Sharkquake plugin.</p>';
}

/**
 * Render the input for the "sharkquake_disable_button" setting.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_disable_button_input() {
    // Get the current value
    $current = get_option( 'sharkquake_disable_button', 0 );
    echo '<input id="sharkquake-disable-button" name="sharkquake_disable_button" type="checkbox" value="1" ' . checked( 1, $current, false ) . ' />';
}
/**
 * Render the input for the "sharkquake_right_button" setting.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_right_button_input() {
    // Get the current value
    $leftRight = get_option( 'sharkquake_right_button', 0 );
    echo '<input id="sharkquake-right-button" name="sharkquake_right_button" type="checkbox" value="1" ' . checked( 1, $leftRight, false ) . ' />';
}

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