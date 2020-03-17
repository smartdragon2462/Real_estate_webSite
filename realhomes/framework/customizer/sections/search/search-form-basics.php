<?php
/**
 * Section: `Search Form Basics`
 * Panel:   `Properties Search`
 *
 * @package RH
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_search_form_basics_customizer' ) ) :

	/**
	 * Search Form Basic Customizer Settings.
	 *
	 * @param  WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 * @since  2.6.3
	 */
	function inspiry_search_form_basics_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Search Form Basics
		 */
		$wp_customize->add_section(
			'inspiry_properties_search_form', array(
				'title' => esc_html__( 'Search Form Basics', 'framework' ),
				'panel' => 'inspiry_properties_search_panel',
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'inspiry_search_form_mod_layout_options', array(
					'type'              => 'option',
					'default'           => 'default',
					'sanitize_callback' => 'inspiry_sanitize_radio',
				)
			);

			$wp_customize->add_control( 'inspiry_search_form_mod_layout_options', array(
				'label'       => esc_html__( 'Search Form Layout ', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_properties_search_form',
				'choices'     => array(
					'default'  => esc_html__( 'Default', 'framework' ),
					'smart'  => esc_html__( 'Smart', 'framework' ),
				),
			) );


		}


		/* Search Form Title */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'theme_home_advance_search_title', array(
					'type'              => 'option',
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html__( 'Find Your Home', 'framework' ),
				)
			);
			$wp_customize->add_control(
				'theme_home_advance_search_title', array(
					'label'     => esc_html__( 'Search Form Title', 'framework' ),
					'type'      => 'text',
					'section'   => 'inspiry_properties_search_form',
				)
			);
		}

		/* Search Form Title Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'theme_home_advance_search_title', array(
					'selector'              => '.search-heading',
					'container_inclusive'   => false,
					'render_callback'       => 'inspiry_home_advance_search_title_render',
				)
			);
		}

		/* Search Fields */

			$get_stored_order = get_option('theme_search_fields');
			$search_fields = array(
				'keyword-search'    => esc_html__( 'Keyword Search', 'framework' ),
				'property-id'   => esc_html__( 'Property ID', 'framework' ),
				'location'      => esc_html__( 'Property Location', 'framework' ),
				'status'        => esc_html__( 'Property Status', 'framework' ),
				'type'          => esc_html__( 'Property Type', 'framework' ),
				'agent'         => esc_html__( 'Agent', 'framework' ),
				'min-beds'      => esc_html__( 'Min Beds', 'framework' ),
				'min-baths'     => esc_html__( 'Min Baths', 'framework' ),
				'min-max-price' => esc_html__( 'Min and Max Price', 'framework' ),
				'min-max-area'  => esc_html__( 'Min and Max Area', 'framework' ),
				'min-garages'   => esc_html__( 'Min Garages', 'framework' ),
			);

			if ( ! empty( $get_stored_order ) && is_array( $get_stored_order ) ) {
				$search_fields = array_merge( array_flip( $get_stored_order ), $search_fields );

		}
		$wp_customize->add_setting(
			'theme_search_fields', array(
				'type'              => 'option',
				'default'           => array( 'keyword-search', 'property-id', 'location', 'status', 'type', 'min-beds', 'min-baths', 'min-max-price', 'min-max-area' ),
				'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Multiple_Checkbox_Customize_Control_sortable(
				$wp_customize,
				'theme_search_fields',
				array(
					'section'   => 'inspiry_properties_search_form',
					'label'     => esc_html__( 'Which fields you want to display in search form ?', 'framework' ),
					'choices'   => $search_fields,
				)
			)
		);


		$wp_customize->add_setting( 'inspiry_search_fields_feature_search', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		$wp_customize->add_control( 'inspiry_search_fields_feature_search', array(
			'label'       => esc_html__( 'Property Features Search Field ', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_properties_search_form',
			'choices'     => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false'  => esc_html__( 'Hide', 'framework' ),
			),
		) );



		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_search_fields_main_row', array(
				'type'    => 'option',
				'default' => '4',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );

			$wp_customize->add_control( 'inspiry_search_fields_main_row', array(
				'label'       => esc_html__( 'Number Of Fields To Display In Top Row', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_properties_search_form',
				'choices'     => array(
					'1' => esc_html__( 'One', 'framework' ),
					'2' => esc_html__( 'Two', 'framework' ),
					'3' => esc_html__( 'Three', 'framework' ),
					'4' => esc_html__( 'Four', 'framework' ),
				),
			) );
		}



		/* Separator */


		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_keyword_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_keyword_separator',
					array(
						'section'   => 'inspiry_properties_search_form',
					)
				)
			);

			/* Collapse sidebar Advance Search form fields */
			$wp_customize->add_setting( 'inspiry_sidebar_asf_collapse', array(
				'type'    => 'option',
				'default' => 'no',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );

			$wp_customize->add_control( 'inspiry_sidebar_asf_collapse', array(
				'label'       => esc_html__( 'Collapse sidebar Advance Search form', 'framework' ),
				'description' => esc_html__( 'Collapse more Advance Search form fields in sidebar by default.', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_properties_search_form',
				'choices'     => array(
					'no'  => esc_html__( 'Disable', 'framework' ),
					'yes' => esc_html__( 'Enable', 'framework' ),
				),
			) );
		}

		/* Separator */
		$wp_customize->add_setting( 'inspiry_sidebar_asf_collapse_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_sidebar_asf_collapse_separator',
				array(
					'section' => 'inspiry_properties_search_form',
				)
			)
		);

		/* Keyword Label */
		$wp_customize->add_setting(
			'inspiry_keyword_label', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Keyword', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_keyword_label', array(
				'label'     => esc_html__( 'Label for Keyword Search', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Keyword Placeholder Text */
		$wp_customize->add_setting(
			'inspiry_keyword_placeholder_text', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Any', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_keyword_placeholder_text', array(
				'label'     => esc_html__( 'Placeholder Text for Keyword Search', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Separator */
		$wp_customize->add_setting( 'inspiry_property_id_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_property_id_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Property ID Label */
		$wp_customize->add_setting(
			'inspiry_property_id_label', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Property ID', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_id_label', array(
				'label'     => esc_html__( 'Label for Property ID', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Property ID Placeholder Text */
		$wp_customize->add_setting(
			'inspiry_property_id_placeholder_text', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Any', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_id_placeholder_text', array(
				'label'     => esc_html__( 'Placeholder Text for Property ID', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Separator */
		$wp_customize->add_setting( 'inspiry_search_taxonomy_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_search_taxonomy_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Property Status Label */
		$wp_customize->add_setting(
			'inspiry_property_status_label', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Property Status', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_status_label', array(
				'label'     => esc_html__( 'Label for Property Status', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		$wp_customize->add_setting( 'inspiry_property_status_placeholder', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_status_placeholder', array(
			'label' 	=> esc_html__( 'Placeholder for Property Status', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_properties_search_form',
		) );

		$wp_customize->add_setting( 'inspiry_search_status_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_search_status_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Property Type Label */
		$wp_customize->add_setting(
			'inspiry_property_type_label', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Property Type', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_type_label', array(
				'label'     => esc_html__( 'Label for Property Type', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		$wp_customize->add_setting( 'inspiry_property_type_placeholder', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_type_placeholder', array(
			'label' 	=> esc_html__( 'Placeholder for Property Type', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_properties_search_form',
		) );

		$wp_customize->add_setting( 'inspiry_search_type_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_search_type_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Agent Label */
		$wp_customize->add_setting(
			'inspiry_agent_field_label', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Agent', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_agent_field_label', array(
				'label'     => esc_html__( 'Label for Agent', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		$wp_customize->add_setting( 'inspiry_property_agent_placeholder', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_agent_placeholder', array(
			'label' 	=> esc_html__( 'Placeholder for Property Agent', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_properties_search_form',
		) );

		$wp_customize->add_setting( 'inspiry_search_agent_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_search_agent_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Search Button Text */
		$wp_customize->add_setting(
			'inspiry_search_button_text', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Search', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_search_button_text', array(
				'label'     => esc_html__( 'Search Button Text', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Separator */
		$wp_customize->add_setting( 'inspiry_any_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_any_separator',
				array(
					'section'   => 'inspiry_properties_search_form',
				)
			)
		);

		/* Any Text */
		$wp_customize->add_setting(
			'inspiry_any_text', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Any', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_any_text', array(
				'label'     => esc_html__( 'Any Text', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Search Features Title */
		$wp_customize->add_setting(
			'inspiry_search_features_title', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Looking for certain features', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_search_features_title', array(
				'label'     => esc_html__( 'Title for Features Toggle', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form',
			)
		);

		/* Search Features Title Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_search_features_title', array(
					'selector'              => '.advance-search .more-option-trigger a',
					'container_inclusive'   => false,
					'render_callback'       => 'inspiry_search_features_title_render',
				)
			);
		}

	}

	add_action( 'customize_register', 'inspiry_search_form_basics_customizer' );
endif;


if ( ! function_exists( 'inspiry_search_form_basics_defaults' ) ) :

	/**
	 * inspiry_search_form_basics_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_search_form_basics_defaults( WP_Customize_Manager $wp_customize ) {
		$search_form_basics_settings_ids = array(
			'theme_home_advance_search_title',
			'theme_search_fields',
			'inspiry_keyword_label',
			'inspiry_keyword_placeholder_text',
			'inspiry_property_id_label',
			'inspiry_property_id_placeholder_text',
			'inspiry_property_status_label',
			'inspiry_property_type_label',
			'inspiry_agent_field_label',
			'inspiry_any_text',
			'inspiry_search_button_text',
			'inspiry_search_features_title',
		);
		inspiry_initialize_defaults( $wp_customize, $search_form_basics_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_search_form_basics_defaults' );
endif;


if ( ! function_exists( 'inspiry_home_advance_search_title_render' ) ) {
	function inspiry_home_advance_search_title_render() {
		if ( get_option( 'theme_home_advance_search_title' ) ) {
			echo '<i class="fa fa-search"></i>' . get_option( 'theme_home_advance_search_title' );
		}
	}
}


if ( ! function_exists( 'inspiry_search_features_title_render' ) ) {
	function inspiry_search_features_title_render() {
		if ( get_option( 'inspiry_search_features_title' ) ) {
			echo '<i class="fa fa-plus-square-o"></i>' . get_option( 'inspiry_search_features_title' );
		}
	}
}