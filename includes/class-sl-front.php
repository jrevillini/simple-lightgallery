<?php

/**
 * Frontend functionality
 * @package Simple lightGallery
 * @subpackage Front
 * @author Savvas Hadjigeorgiou
 */
 
class SLG_Front {
	
	/** @var int The selected version. */
	public static $version;

	/** @var array The selected post types. */
	public static $selected_post_types;
	
	/** @var array The selected taxonomies. */
	public static $selected_taxonomies;
	
	/** @var array The selected plugins. */
	public static $selected_plugins;

	/**
	 * Constructor
	 */
	public function __construct() {
		
		$options = get_option( 'simplelightGallery_settings' );
		
		if ( isset ( $options['lightgallery_post_types'] ) ) {
			self::$selected_post_types = (array) $options['lightgallery_post_types'] ;
		}else{
			self::$selected_post_types = array();
		}
		if ( isset ( $options['lightgallery_taxonomies'] ) ) {
			self::$selected_taxonomies = (array) $options['lightgallery_taxonomies'] ;
		}else{
			self::$selected_taxonomies = array();
		}
		if ( isset ( $options['plugins'] ) ) {
			self::$selected_plugins = (array) $options['plugins'] ;
		}else{
			self::$selected_plugins = array();
		}
		
		if ( isset( $options['version'] ) ) {
			self::$version = $options['version'];
		}else{
			self::$version = 1;
		}
		
		//Hooks
		add_action( 'wp_enqueue_scripts', array( $this, 'simplelightGallery_enqueue_properties_scripts' ) );
	}
	
	public function simplelightGallery_enqueue_properties_scripts() {

		if ( in_array( get_post_type(), self::$selected_post_types ) || is_tax( self::$selected_taxonomies ) ) {
			if ( wp_script_is( 'lightgallery-min', 'enqueued' ) ) {
				return;

			} else {
				switch ( self::$version ):
					case 1:
						wp_register_script( 'lightgallery-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v1/js/lightgallery.min.js', array( 'jquery' ), '1.10.0', true );
						wp_enqueue_script( 'lightgallery-min' );
						wp_enqueue_style( 'lightgallery', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v1/css/lightgallery.min.css', array(), '1.10.0', 'all');
						break;
					case 2:
						wp_register_script( 'lightgallery-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/lightgallery.min.js', array(), '2.2.1', false );
						wp_enqueue_script( 'lightgallery-min' );
						wp_enqueue_style( 'lightgallery', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/css/lightgallery-bundle.min.css', array(), '2.2.1', 'all');

						foreach ( self::$selected_plugins as $selected_plugin => $value ) {
							switch ( $selected_plugin ):
								case 'autoplay':
									wp_register_script( 'lightgallery-lg-autoplay-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/autoplay/lg-autoplay.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-autoplay-min' );
									break;
								case 'comment':
									wp_register_script( 'lightgallery-lg-comment-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/comment/lg-comment.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-comment-min' );
									break;
								case 'fullscreen':
									wp_register_script( 'lightgallery-lg-fullscreen-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/fullscreen/lg-fullscreen.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-fullscreen-min' );
									break;
								case 'hash':
									wp_register_script( 'lightgallery-lg-hash-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/hash/lg-hash.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-hash-min' );
									break;
								case 'mediumZoom':
									wp_register_script( 'lightgallery-lg-mediumZoom-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/mediumZoom/lg-medium-zoom.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-mediumZoom-min' );
									break;
								case 'pager':
									wp_register_script( 'lightgallery-lg-pager-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/pager/lg-pager.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-pager-min' );
									break;
								case 'relativeCaption':
									wp_register_script( 'lightgallery-lg-relativeCaption-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/relativeCaption/lg-relative-caption.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-relativeCaption-min' );
									break;
								case 'rotate':
									wp_register_script( 'lightgallery-lg-rotate-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/rotate/lg-rotate.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-rotate-min' );
									break;
								case 'share':
									wp_register_script( 'lightgallery-lg-share-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/share/lg-share.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-share-min' );
									break;
								case 'thumbnail':
									wp_register_script( 'lightgallery-lg-thumbnail-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/thumbnail/lg-thumbnail.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-thumbnail-min' );
									break;
								case 'video':
									wp_register_script( 'lightgallery-lg-video-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/video/lg-video.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-video-min' );
									break;
								case 'zoom':
									wp_register_script( 'lightgallery-lg-zoom-min', plugin_dir_url( __DIR__ ) . 'assets/lightgallery/v2/plugins/zoom/lg-zoom.min.js', array('lightgallery-min'), '2.2.1', false );
									wp_enqueue_script( 'lightgallery-lg-zoom-min' );
									break;
							endswitch;
						}
						break;
				endswitch;
			}
		}
	}
	
}

new SLG_Front();