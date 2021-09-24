<?php
/**
Plugin Name: Simple lightGallery
Plugin URI: https://themata4all.com
Description: An integration of lightGallery javascript v1 and v2 to Wordpress
Author: Savvas Hadjigeorgiou
Version: 1.0.0
Author URI: https://themata4all.com
*/

add_action( 'admin_enqueue_scripts', 'jquery_chosen_enqueue_assets', -99 );

add_action( 'wp_enqueue_scripts', 'simplelightGallery_enqueue_properties_scripts' );
add_action( 'admin_menu', 'simplelightGallery_add_admin_menu' );
add_action( 'admin_init', 'simplelightGallery_settings_init' );

function jquery_chosen_enqueue_assets( $hook_suffix ) {
	if ( 'settings_page_simple_lightgallery' == $hook_suffix ) {
		wp_enqueue_script( 'jquery-chosen', plugin_dir_url( __FILE__ ) . 'assets/chosen/chosen.jquery.min.js', array( 'jquery' ), '2.2.1' );
		wp_enqueue_script( 'jquery-chosen-lightgallery', plugin_dir_url( __FILE__ ) . 'assets/chosen/simple.lightgallery.chosen.js', array( 'jquery-chosen' ), '2.2.1' );
		wp_enqueue_style( 'jquery-chosen', plugin_dir_url( __FILE__ ) . 'assets/chosen/chosen.min.css', array(), '2.2.1' );
	}
}

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

function simplelightGallery_add_admin_menu(  ) { 

	add_options_page( 'Simple lightGallery', 'Simple lightGallery', 'manage_options', 'simple_lightgallery', 'simplelightGallery_options_page' );

}

function simplelightGallery_settings_init(  ) { 

	register_setting( 'pluginPage', 'simplelightGallery_settings' );

	add_settings_section(
		'simplelightGallery_pluginPage_section', 
		sprintf(__( 'An integration of <a href="%s" target="%s">Lightgallery</a> javascript to Wordpress', 'simplelightGallery' ), 'https://www.lightgalleryjs.com/', '_blank'),
		null, 
		'pluginPage'
	);
	
	add_settings_field( 
		'simplelightGallery_version',
		__( 'Which Version?', 'simplelightGallery' ), 
		'simplelightGallery_version_render', 
		'pluginPage', 
		'simplelightGallery_pluginPage_section' 
	);

	add_settings_field( 
		'simplelightGallery_post_types',
		__( 'In which Post Type pages to enable this?', 'simplelightGallery' ), 
		'simplelightGallery_post_types_render', 
		'pluginPage', 
		'simplelightGallery_pluginPage_section' 
	);

	add_settings_field( 
		'simplelightGallery_taxonomies', 
		__( 'In which Taxonomy pages to enable this?', 'simplelightGallery' ), 
		'simplelightGallery_taxonomies_render', 
		'pluginPage', 
		'simplelightGallery_pluginPage_section' 
	);
	
	add_settings_field( 
		'simplelightGallery_plugins', 
		__( 'Which lightGallery plugins should be enabled?', 'simplelightGallery' ), 
		'simplelightGallery_plugins_render', 
		'pluginPage', 
		'simplelightGallery_pluginPage_section' 
	);


}

function simplelightGallery_version_render(  ) { 

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


function simplelightGallery_post_types_render(  ) { 

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


function simplelightGallery_taxonomies_render(  ) {

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

function simplelightGallery_plugins_render(  ) {

	$plugins = array( 'autoplay', 'comment', 'fullscreen', 'hash', 'mediumZoom', 'pager', 'relativeCaption', 'rotate', 'share', 'thumbnail', 'video', 'zoom' );

	$options = get_option( 'simplelightGallery_settings' );
	?>
	<?php foreach ( $plugins as $plugin ) { ?>
		<input type="checkbox" id="<?php echo $plugin; ?>" name="simplelightGallery_settings[plugins][<?php echo $plugin; ?>]" value="1"<?php checked( isset( $options['plugins'][$plugin] ) ); ?> />
		<label for="<?php echo $plugin; ?>"> <?php echo $plugin; ?></label><br>
	<?php } ?>
	<?php

}


function simplelightGallery_options_page(  ) { 
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