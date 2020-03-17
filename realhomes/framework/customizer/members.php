<?php
/**
 * Members Settings
 *
 * @package RH
 */

if ( ! function_exists( 'inspiry_members_customizer' ) ) :
	function inspiry_members_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Members Panel
		 */
		global $inspiry_pages;

		// Get design variation.
		$rh_design_variation = INSPIRY_DESIGN_VARIATION;

		$wp_customize->add_panel( 'inspiry_members_panel', array(
			'title'    => esc_html__( 'Members', 'framework' ),
			'priority' => 127,
		) );

		/**
		 * Members Basic
		 */
		$wp_customize->add_section( 'inspiry_members_basic', array(
			'title' => esc_html__( 'Basic', 'framework' ),
			'panel' => 'inspiry_members_panel',
		) );

		/* Restrict Access */
		$wp_customize->add_setting( 'theme_restricted_level', array(
			'type'      => 'option',
			'default'   => '0',
			'transport' => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_restricted_level', array(
			'label'       => esc_html__( 'Restrict Admin Side Access', 'framework' ),
			'description' => esc_html__( 'Restrict admin side access to any user level equal to or below the selected user level.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_basic',
			'choices'     => array(
				'0' => esc_html__( 'Subscriber ( Level 0 )', 'framework' ),
				'1' => esc_html__( 'Contributor ( Level 1 )', 'framework' ),
				'2' => esc_html__( 'Author ( Level 2 )', 'framework' ),
				// '7' => esc_html__( 'Editor ( Level 7 )','framework'),
			),
		) );

		if ( 'modern' === $rh_design_variation ) {
			/* Membership Page */
			$wp_customize->add_setting( 'inspiry_membership_page', array(
				'type' => 'option',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_membership_page', array(
				'label'       => esc_html__( 'Select Memberships Page', 'framework' ),
				'description' => esc_html__( 'Selected page should have Memberships Template assigned to it.', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_members_basic',
				'choices'     => $inspiry_pages,
			) );
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Variation */
			$wp_customize->add_setting( 'inspiry_member_pages_header_variation', array(
				'type'    => 'option',
				'default' => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );

			$wp_customize->add_control( 'inspiry_member_pages_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on member pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_members_basic',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		/**
		 * Members Login and Register
		 */
		$wp_customize->add_section( 'inspiry_members_login', array(
			'title' => esc_html__( 'Login & Register', 'framework' ),
			'panel' => 'inspiry_members_panel',
		) );

		/* Enable/Disable Login in Header */
		$wp_customize->add_setting( 'inspiry_header_login', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_header_login', array(
			'label'   => esc_html__( 'Login in Header', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_login',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		/* Login Page */
		$wp_customize->add_setting( 'inspiry_login_register_page', array(
			'type' => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_login_register_page', array(
			'label'       => esc_html__( 'Select Login and Register Page (Optional)', 'framework' ),
			'description' => esc_html__( 'Selected page should have Login & Register Template assigned to it. By default the login modal box will appear and you do not need to configure this option.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_login',
			'choices'     => $inspiry_pages,
		) );

		/* Separator */
		$wp_customize->add_setting( 'inspiry_login_url_separator', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_login_url_separator',
				array(
					'section' => 'inspiry_members_login',
				)
			)
		);

		/**
		 * Members Edit Profile
		 */
		$wp_customize->add_section( 'inspiry_members_profile', array(
			'title' => esc_html__( 'Edit Profile', 'framework' ),
			'panel' => 'inspiry_members_panel',
		) );

		/* Inspiry Edit Profile Page */
		$wp_customize->add_setting( 'inspiry_edit_profile_page', array(
			'type' => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_edit_profile_page', array(
			'label'       => esc_html__( 'Select Edit Profile Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Edit Profile Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_profile',
			'choices'     => $inspiry_pages,
		) );

		/* Separator */
		$wp_customize->add_setting( 'inspiry_profile_url_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_profile_url_separator',
				array(
					'section' => 'inspiry_members_profile',
				)
			)
		);

		/**
		 * Members Submit
		 */
		$wp_customize->add_section( 'inspiry_members_submit', array(
			'title' => esc_html__( 'Submit Property', 'framework' ),
			'panel' => 'inspiry_members_panel',
		) );

		/* Inspiry Submit Property Page */
		$wp_customize->add_setting( 'inspiry_submit_property_page', array(
			'type' => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_page', array(
			'label'       => esc_html__( 'Select Submit Property Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Submit Property Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_submit',
			'choices'     => $inspiry_pages,
		) );

		/* submit button text */
		$wp_customize->add_setting( 'theme_submit_button_text', array(
			'type'              => 'option',
			'default'           => esc_html__('Submit','framework'),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_submit_button_text', array(
			'label'   => esc_html__( 'Submit Button Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_members_submit',
		) );

		/* Show submit button when user login */
		$show_submit_on_login_default = 'true';
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$show_submit_on_login_default = 'false';
		}
		$wp_customize->add_setting( 'inspiry_show_submit_on_login', array(
			'type'              => 'option',
			'default'           => $show_submit_on_login_default,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_show_submit_on_login', array(
			'label'   => esc_html__( 'Show Submit Button Only When User Logged In?', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		/* Submit Property Fields */
		$wp_customize->add_setting( 'inspiry_submit_property_fields', array(
			'type'              => 'option',
			'default'           => array(
				'title',
				'description',
				'property-type',
				'property-status',
				'locations',
				'bedrooms',
				'bathrooms',
				'garages',
				'property-id',
				'price',
				'price-postfix',
				'area',
				'area-postfix',
				'video',
				'images',
				'address-and-map',
				'additional-details',
				'featured',
				'features',
				'agent',
				'parent',
				'reviewer-message',
				'floor-plans',
			),
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control(
			new Inspiry_Multiple_Checkbox_Customize_Control(
				$wp_customize,
				'inspiry_submit_property_fields',
				array(
					'section' => 'inspiry_members_submit',
					'label'   => esc_html__( 'Which fields you want to display in submit form ?', 'framework' ),
					'choices' => array(
						'title'              => esc_html__( 'Property Title', 'framework' ),
						'description'        => esc_html__( 'Property Description', 'framework' ),
						'property-type'      => esc_html__( 'Type', 'framework' ),
						'property-status'    => esc_html__( 'Status', 'framework' ),
						'locations'          => esc_html__( 'Location', 'framework' ),
						'bedrooms'           => esc_html__( 'Bedrooms', 'framework' ),
						'bathrooms'          => esc_html__( 'Bathrooms', 'framework' ),
						'garages'            => esc_html__( 'Garages', 'framework' ),
						'property-id'        => esc_html__( 'Property ID', 'framework' ),
						'price'              => esc_html__( 'Price', 'framework' ),
						'price-postfix'      => esc_html__( 'Price Postfix', 'framework' ),
						'area'               => esc_html__( 'Area', 'framework' ),
						'area-postfix'       => esc_html__( 'Area Postfix', 'framework' ),
						'video'              => esc_html__( 'Video', 'framework' ),
						'images'             => esc_html__( 'Property Images', 'framework' ),
						'address-and-map'    => esc_html__( 'Address and Google Map', 'framework' ),
						'additional-details' => esc_html__( 'Additional Details', 'framework' ),
						'featured'           => esc_html__( 'Mark as Featured Checkbox', 'framework' ),
						'features'           => esc_html__( 'Features', 'framework' ),
						'agent'              => esc_html__( 'Agent', 'framework' ),
						'parent'             => esc_html__( 'Parent Property', 'framework' ),
						'reviewer-message'   => esc_html__( 'Message to Reviewer', 'framework' ),
						'terms-conditions'   => esc_html__( 'Terms & Conditions', 'framework' ),
						'year-built'         => esc_html__( 'Year Built', 'framework' ),
						'floor-plans'        => esc_html__( 'Floor Plans', 'framework' ),
					),
				)
			)
		);

		/* Separator */
		$wp_customize->add_setting( 'inspiry_submit_property_fields_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_submit_property_fields_separator',
				array(
					'section' => 'inspiry_members_submit',
				)
			)
		);

		// terms & conditions field note
		$wp_customize->add_setting( 'inspiry_submit_property_terms_text', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Accept Terms & Conditions before property submission.', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_terms_text', array(
			'label'           => esc_html__( 'Terms & Conditions Note', 'framework' ),
			'description'     => '<strong>' . esc_html__( 'Important:', 'framework' ) . ' </strong>' . esc_html__( 'Please use {link text} pattern in your note text as it will be linked to the Terms & Conditions page.', 'framework' ),
			'type'            => 'text',
			'section'         => 'inspiry_members_submit',
			'active_callback' => 'inspiry_is_submit_property_field_terms'
		) );

		// terms and conditions detail page
		$wp_customize->add_setting( 'inspiry_submit_property_terms_page', array(
			'type' => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_terms_page', array(
			'label'           => esc_html__( 'Select Terms & Conditions Page', 'framework' ),
			'description'     => esc_html__( 'Selected page should have terms & conditions details.', 'framework' ),
			'type'            => 'select',
			'section'         => 'inspiry_members_submit',
			'choices'         => $inspiry_pages,
			'active_callback' => 'inspiry_is_submit_property_field_terms'
		) );

		// require to access the terms and conditions
		$wp_customize->add_setting( 'inspiry_submit_property_terms_require', array(
			'type'    => 'option',
			'default' => true,
			'sanitize_callback' => 'inspiry_sanitize_checkbox',
		) );
		$wp_customize->add_control(
			'inspiry_submit_property_terms_require',
			array(
				'label'           => esc_html__( 'Require Terms & Conditions.', 'framework' ),
				'section'         => 'inspiry_members_submit',
				'type'            => 'checkbox',
				'active_callback' => 'inspiry_is_submit_property_field_terms'
			)
		);

		/* Submitted Property Status */
		$wp_customize->add_setting( 'theme_submitted_status', array(
			'type'      => 'option',
			'default'   => 'pending',
			'transport' => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_submitted_status', array(
			'label'       => esc_html__( 'Submitted Property Status', 'framework' ),
			'description' => esc_html__( 'Select the default status for submitted property.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_submit',
			'choices'     => array(
				'pending' => esc_html__( 'Pending ( Recommended )', 'framework' ),
				'publish' => esc_html__( 'Publish', 'framework' ),
			),
		) );

		/* Default Address in Submit Form */
		$wp_customize->add_setting( 'theme_submit_default_address', array(
			'type'              => 'option',
			'default'           => '15421 Southwest 39th Terrace, Miami, FL 33185, USA',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_submit_default_address', array(
			'label'   => esc_html__( 'Default Address in Submit Form', 'framework' ),
			'type'    => 'textarea',
			'section' => 'inspiry_members_submit',
		) );

		/* Default Map Location */
		$wp_customize->add_setting( 'theme_submit_default_location', array(
			'type'              => 'option',
			'default'           => '25.7308309,-80.44414899999998',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_submit_default_location', array(
			'label'       => esc_html__( 'Default Map Location in Submit Form (Latitude,Longitude)', 'framework' ),
			'description' => 'You can use <a href="http://www.latlong.net/" target="_blank">latlong.net</a> OR <a href="http://itouchmap.com/latlong.html" target="_blank">itouchmap.com</a> to get Latitude and longitude of your desired location.',
			'type'        => 'text',
			'section'     => 'inspiry_members_submit',
		) );

		/* Enable Auto-Generated Property ID */
		$wp_customize->add_setting( 'inspiry_auto_property_id_check', array(
			'type'              => 'option',
			'default'           => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_auto_property_id_check', array(
			'label'   => esc_html__( 'Enable Auto-Generated Property ID', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		/* Enable Auto-Generated Property ID */
		$wp_customize->add_setting( 'inspiry_auto_property_id_pattern', array(
			'type'              => 'option',
			'default'           => 'RH-{ID}-property',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_auto_property_id_pattern', array(
			'label'           => esc_html__( 'Auto-Generated Property ID Pattern', 'framework' ),
			'description'     => '<strong>Important: </strong>' . 'Please use {ID} in your pattern as it will be replaced by the Property ID.',
			'type'            => 'text',
			'section'         => 'inspiry_members_submit',
			'active_callback' => 'inspiry_is_auto_property_id_pattern',
		) );

		$wp_customize->add_setting( 'inspiry_submit_max_number_images', array(
			'type'              => 'option',
			'default'           => 48,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_submit_max_number_images', array(
			'label'           => esc_html__( 'Max Number Of Images To Upload', 'framework' ),
			'type'            => 'number',
			'section'         => 'inspiry_members_submit',
		) );
		
		/*  Property default additional details */
		$wp_customize->add_setting( 'inspiry_property_additional_details', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_property_additional_details', array(
			'label'       => esc_html__( 'Default Additional Details', 'framework' ),
			'description' => "Add title and value 'colon' separated and fields 'comma' separated. <br><br><strong>For Example</strong>: <pre>Plot Size:300,Built Year:2017</pre>",
			'type'        => 'textarea',
			'section'     => 'inspiry_members_submit',
		) );

		/* Message after Submit */
		$wp_customize->add_setting( 'theme_submit_message', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Thanks for Submitting Property!', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_submit_message', array(
			'label'   => esc_html__( 'Message After Successful Submit', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_members_submit',
		) );

		/* Submit Notice */
		$wp_customize->add_setting( 'theme_submit_notice_email', array(
			'type'              => 'option',
			'default'           => get_option( 'admin_email' ),
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_submit_notice_email', array(
			'label'   => esc_html__( 'Submit Notice Email', 'framework' ),
			'type'    => 'email',
			'section' => 'inspiry_members_submit',
		) );





		/**
		 * Members My Properties
		 */
		$wp_customize->add_section( 'inspiry_members_properties', array(
			'title' => esc_html__( 'My Properties', 'framework' ),
			'panel' => 'inspiry_members_panel',
		) );

		/* My Properties Page */
		$wp_customize->add_setting( 'inspiry_my_properties_page', array(
			'type' => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_my_properties_page', array(
			'label'       => esc_html__( 'Select My Properties Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have My Properties Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_properties',
			'choices'     => $inspiry_pages,
		) );

		/* Search Form Display */
		$wp_customize->add_setting( 'inspiry_my_properties_search', array(
			'type'              => 'option',
			'default'           => 'show',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_my_properties_search', array(
			'label'       => esc_html__( 'Display My Properties Search Form', 'framework' ),
			'description' => esc_html__( 'Using this form agents can search in their properties on my properties page.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_members_properties',
			'choices'     => array(
				'show' => esc_html__( 'Show', 'framework' ),
				'hide' => esc_html__( 'Hide', 'framework' )
			),
		) );

		/* Separator */
		$wp_customize->add_setting( 'inspiry_my_properties_url_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_my_properties_url_separator',
				array(
					'section' => 'inspiry_members_properties',
				)
			)
		);

	}

	add_action( 'customize_register', 'inspiry_members_customizer' );
endif;


if ( ! function_exists( 'inspiry_members_defaults' ) ) :
	/**
	 * Set default values for members settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_members_defaults( WP_Customize_Manager $wp_customize ) {
		$members_settings_ids = array(
			'inspiry_member_pages_header_variation',
			'theme_restricted_level',
			'inspiry_header_login',
			'theme_submitted_status',
			'theme_submit_default_address',
			'theme_submit_default_location',
			'inspiry_auto_property_id_check',
			'inspiry_auto_property_id_pattern',
			'theme_submit_message',
			'theme_submit_notice_email',
			'inspiry_submit_property_fields',
			'inspiry_submit_property_terms_text',
		);
		inspiry_initialize_defaults( $wp_customize, $members_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_members_defaults' );
endif;

if ( ! function_exists( 'inspiry_is_auto_property_id_pattern' ) ) {
	/**
	 * Check if property auto id is enabled
	 *
	 * @return bool
	 */
	function inspiry_is_auto_property_id_pattern() {

		$auto_id_check = get_option( 'inspiry_auto_property_id_check' );

		if ( 'true' == $auto_id_check ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_is_submit_property_field_terms' ) ) {
	/**
	 * Check if terms and condidtions field is enabled on the property submit page.
	 *
	 * @return bool|int
	 */
	function inspiry_is_submit_property_field_terms() {

		$term_field_check = get_option( 'inspiry_submit_property_fields' );

		return ( false != strpos( implode( ' ', $term_field_check ), 'terms-conditions' ) ) ? true : false;;
	}
}
