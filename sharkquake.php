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


function tylerG_enqueue_script(){
	$disabled = get_option( 'sharkquake_disable', 0 );
	if ( is_single() && $disabled == 0 ){
		wp_enqueue_script(
				'sharkquake-script',
				'//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f3248a1680dbb8',
				array(),
				null,
				true
			);
	}

}
add_action( 'wp_enqueue_scripts', 'tylerG_enqueue_script' );


/**
* Append the AddThis Button group on single post pages.
*
*@since 1.0.
*/

/*function addthis_add_button($content){	
	if( is_single() && '0' === get_option( 'sharkquake_disable_button', '0')){
		//Create the AddThis button HTML
		$button_html  = '<div class="addthis_toolbox addthis_floating_style addthis_32x32_style" style =":50px;top:50px;">';
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
*/
function Sharkquake_AddThis_Buttons () {
  $disabled = get_option( 'sharkquake_disable', 0 );
  if ( $disabled == 0 ){
    $position = get_option( 'sharkquake_position', 'left' );
    if ( $position == 1 ){
      $render = 'left';
    } else {
      $render = 'right';
    }
    $numofButtons = get_option('sharkquake_numofButtons', 1);
		$sharkQuake= "
		<script type='text/javascript'>
		  addthis.layers({
		    'theme' : 'transparent',
		    'share' : {
		      'position' : $position,
		      'numPreferredServices' : $numofButtons
		    }   
		  });
		</script>
		";
		echo $sharkQuake;
	}
}
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
		<h2><?php _e( 'Sharkquake Options'); ?></h2>
		<form action="options.php" method="post">
			<?php settings_fields( 'sharkquake_position' ); ?>
			<?php do_settings_sections( 'sharkquake_options_page' ); ?>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes' ); ?>">
			</p>
		</form>
	</div>
	<?php

}

/**
 * Setup a setting for positioning the AddThis button.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_setting() {
    // Register a binary value called "sharkquake_position"
    register_setting(
        'sharkquake_position',
        'sharkquake_position',
        'sanitize_key'
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
        'sharkquake_position_field',
        __( 'Position Buttons' ),
        'sharkquake_render_position_input',
        'sharkquake_options_page',
        'sharkquake_main_settings'
    );
/**
 * Setup a setting disabling the AddThis button.
 *
 * @since  1.0.
 *
 * @return void
 */
    // Register a binary value called "sharkquake_disable"
    register_setting(
        'sharkquake_position',
        'sharkquake_disable',
        'sanitize_key'
    );

    // Add the settings section to hold the interface
    add_settings_section(
        'sharkquake_main_settings',
        null,
        null,
        'sharkquake_options_page'
    );

    // Add the settings field to define the interface
    add_settings_field(
        'sharkquake_diable_field',
        __( 'Disable AddThis' ),
        'sharkquake_render_disable_input',
        'sharkquake_options_page',
        'sharkquake_main_settings'
    );
/**
 * Setup numofButtons.
 *
 * @since  1.0.
 *
 * @return void
 */
    // Register a binary value called "sharkquake_numofButtons"
    register_setting(
        'sharkquake_position',
        'sharkquake_numofButtons',
        'sanitize_key'
    );

    // Add the settings section to hold the interface
    add_settings_section(
        'sharkquake_main_settings',
        null,
        null,
        'sharkquake_options_page'
    );

    // Add the settings field to define the interface
    add_settings_field(
        'sharkquake_numofButtons_field',
        __( 'Number of AddThis Buttons' ),
        'sharkquake_render_numofButtons_input',
        'sharkquake_options_page',
        'sharkquake_main_settings'
    );
}


add_action( 'admin_init', 'sharkquake_setting' );


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
 * Render the input for the "sharkquake_disable" setting.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_disable_input() {
    // Get the current value
    $status = get_option( 'sharkquake_disable', 0 );
    $disable = '<input id="sharkquake_disable" name="sharkquake_disable" type="checkbox" value="1" ' . checked( 1, $status, false ) . ' />';
}
/**
 * Render the input for the "sharkquake_position" setting.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_position_input() {
    // Get the current value
    $position = get_option( 'sharkquake_right_button', 0 );
    $posi = '<input id="sharkquake-position" name="sharkquake_position" type="radio" value="1" ' . checked( 1, $position, false ) . ' />';
    $posi .= '<label for="positionLeft"> Left </label>';
    $posi .= '<input id="sharkquake-position" name="sharkquake_position" type="radio" value="2" ' . checked( 2, $position, false ) . ' />';
    $posi .= '<label for="positionRight"> Right </label>';

    echo $posi;
}

/**
 * Render the input for the "sharkquake_numofButtons" setting.
 *
 * @since  1.0.
 *
 * @return void
 */
function sharkquake_render_numofButtons_input() {
  $numofButtons = get_option( 'sharkquake_numofButtons', 1 );

  $select = '<select id="sharkquake_numofButtons" name="sharkquake_numofButtons">';
    $select .= '<option value="1" '.selected( $numofButtons, 1, false ).'>1</option>';
    $select .= '<option value="2" '.selected( $numofButtons, 2, false ).'>2</option>';
    $select .= '<option value="3" '.selected( $numofButtons, 3, false ).'>3</option>';
    $select .= '<option value="4" '.selected( $numofButtons, 4, false ).'>4</option>';
    $select .= '<option value="5" '.selected( $numofButtons, 5, false ).'>5</option>';
    $select .= '<option value="6" '.selected( $numofButtons, 6, false ).'>6</option>';
  $select .= '</select>';

  echo $select;
}

// Credit to Jake Love for some of his logic
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