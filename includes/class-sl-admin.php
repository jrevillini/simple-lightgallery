<?php

/**
 * Admin functionality
 * @package Simple lightGallery
 * @subpackage Admin
 * @author Savvas Hadjigeorgiou
 */
 
class SLG_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {

		//Hooks
		add_action( 'admin_menu', array( $this, 'simplelightGallery_add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'simplelightGallery_settings_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'jquery_chosen_enqueue_assets' ), -99 );
		
		add_filter( 'plugin_action_links_' . SL_PLUGIN_BASE,  array( $this, 'slg_plugin_settings_link' ) );
	}
	
	public function simplelightGallery_add_admin_menu() { 
		add_options_page( 'Simple lightGallery', 'Simple lightGallery', 'manage_options', 'simple_lightgallery', array( $this, 'simplelightGallery_options_page' ) );
	}
	
	public function simplelightGallery_options_page() { 
		?>
		<form action='options.php' method='post'>
			<h2>Simple lightGallery</h2>
			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>
		</form>
		<?php
	}
	
	public function slg_plugin_settings_link( $links ) { 
		$plink = array(
						'<a href="' . admin_url( 'options-general.php?page=simple_lightgallery' ) . '">Settings</a>',
					);

		$links = array_merge( $links, $plink );
		
		return $links; 
	}
	
	public function simplelightGallery_settings_init() { 
		register_setting( 'pluginPage', 'simplelightGallery_settings' );

		add_settings_section(
			'simplelightGallery_pluginPage_section', 
			sprintf(__( 'An integration of <a href="%s" target="%s">Lightgallery</a> javascript to Wordpress', 'simplelightGallery' ), 'https://www.lightgalleryjs.com/', '_blank'),
			null, 
			'pluginPage'
		);
		
		add_settings_field( 
			'simplelightGallery_version',
			__( 'Which lightGallery version to use?', 'simplelightGallery' ), 
			array( $this, 'simplelightGallery_version_render' ), 
			'pluginPage', 
			'simplelightGallery_pluginPage_section' 
		);

		add_settings_field( 
			'simplelightGallery_post_types',
			__( 'In which Post Type pages to enable this?', 'simplelightGallery' ), 
			array( $this, 'simplelightGallery_post_types_render' ), 
			'pluginPage', 
			'simplelightGallery_pluginPage_section' 
		);

		add_settings_field( 
			'simplelightGallery_taxonomies', 
			__( 'In which Taxonomy pages to enable this?', 'simplelightGallery' ), 
			array( $this, 'simplelightGallery_taxonomies_render' ), 
			'pluginPage', 
			'simplelightGallery_pluginPage_section' 
		);
		
		if ( SLG_Front::$version == 2 ) {
			add_settings_field( 
				'simplelightGallery_plugins', 
				__( 'Which lightGallery v2 plugins should be enabled?', 'simplelightGallery' ), 
				array( $this, 'simplelightGallery_plugins_render' ), 
				'pluginPage', 
				'simplelightGallery_pluginPage_section' 
			);
		}
	}
	
	public function simplelightGallery_version_render() { 
		$options = get_option( 'simplelightGallery_settings' );
		if ( isset( $options['version'] ) ) {
			$version = $options['version'];
		}else{
			$version = 1;
		}
		?>
		<input type="radio" name="simplelightGallery_settings[version]" value="1" <?php checked(1, $version, true); ?>>v1.10.0
		<input type="radio" name="simplelightGallery_settings[version]" value="2" <?php checked(2, $version, true); ?>>v2.2.1
		<?php
	}


	public function simplelightGallery_post_types_render() { 
		$post_types = get_post_types();

		$options = get_option( 'simplelightGallery_settings' );
		if ( isset( $options['lightgallery_post_types'] ) ) {
			$selected_post_types = (array) $options['lightgallery_post_types'];
		}else{
			$selected_post_types = array();
		}
		?>
		<select name="simplelightGallery_settings[lightgallery_post_types][]" id="lightgallery_post_types" multiple>
		<?php foreach ( $post_types as $key => $name ) { 
				$selected = in_array( $name, $selected_post_types ) ? ' selected="selected" ' : '';
		?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
		<?php } ?>
		</select>
		<?php
	}


	public function simplelightGallery_taxonomies_render() {
		$taxonomies = get_taxonomies();

		$options = get_option( 'simplelightGallery_settings' );
		if ( isset( $options['lightgallery_taxonomies'] ) ) {
			$selected_taxonomies = (array) $options['lightgallery_taxonomies'];
		}else{
			$selected_taxonomies = array();
		}
		?>
		<select name="simplelightGallery_settings[lightgallery_taxonomies][]" id="lightgallery_taxonomies" multiple>
		<?php foreach ( $taxonomies as $key => $name ) { 
				$selected = in_array( $name, $selected_taxonomies ) ? ' selected="selected" ' : '';
		?>
			<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
		<?php } ?>
		</select>
		<?php
	}

	public function simplelightGallery_plugins_render() {
		$plugins = array( 'autoplay', 'comment', 'fullscreen', 'hash', 'mediumZoom', 'pager', 'relativeCaption', 'rotate', 'share', 'thumbnail', 'video', 'zoom' );

		$options = get_option( 'simplelightGallery_settings' );
		?>
		<?php foreach ( $plugins as $plugin ) { ?>
			<input type="checkbox" id="<?php echo $plugin; ?>" name="simplelightGallery_settings[plugins][<?php echo $plugin; ?>]" value="1"<?php checked( isset( $options['plugins'][$plugin] ) ); ?> />
			<label for="<?php echo $plugin; ?>"> <?php echo $plugin; ?></label><br>
		<?php } ?>
		<?php
	}
	
	public function jquery_chosen_enqueue_assets( $hook_suffix ) {
		if ( 'settings_page_simple_lightgallery' == $hook_suffix ) {
			wp_enqueue_script( 'jquery-chosen', plugin_dir_url( __DIR__ ) . 'assets/chosen/chosen.jquery.min.js', array( 'jquery' ), '2.2.1' );
			wp_enqueue_script( 'jquery-chosen-lightgallery', plugin_dir_url( __DIR__ ) . 'assets/chosen/simple.lightgallery.chosen.js', array( 'jquery-chosen' ), '2.2.1' );
			wp_enqueue_style( 'jquery-chosen', plugin_dir_url( __DIR__ ) . 'assets/chosen/chosen.min.css', array(), '2.2.1' );
		}
	}
	
}

new SLG_Admin();