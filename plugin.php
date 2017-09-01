<?php
/*
Plugin Name: Bootswatch
Plugin URI: http://yourls.org/
Description: Add Bootstrap + Bootswatch Themes
Version: 1.0
Author: MediaGeni
Author URI: http://mediageni.nl/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Add the inline style
yourls_add_action( 'html_head', 'geni_yourls_bootstrap' );

function geni_yourls_bootstrap() {
$theme_option = yourls_get_option( 'theme_option' );
	echo <<<CSS

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/$theme_option/bootstrap.css" />

CSS;
}


// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'geni_yourls_samplepage_add_page' );
function geni_yourls_samplepage_add_page() {
	yourls_register_plugin_page( 'bootsrap_page', 'Bootstrap Settings', 'geni_yourls_samplepage_do_page' );
	// parameters: page slug, page title, and function that will display the page itself
}

// Display admin page
function geni_yourls_samplepage_do_page() {

	// Check if a form was submitted
	if( isset( $_POST['theme_option'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'bootstrap_page' );
		
		// Process form
		geni_yourls_samplepage_update_option();
	}

	// Get value from database
	$theme_option = yourls_get_option( 'theme_option' );
	
	// Create nonce
	$nonce = yourls_create_nonce( 'bootstrap_page' );



$options = array( 'cerulean', 'cosmo', 'cyborg' );

$output = '';
for( $i=0; $i<count($options); $i++ ) {
  $output .= '<option ' 
             . ( $_GET['sel'] == $options[$i] ? 'selected="selected"' : '' ) . '>' 
             . $options[$i] 
             . '</option>';
}
//echo '<select id="theme_option" name="theme_option" class="form-control" >'.$output.'</select>;


	echo <<<HTML
		<h2>Bootstrap Settings Page</h2>
		<p>Select a theme</p>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />

<select id="theme_option" name="theme_option" class="form-control" >
$output
</select>
		<p><input type="submit" value="Update value" /></p>
		</form>

HTML;
}

// Update option in database
function geni_yourls_samplepage_update_option() {
	$in = $_POST['theme_option'];
	
	if( $in ) {
		// Validate theme_option. ALWAYS validate and sanitize user input.
		// Here, we want an integer
		//	$in = intval( $in);
		$in = $in;

		
		// Update value in database
		yourls_update_option( 'theme_option', $in );
	}
}