<?php
/**
Plugin Name: Simple lightGallery
Plugin URI: https://themata4all.com
Description: An integration of lightGallery javascript v1 and v2 to Wordpress
Author: Savvas Hadjigeorgiou
Version: 1.0.0
Author URI: https://themata4all.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Simple_lightGallery' ) ) :

/**
 * Main Simple lightGallery Class
 *
 * @class Simple_lightGallery
 * @version	1.0.0
 */
class Simple_lightGallery {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();
		
	}
	
	/**
	 * Define constants
	*/
	private function define_constants() {
		if ( !defined( 'SL_PLUGIN_BASE' ) )
			define( 'SL_PLUGIN_BASE', plugin_basename( __FILE__ ) );
	}

	/**
	 * Include required files
	*/
	private function includes() {
			//load the needed frontend files
			include( dirname( __FILE__ ) . '/includes/class-slg-front.php' );
			// load the admin settings page
			include( dirname( __FILE__ ) . '/includes/class-slg-admin.php' );
	}
}

endif;

new Simple_lightGallery();