<?php

//theme options
//the website title (title displayed in the browser)
//the website description (which you can place anywhere, e.g. the heading text at the top)
//a default background color for the sections that currently have a white background color.

//links
//https://blog.kulturbanause.de/2011/11/theme-options-page-fur-wordpress-erstellen/
//http://www.sitepoint.com/create-a-wordpress-theme-settings-page-with-the-settings-api/
//https://codex.wordpress.org/Administration_Screens

//Open Question: Validation of user inputs needed?

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

// Register settings (http://codex.wordpress.org/Function_Reference/register_setting)
function theme_options_init(){
	register_setting( 'mam_options', 'mam_theme_options', 'mam_validate_options' );
}

// Add option-page to dashboard navigation
// it will be displayed under appearance - options
function theme_options_add_page() {
	
	// parameters: 
	// $page_title (string) (required) The text to be displayed in the title tags of the page when the menu is selected Default: None 
	// $menu_title (string) (required) The text to be used for the menu Default: None 
	// $capability (string) (required) The capability required for this menu to be displayed to the user. Default: None 
	// $menu_slug (string) (required) The slug name to refer to this menu by (should be unique for this menu). Default: None 
	// $function (callback) (optional) The function to be called to output the content for this page. Default: ' ' 
	// Link: https://codex.wordpress.org/Function_Reference/add_theme_page
	
	add_theme_page('Options', 'Options', 'edit_theme_options', 'theme-options', 'mam_theme_options_page' ); 
}

// create page with options
function mam_theme_options_page() {
	global $select_options, $radio_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false; ?>

	<div class="wrap"> 
	<?php screen_icon(); ?><h2>Theme-Options</h2> 

	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?> 
		<div class="updated fade">
			<p><strong>Settings successfully stored!</strong></p>
		</div>
	<?php endif; ?>

	  <form method="post" action="options.php">
		<?php settings_fields( 'mam_options' ); ?>
		<?php $options = get_option( 'mam_theme_options' ); ?>

		<table class="form-table">
		  <tr valign="top">
			<th scope="row">Website Title</th>
			<td><input id="mam_theme_options[websitetitle]" class="regular-text" type="text" name="mam_theme_options[websitetitle]" value="<?php esc_attr_e( $options['websitetitle'] ); ?>" /></td>
		  </tr>  
		</table>
		
		<table class="form-table">
		  <tr valign="top">
			<th scope="row">Website Description</th>
			<td><textarea cols="46" rows="5" id="mam_theme_options[websitedescription]" class="regular-text" name="mam_theme_options[websitedescription]"><?php esc_attr_e( $options['websitedescription'] ); ?></textarea></td>
		  </tr>  
		</table>
		
		<table class="form-table">
		  <tr valign="top">
			<th scope="row">Base Background Color</th>
			<td><input id="mam_theme_options[basebackgroundcolor]" class="regular-text" type="text" name="mam_theme_options[basebackgroundcolor]" value="<?php esc_attr_e( $options['basebackgroundcolor'] ); ?>" /></td>
		  </tr>  
		</table>
		
		<!-- submit -->
		<p class="submit"><input type="submit" class="button-primary" value="Store Settings" /></p>
	  </form>
	</div>
<?php }

// Validation of inputs
// one could for example filter html-code 
// http://codex.wordpress.org/Function_Reference/wp_filter_nohtml_kses
function mam_validate_options( $input ) {
	// $input['websitedescription'] = wp_filter_nohtml_kses( $input['websitedescription'] );
	return $input;
}