<?php
/**
 * Section:	`Map`
 * Panel: 	`Property Detail Page`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_property_map_customizer' ) ) :

	/**
	 * inspiry_property_map_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_property_map_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Map Section
		 */

		$wp_customize->add_section( 'inspiry_property_map', array(
			'title' => esc_html__( 'Map', 'framework' ),
			'panel' => 'inspiry_property_panel',
		) );

		/* Show/Hide Map */
		$wp_customize->add_setting( 'theme_display_google_map', array(
			'type' => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_google_map', array(
			'label' => esc_html__( 'Google Map', 'framework' ),
			'type' => 'radio',
			'section' => 'inspiry_property_map',
			'choices' => array(
				'true' => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Map Title */
		$wp_customize->add_setting( 'theme_property_map_title', array(
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'default' 			=> esc_html__( 'Property on Map', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_property_map_title', array(
			'label' 	=> esc_html__( 'Property Map Title', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_property_map',
		) );

		/* Video Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$map_title_selector = '.map-wrap .map-label';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$map_title_selector = '.rh_property__map_wrap .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_property_map_title', array(
				'selector' 				=> $map_title_selector,
				'container_inclusive'	=> false,
				'render_callback' 		=> 'inspiry_property_map_title_render',
			) );
		}

		/* Google/OSM Map Zoom */
		$wp_customize->add_setting( 'inspiry_property_map_zoom', array(
			'type'              => 'option',
			'default'           => '15',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_map_zoom', array(
			'label'       => esc_html__( 'Map Zoom Level', 'framework' ),
			'description' => esc_html__( 'Provide Map Zoom Level.', 'framework' ),
			'type'        => 'number',
			'section'     => 'inspiry_property_map',
		) );

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {

			/* Google Map Type */
			$wp_customize->add_setting( 'inspiry_property_map_type', array(
				'type'              => 'option',
				'default'           => 'roadmap',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_property_map_type', array(
				'label'   => esc_html__( 'Map Type', 'framework' ),
				'description' => esc_html__( 'Choose Google Map Type', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_property_map',
				'choices' => array(
					'roadmap'   => esc_html__( 'RoadMap', 'framework' ),
					'satellite' => esc_html__( 'Satellite', 'framework' ),
					'hybrid'    => esc_html__( 'Hybrid', 'framework' ),
					'terrain'   => esc_html__( 'Terrain', 'framework' ),
				),
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_property_map_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_map_defaults' ) ) :

	/**
	 * inspiry_property_map_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_map_defaults( WP_Customize_Manager $wp_customize ) {
		$property_map_settings_ids = array(
			'theme_display_google_map',
			'theme_property_map_title',
		);
		inspiry_initialize_defaults( $wp_customize, $property_map_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_property_map_defaults' );
endif;


if ( ! function_exists( 'inspiry_property_map_title_render' ) ) {
	function inspiry_property_map_title_render() {
		if ( get_option( 'theme_property_map_title' ) ) {
			echo get_option( 'theme_property_map_title' );
		}
	}
}
