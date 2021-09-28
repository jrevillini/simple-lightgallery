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
		
		// Check for updates
		//add_action( 'admin_init', array( $this, 'check_for_updates' ), 0 );

		// Display on settings page
		//add_action( 'sportspress_modules_sidebar', array( $this, 'sidebar' ) );
		//add_action( 'sportspress_settings_save_modules', array( $this, 'activate_license' ) );
		//add_action( 'sportspress_settings_save_modules', array( $this, 'deactivate_license' ) );
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
			// load the admin settings page
			include( dirname( __FILE__ ) . '/includes/class-sl-admin.php' );
	}
}

endif;

new Simple_lightGallery();

add_action( 'wp_enqueue_scripts', 'simplelightGallery_enqueue_properties_scripts' );


function simplelightGallery_enqueue_properties_scripts() {
	$options = get_option( 'simplelightGallery_settings' );
	if ( isset ( $options['lightgallery_post_types'] ) ) {
		$selected_post_types = (array) $options['lightgallery_post_types'] ;
	}else{
		$selected_post_types = array();
	}
	if ( isset ( $options['lightgallery_taxonomies'] ) ) {
		$selected_taxonomies = (array) $options['lightgallery_taxonomies'] ;
	}else{
		$selected_taxonomies = array();
	}
	if ( isset ( $options['plugins'] ) ) {
		$selected_plugins = (array) $options['plugins'] ;
	}else{
		$selected_plugins = array();
	}
	
	if ( isset( $options['version'] ) ) {
		$version = $options['version'];
	}else{
		$version = 1;
	}

	if ( in_array( get_post_type(), $selected_post_types ) || is_tax( $selected_taxonomies ) ) {
		if ( wp_script_is( 'lightgallery-min', 'enqueued' ) ) {
			return;

		} else {
			switch ( $version ):
				case 1:
					wp_register_script( 'lightgallery.min.js', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v1/js/lightgallery.min.js', array( 'jquery' ), '1.10.0', true );
					wp_enqueue_script( 'lightgallery.min.js' );
					wp_enqueue_style( 'lightgallery', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v1/css/lightgallery.min.css', array(), '1.10.0', 'all');
					break;
				case 2:
					wp_enqueue_style( 'lightgallery', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/css/lightgallery-bundle.min.css', array(), '2.2.1', 'all');
					wp_register_script( 'lightgallery-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/lightgallery.min.js', array(), '2.2.1', false );
					wp_enqueue_script( 'lightgallery-min' );

					foreach ( $selected_plugins as $selected_plugin => $value ) {
						switch ( $selected_plugin ):
							case 'autoplay':
								wp_register_script( 'lightgallery-lg-autoplay-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/autoplay/lg-autoplay.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-autoplay-min' );
								break;
							case 'comment':
								wp_register_script( 'lightgallery-lg-comment-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/comment/lg-comment.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-comment-min' );
								break;
							case 'fullscreen':
								wp_register_script( 'lightgallery-lg-fullscreen-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/fullscreen/lg-fullscreen.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-fullscreen-min' );
								break;
							case 'hash':
								wp_register_script( 'lightgallery-lg-hash-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/hash/lg-hash.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-hash-min' );
								break;
							case 'mediumZoom':
								wp_register_script( 'lightgallery-lg-mediumZoom-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/mediumZoom/lg-medium-zoom.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-mediumZoom-min' );
								break;
							case 'pager':
								wp_register_script( 'lightgallery-lg-pager-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/pager/lg-pager.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-pager-min' );
								break;
							case 'relativeCaption':
								wp_register_script( 'lightgallery-lg-relativeCaption-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/relativeCaption/lg-relative-caption.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-relativeCaption-min' );
								break;
							case 'rotate':
								wp_register_script( 'lightgallery-lg-rotate-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/rotate/lg-rotate.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-rotate-min' );
								break;
							case 'share':
								wp_register_script( 'lightgallery-lg-share-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/share/lg-share.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-share-min' );
								break;
							case 'thumbnail':
								wp_register_script( 'lightgallery-lg-thumbnail-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/thumbnail/lg-thumbnail.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-thumbnail-min' );
								break;
							case 'video':
								wp_register_script( 'lightgallery-lg-video-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/video/lg-video.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-video-min' );
								break;
							case 'zoom':
								wp_register_script( 'lightgallery-lg-zoom-min', plugin_dir_url( __FILE__ ) . 'assets/lightgallery/v2/plugins/zoom/lg-zoom.min.js', array('lightgallery-min'), '2.2.1', false );
								wp_enqueue_script( 'lightgallery-lg-zoom-min' );
								break;
						endswitch;
					}
					break;
			endswitch;
		}
	}
}