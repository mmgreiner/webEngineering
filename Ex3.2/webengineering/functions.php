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

include 'custom_posttype.php';

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

// theme customization through theme customizer
// Links
// http://themefoundation.com/wordpress-theme-customizer/
// https://codex.wordpress.org/Theme_Customization_API
function mam_customize_technical_skills( $wp_customize ) {
	
	// add a new section to the customizer
	$wp_customize->add_section(
        'technical_skills_section',
        array(
            'title' => 'Technical Skills Settings',
            'description' => 'Section to customize the technical skills.',
            'priority' => 1,
        )
    );
	
	// add a new setting for html percentage
	$wp_customize->add_setting(
		'html_percentage',
		array(
			'default' => '0',
		)
	);

	// add new control for html percentage
	$wp_customize->add_control(
		'html_percentage',
		array(
			'label' => 'HTML Percentage',
			'section' => 'technical_skills_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for css percentage
	$wp_customize->add_setting(
		'css_percentage',
		array(
			'default' => '0',
		)
	);

	// add new control for css percentage
	$wp_customize->add_control(
		'css_percentage',
		array(
			'label' => 'CSS Percentage',
			'section' => 'technical_skills_section',
			'type' => 'text',
		)
	);

	// add a new setting for javascript percentage
	$wp_customize->add_setting(
		'js_percentage',
		array(
			'default' => '0',
		)
	);

	// add new control for javascript percentage
	$wp_customize->add_control(
		'js_percentage',
		array(
			'label' => 'JavaScript Percentage',
			'section' => 'technical_skills_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for wordpress percentage
	$wp_customize->add_setting(
		'wp_percentage',
		array(
			'default' => '0',
		)
	);

	// add new control for wordpress percentage
	$wp_customize->add_control(
		'wp_percentage',
		array(
			'label' => 'WordPress Percentage',
			'section' => 'technical_skills_section',
			'type' => 'text',
		)
	);
}

add_action( 'customize_register', 'mam_customize_technical_skills' );

//include custom css into header
function mam_theme_customize_css()
{
	?>
        <style type="text/css">
			#barhtml { height: <?php echo 300*(floatval(get_theme_mod('html_percentage', '0'))/100); ?>px }
			#barcss  { height: <?php echo 300*(floatval(get_theme_mod('css_percentage', '0'))/100); ?>px }
			#barjs   { height: <?php echo 300*(floatval(get_theme_mod('js_percentage', '0'))/100); ?>px }
			#barwp   { height: <?php echo 300*(floatval(get_theme_mod('wp_percentage', '0'))/100); ?>px }
        </style>
    <?php
}

add_action( 'wp_head', 'mam_theme_customize_css');

// make sure that there is no margin put into the css for the admin bar
// Link: http://stackoverflow.com/questions/6053654/why-is-the-php-wp-head-tag-creating-a-top-margin-at-the-top-of-my-theme-hea
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

// contact customization through theme customizer
function mam_customize_contact( $wp_customize ) {
	
	// add a new section to the customizer
	$wp_customize->add_section(
        'contact_section',
        array(
            'title' => 'Contact Settings',
            'description' => 'Section to customize the contact information.',
            'priority' => 1,
        )
    );
	
	// add a new setting for address
	$wp_customize->add_setting(
		'address',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for address
	$wp_customize->add_control(
		'address',
		array(
			'label' => 'Address',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for phone
	$wp_customize->add_setting(
		'phone',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for phone
	$wp_customize->add_control(
		'phone',
		array(
			'label' => 'Phone',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for fax
	$wp_customize->add_setting(
		'fax',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for fax
	$wp_customize->add_control(
		'fax',
		array(
			'label' => 'Fax',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for mail line 1
	$wp_customize->add_setting(
		'mail1',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for mail line 1
	$wp_customize->add_control(
		'mail1',
		array(
			'label' => 'Mail Line 1',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);

	// add a new setting for mail line 2
	$wp_customize->add_setting(
		'mail2',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for mail line 2
	$wp_customize->add_control(
		'mail2',
		array(
			'label' => 'Mail Line 2',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);
	
	// add a new setting for company
	$wp_customize->add_setting(
		'company',
		array(
			'default' => 'unknown',
		)
	);

	// add new control for company
	$wp_customize->add_control(
		'company',
		array(
			'label' => 'Company',
			'section' => 'contact_section',
			'type' => 'text',
		)
	);
}

add_action( 'customize_register', 'mam_customize_contact' );

