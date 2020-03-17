<?php
/**
 * Required Plugins File
 *
 * Include the TGM_Plugin_Activation class.
 *
 * @since    1.0.0
 * @package RH
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'inspiry_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function inspiry_theme_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Easy Real Estate
		array(
			'name'     => 'Easy Real Estate',
			'slug'     => 'easy-real-estate',
			'version'  => '0.3.1',
			'source'   => 'https://inspiry-plugins.s3.amazonaws.com/easy-real-estate.zip',
			'required' => true,
		),

		// RealHomes Elementor Addon
		array(
			'name'     => 'RealHomes Elementor Addon',
			'slug'     => 'realhomes-elementor-addon',
			'version'  => '0.3.1',
			'source'   => 'https://inspiry-plugins.s3.amazonaws.com/realhomes-elementor-addon.zip',
			'required' => true,
		),

		// Elementor Page Builder
		array(
			'name'      => 'Elementor Page Builder',
			'slug'      => 'elementor',
			'required'  => true,
		),

		// Real Estate CRM
		array(
			'name'     => 'Real Estate CRM',
			'slug'     => 'real-estate-crm',
			'version'  => '0.0.2',
			'source'   => 'https://inspiry-plugins.s3.amazonaws.com/real-estate-crm.zip',
			'required' => true,
		),

		// Mortgage calculator
		array(
			'name'      => 'Mortgage Calculator',
			'slug'      => 'mortgage-calculator',
			'required'  => true,
		),

		// Quick and Easy FAQs
		array(
			'name'      => 'Quick and Easy FAQs',
			'slug'      => 'quick-and-easy-faqs',
			'required'  => false,
		),

		// Quick and Easy Testimonials
		array(
			'name'      => 'Quick and Easy Testimonials',
			'slug'      => 'quick-and-easy-testimonials',
			'required'  => false,
		),

		// One Click Demo Import.
		array(
			'name'      => 'One Click Demo Import',
			'slug'      => 'one-click-demo-import', // The plugin slug (typically the folder name).
			'required'  => false, // If false, the plugin is only 'recommended' instead of required.
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'inspiry', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true, // Show admin notices or not.
		'dismissable'  => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message'      => '', // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}