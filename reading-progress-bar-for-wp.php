<?php
/*
 * Plugin Name:       Reading Progress Bar for WP
 * Plugin URI:        https://graspers.000webhostapp.com/
 * Description:       A Reading progress bar is a visual representation to let the users know approximately how long the article will take them to complete. It can be used where you want like top, bottom
 * Version:           1.0
 * Author:            uniqe-coder
 * Author URI: https://graspers.000webhostapp.com/
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reading-progress-bar-for-wp


*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('READING_PROGRESS_BAR_FOR_WP_VERSION','1.0');
define('READING_PROGRESS_BAR_FOR_WP_PLUGIN_URI', plugin_dir_url(__FILE__));
define('READING_PROGRESS_BAR_FOR_WP_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
define('READING_PROGRESS_BAR_FOR_WP_BASENAME',plugin_basename(__FILE__));

add_action( 'wp_enqueue_scripts', 'enqueue_styles_reading_progressbar_public_rbp');
function enqueue_styles_reading_progressbar_public_rbp() {
	wp_enqueue_style( 'rpbfwp-styles', plugin_dir_url(__FILE__ ) . 'assets/css/rp-bar.css', array(), '', 'all');
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts_reading_progressbar_public_aaaa');
function enqueue_scripts_reading_progressbar_public_aaaa() {
	wp_enqueue_script( 'rpbfwp-scripts', plugin_dir_url(__FILE__ ) . 'js/rp-public.js', array( 'jquery'), '', false);
}

add_action( 'admin_enqueue_scripts', 'enqueue_scripts_reading_progressbar_admin_rpb');
function enqueue_scripts_reading_progressbar_admin_rpb() {
	wp_enqueue_script( 'rp-admin-scripts', plugin_dir_url(__FILE__ ) . 'js/rp-admin.js', array( 'jquery', 'wp-color-picker'), '', false);
}

add_action( 'admin_enqueue_scripts', 'enqueue_scripts_reading_progressbar_admin_css');
function enqueue_scripts_reading_progressbar_admin_css() {
	wp_enqueue_style( 'admin-styles', plugin_dir_url(__FILE__ ) . 'assets/css/rp-admin_r.css');
}

add_action( 'admin_menu', 'post_views_for_wp_admin_menu_pp');
function post_views_for_wp_admin_menu_pp() {
	add_options_page( __('Reading PB for WP', 'reading-progress-bar-for-wp'), __('Reading PB for WP', 'reading-progress-bar-for-wp'), 'manage_options', 'reading-progress-bar-for-wp-settings', 'reading_progress_bar_for_wp_options');
}

add_action( 'admin_init', 'reading_progress_bar_for_wp_options_settings');
function reading_progress_bar_for_wp_options_settings() {
	register_setting( 'rpforwp_wp_page', 'rpforwp_wp_page_settings');
	add_settings_section( 'rpforwp_wp_page_section', __( 'Reading PB options', 'reading-progress-bar-for-wp'), 'rpforwp_wp_page_settings_caller', 'rpforwp_wp_page');
	add_settings_field( 'rpbforwp_field_posttypes', __( 'Select post types to render Progress Bar', 'reading-progress-bar-for-wp'), 'rpforwp_wp_page_posttypes_selector', 'rpforwp_wp_page', 'rpforwp_wp_page_section');
	add_settings_field( 'rpbforwp_height', __( 'Select Height', 'reading-progress-bar-for-wp'), 'rpbforwp_height_render', 'rpforwp_wp_page', 'rpforwp_wp_page_section');
	add_settings_field( 'rpbforwp_position', __( 'Select Position', 'reading-progress-bar-for-wp'), 'rpbforwp_position_render', 'rpforwp_wp_page', 'rpforwp_wp_page_section');
	add_settings_field( 'rpbforwp_fg_color', __( 'Select Foreground Color', 'reading-progress-bar-for-wp'), 'rpbforwp_fg_render', 'rpforwp_wp_page', 'rpforwp_wp_page_section');
	add_settings_field( 'rpbforwp_bg_color', __( 'Select Background Color', 'reading-progress-bar-for-wp'), 'rpbforwp_bg_render', 'rpforwp_wp_page', 'rpforwp_wp_page_section');
}

function rpforwp_wp_page_posttypes_selector() {
	$rpb_forwp_opt=get_option( 'rpforwp_wp_page_settings');
	$rpb_forwp_PostType='';
	if (isset($rpb_forwp_opt['rpbforwp_field_posttypes'])) {
		$Postypes_opt=$rpb_forwp_opt['rpbforwp_field_posttypes'];
		$post_types=get_post_types( array( 'public'=> true), 'objects');
		foreach ( $post_types as $in_types=> $pos_t) {
			$rpb_forwp_PostType=$Postypes_opt[$pos_t->name];
			?><p><input type='checkbox' name='rpforwp_wp_page_settings[rpbforwp_field_posttypes][<?php echo $pos_t->name; ?>]' <?php checked( $rpb_forwp_PostType=='1');
			?>value='1' /><?php echo $pos_t->labels->name;
			?></p><?php
		}
	}
	else {
		$post_types=get_post_types( array( 'public'=> true), 'objects');
		foreach ( $post_types as $in_types=> $pos_t) {
			?><p><input type='checkbox' name='rpforwp_wp_page_settings[rpbforwp_field_posttypes][<?php echo $pos_t->name; ?>]' value='1' /><?php echo $pos_t->labels->name;
			?></p><?php
		}
	}
}

function rpbforwp_height_render() {
	$rpb_forwp_height=get_option( 'rpforwp_wp_page_settings');
	//if(isset($rpb_forwp_height['rpbforwp_height'])){
	$rpb_forwp_height_val=$rpb_forwp_height['rpbforwp_height'];
	//print_r($rpb_forwp_height_val); die;
	//}?>
	<input type='number' name='rpforwp_wp_page_settings[rpbforwp_height]' value='<?php echo $rpb_forwp_height_val; ?>'><?php
}

function rpbforwp_position_render() {
	$rpb_forwp_main=get_option( 'rpforwp_wp_page_settings');
	//if(isset($rpb_forwp_height['rpbforwp_height'])){
	$rpb_forwp_pos_val=$rpb_forwp_main['rpbforwp_position'];
	//print_r($rpb_forwp_height_val); die;
	//}?>
	<select name='rpforwp_wp_page_settings[rpbforwp_position]'><option value='top' <?php selected( $rpb_forwp_pos_val, 'top');
	?>><?php echo __('Top', 'reading-progress-bar-for-wp');
	?></option><option value='bottom' <?php selected( $rpb_forwp_pos_val, 'bottom');
	?>><?php echo __('Bottom', 'reading-progress-bar-for-wp');
	?></option></select><?php
}

function rpbforwp_fg_render() {
	$rpb_forwp_main=get_option( 'rpforwp_wp_page_settings');
	//if(isset($rpb_forwp_height['rpbforwp_height'])){
	$rpb_forwp_fg_val=$rpb_forwp_main['rpbforwp_fg_color'];
	//print_r($rpb_forwp_height_val); die;
	//}?>
	<input class="rp-forwp-colorpick" value="<?php echo $rpb_forwp_fg_val; ?>" type="text" name="rpforwp_wp_page_settings[rpbforwp_fg_color]"><?php
}

function rpbforwp_bg_render() {
	$rpb_forwp_main=get_option( 'rpforwp_wp_page_settings');
	$rpb_forwp_bg_val=$rpb_forwp_main['rpbforwp_bg_color'];
	//print_r($rpb_forwp_bg_val); die;
	?><input type="text" class="rp-forwp-colorpick" name="rpforwp_wp_page_settings[rpbforwp_bg_color]" value="<?php echo $rpb_forwp_bg_val; ?>"><?php
}

add_action( 'wp_footer', 'reading_pg_bar_forwp_render_out');
function reading_pg_bar_forwp_render_out() {
	$postviewssettings=get_option( 'rpforwp_wp_page_settings');
	if(isset($postviewssettings['rpbforwp_field_posttypes'])) {
		$internal_settings=$postviewssettings['rpbforwp_field_posttypes'];
		$support_array=array();
		foreach ($internal_settings as $key=> $value) {
			$support_array[]=$key;
		}
		if(!empty($support_array) && is_singular($support_array)) {
			$rpb_forwp_main=get_option( 'rpforwp_wp_page_settings');
			$rb_ht=$rpb_forwp_main['rpbforwp_height'];
			$rb_pos=$rpb_forwp_main['rpbforwp_position'];
			$rpfwp_up_layer=$rpb_forwp_main['rpbforwp_fg_color'];
			$$rpfwp_bg_layer=$rpb_forwp_main['rpbforwp_bg_color'];
			$rpb_forwp_bg_val=$rpb_forwp_main['rpbforwp_bg_color'];
			echo '<progress height="'.$rb_ht.'" class="rp_bar" position="'.$rb_pos.'"  value="0" up_layer="'.$rpfwp_up_layer.'" background="'.$rpb_forwp_bg_val.'" ></progress>';
		}
	}
}

function rpforwp_wp_page_settings_caller() {
	echo "Here are the settings below";
}

function reading_progress_bar_for_wp_options() {
	?><form action='options.php' method='post'><?php settings_fields( 'rpforwp_wp_page');
	do_settings_sections( 'rpforwp_wp_page');
	submit_button();
	?></form><?php
}