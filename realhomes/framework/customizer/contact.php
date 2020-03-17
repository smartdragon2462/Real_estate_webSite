<?php
/**
 * Contact Page Customizer Settings
 *
 * @package RH
 */

if ( ! function_exists( 'inspiry_contact_customizer' ) ) :
	function inspiry_contact_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Contact Section
		 */
		$wp_customize->add_section( 'inspiry_contact_section', array(
			'title' => esc_html__( 'Contact Page', 'framework' ),
			'priority' => 129,
		) );


		$wp_customize->add_setting( 'inspiry_contact_note', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Intro_Customize_Control(
				$wp_customize,
				'inspiry_contact_note',
				array(
					'section'     => 'inspiry_contact_section',
					'description' => esc_html_x( "Simply create a page using Contact template and modify settings given below to achieve your requirements.", 'Settings Section Description', 'framework' ),
				)
			)
		);


		// separator
		$wp_customize->add_setting( 'inspiry_contact_map_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_contact_map_separator',
				array(
					'section' => 'inspiry_contact_section',
				)
			)
		);


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Variation */
			$wp_customize->add_setting( 'inspiry_contact_header_variation', array(
				'type'    => 'option',
				'default' => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );

			$wp_customize->add_control( 'inspiry_contact_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on Contact Page.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_contact_section',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		/* Show / Hide Google Map */
		$wp_customize->add_setting( 'theme_show_contact_map', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_show_contact_map', array(
			'label'   => esc_html__( 'Map', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_contact_section',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Google Map Latitude */
		$wp_customize->add_setting( 'theme_map_lati', array(
			'type'              => 'option',
			'default'           => '-37.817917',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_map_lati', array(
			'label'       => esc_html__( 'Map Latitude', 'framework' ),
			'description' => 'You can use <a href="http://www.latlong.net/" target="_blank">latlong.net</a> OR <a href="http://itouchmap.com/latlong.html" target="_blank">itouchmap.com</a> to get Latitude and longitude of your desired location.',
			'type'        => 'text',
			'section'     => 'inspiry_contact_section',
		) );

		/* Google Map Longitude */
		$wp_customize->add_setting( 'theme_map_longi', array(
			'type'              => 'option',
			'default'           => '144.965065',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_map_longi', array(
			'label'   => esc_html__( 'Map Longitude', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_contact_section',
		) );

		/* Google Map Zoom */
		$wp_customize->add_setting( 'theme_map_zoom', array(
			'type'              => 'option',
			'default'           => '17',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_map_zoom', array(
			'label'       => esc_html__( 'Map Zoom Level', 'framework' ),
			'description' => esc_html__( 'Provide Map Zoom Level.', 'framework' ),
			'type'        => 'number',
			'section'     => 'inspiry_contact_section',
		) );

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {

			/* Google Map Type */
			$wp_customize->add_setting( 'inspiry_contact_map_type', array(
				'type'              => 'option',
				'default'           => 'roadmap',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_contact_map_type', array(
				'label'   => esc_html__( 'Map Type', 'framework' ),
				'description' => esc_html__( 'Choose Google Map Type', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_contact_section',
				'choices' => array(
					'roadmap'   => esc_html__( 'RoadMap', 'framework' ),
					'satellite' => esc_html__( 'Satellite', 'framework' ),
					'hybrid'    => esc_html__( 'Hybrid', 'framework' ),
					'terrain'   => esc_html__( 'Terrain', 'framework' ),
				),
			) );
		}
		
		/* Separator */
		$wp_customize->add_setting( 'inspiry_map_zoom_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_map_zoom_separator',
				array(
					'section' => 'inspiry_contact_section',
				)
			)
		);

		/* Show / Hide Contact Details */
		$wp_customize->add_setting( 'theme_show_details', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_show_details', array(
			'label'   => esc_html__( 'Contact Details', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_contact_section',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Contact Details Title */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_contact_details_title', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_contact_details_title', array(
				'label'   => esc_html__( 'Contact Details Title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_contact_section',
			) );

			/* Contact Details Title Selective Refresh */
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( 'theme_contact_details_title', array(
					'selector'            => '.contact-details h3',
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_contact_details_title_render',
				) );
			}
		}

		/* Contact Address */
		$wp_customize->add_setting( 'theme_contact_address', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_field',
		) );
		$wp_customize->add_control( 'theme_contact_address', array(
			'label'   => esc_html__( 'Contact Address', 'framework' ),
			'type'    => 'textarea',
			'section' => 'inspiry_contact_section',
		) );

		/* Contact Address Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_contact_address', array(
				'selector'            => '.contact-details .contacts-list li.address',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_contact_address_render',
			) );
		}

		/* Cell Number */
		$wp_customize->add_setting( 'theme_contact_cell', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_contact_cell', array(
			'label'   => esc_html__( 'Cell Number', 'framework' ),
			'type'    => 'tel',
			'section' => 'inspiry_contact_section',
		) );

		/* Cell Number Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_contact_cell', array(
				'selector'            => '.contact-details .contacts-list li.mobile',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_contact_cell_render',
			) );
		}

		/* Phone Number */
		$wp_customize->add_setting( 'theme_contact_phone', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_contact_phone', array(
			'label'   => esc_html__( 'Phone Number', 'framework' ),
			'type'    => 'tel',
			'section' => 'inspiry_contact_section',
		) );

		/* Phone Number Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_contact_phone', array(
				'selector'            => '.contact-details .contacts-list li.phone',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_contact_phone_render',
			) );
		}

		/* Fax Number */
		$wp_customize->add_setting( 'theme_contact_fax', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_contact_fax', array(
			'label'   => esc_html__( 'Fax Number', 'framework' ),
			'type'    => 'tel',
			'section' => 'inspiry_contact_section',
		) );

		/* Fax Number Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_contact_fax', array(
				'selector'            => '.contact-details .contacts-list li.fax',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_contact_fax_render',
			) );
		}

		/* Display Email */
		$wp_customize->add_setting( 'theme_contact_display_email', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_email',
		) );
		$wp_customize->add_control( 'theme_contact_display_email', array(
			'label'   => esc_html__( 'Display Email', 'framework' ),
			'desc'    => esc_html__( 'Provide Email that will be displayed in contact details section.', 'framework' ),
			'type'    => 'email',
			'section' => 'inspiry_contact_section',
		) );

		/* Display Email Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_contact_display_email', array(
				'selector'            => '.contact-details .contacts-list li.email',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_contact_display_email_render',
			) );
		}

		/* Separator */
		$wp_customize->add_setting( 'inspiry_contact_form_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_contact_form_separator',
				array(
					'section' => 'inspiry_contact_section',
				)
			)
		);

		/* Contact Form Heading */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_contact_form_heading', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_contact_form_heading', array(
				'label'   => esc_html__( 'Contact Form Heading', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_contact_section',
			) );

			/* Contact Form Heading Selective Refresh */
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( 'theme_contact_form_heading', array(
					'selector'            => '#contact-form h3.form-heading',
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_contact_form_heading_render',
				) );
			}
		}

		$contact_form_fields = array(
			'name'    => esc_html__( 'Name Field Label', 'framework' ),
			'email'   => esc_html__( 'Email Field Label', 'framework' ),
			'number'  => esc_html__( 'Phone Number Field Label', 'framework' ),
			'message' => esc_html__( 'Message Field Label', 'framework' ),
		);

		foreach ( $contact_form_fields as $field => $label ){

			$id = 'theme_contact_form_' . $field . '_label';

			$wp_customize->add_setting( $id, array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( $id, array(
				'label'   => $label,
				'type'    => 'text',
				'section' => 'inspiry_contact_section',
			) );

			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( $id, array(
					'selector'            => '#contact-form p label[for="'. $field . '"]',
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_contact_form_'. $field . '_label_render',
				) );
			}
		}

		/* Contact Form Email */
		$wp_customize->add_setting( 'theme_contact_email', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_email',
			'default'           => get_option( 'admin_email' ),
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_contact_email', array(
			'label'       => esc_html__( 'Contact Form Email', 'framework' ),
			'description' => esc_html__( 'Provide email address that will get messages from contact form.', 'framework' ),
			'type'        => 'email',
			'section'     => 'inspiry_contact_section',
		) );

		/* Contact Form CC Email */
		$wp_customize->add_setting( 'theme_contact_cc_email', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_contact_cc_email', array(
			'label'       => esc_html__( 'Contact Form CC Email', 'framework' ),
			'description' => esc_html__( 'You can add multiple comma separated cc email addresses, to get a carbon copy of contact form message.', 'framework' ),
			'type'        => 'email',
			'section'     => 'inspiry_contact_section',
		) );

		/* Contact Form BCC Email */
		$wp_customize->add_setting( 'theme_contact_bcc_email', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_contact_bcc_email', array(
			'label'       => esc_html__( 'Contact Form BCC Email', 'framework' ),
			'description' => esc_html__( 'You can add multiple comma separated bcc email addresses, to get a blind carbon copy of contact form message.', 'framework' ),
			'type'        => 'email',
			'section'     => 'inspiry_contact_section',
		) );

		/* Contact Form Shortcode */
		$wp_customize->add_setting( 'inspiry_contact_form_shortcode', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_contact_form_shortcode', array(
			'label'       => esc_html__( 'Contact Form Shortcode ( To Replace Default Form )', 'framework' ),
			'description' => esc_html__( 'If you want to replace default contact form with a plugin based form then provide its shortcode here.', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_contact_section',
		) );

	}

	add_action( 'customize_register', 'inspiry_contact_customizer' );
endif;

if ( ! function_exists( 'inspiry_contact_defaults' ) ) :
	/**
	 * Set default values for contact settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_contact_defaults( WP_Customize_Manager $wp_customize ) {
		$contact_settings_ids = array(
			'inspiry_contact_header_variation',
			'theme_show_contact_map',
			'theme_map_lati',
			'theme_map_longi',
			'theme_map_zoom',
			'theme_show_details',
			'theme_contact_email',
		);
		inspiry_initialize_defaults( $wp_customize, $contact_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_contact_defaults' );
endif;

if ( ! function_exists( 'inspiry_contact_details_title_render' ) ) {
	function inspiry_contact_details_title_render() {
		if ( get_option( 'theme_contact_details_title' ) ) {
			echo get_option( 'theme_contact_details_title' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_address_render' ) ) {
	function inspiry_contact_address_render() {
		if ( get_option( 'theme_contact_address' ) ) {
			include( INSPIRY_THEME_DIR . '/images/icon-map.svg' );
			_e( 'Address', 'framework' );
			echo ': ' . get_option( 'theme_contact_address' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_cell_render' ) ) {
	function inspiry_contact_cell_render() {
		if ( get_option( 'theme_contact_cell' ) ) {
			$contact_cell    = get_option( 'theme_contact_cell' );
			$desktop_version = '<span class="desktop-version">' . $contact_cell . '</span>';
			$mobile_version  = '<a class="mobile-version" href="tel://' . $contact_cell . '" title="Make a Call">' . $contact_cell . '</a>';
			include( INSPIRY_THEME_DIR . '/images/icon-mobile.svg' );
			_e( 'Mobile', 'framework' );
			echo ': ' . $desktop_version . $mobile_version;
		}
	}
}

if ( ! function_exists( 'inspiry_contact_phone_render' ) ) {
	function inspiry_contact_phone_render() {
		if ( get_option( 'theme_contact_phone' ) ) {
			$contact_phone   = get_option( 'theme_contact_phone' );
			$desktop_version = '<span class="desktop-version">' . $contact_phone . '</span>';
			$mobile_version  = '<a class="mobile-version" href="tel://' . $contact_phone . '" title="Make a Call">' . $contact_phone . '</a>';
			include( INSPIRY_THEME_DIR . '/images/icon-phone.svg' );
			_e( 'Phone', 'framework' );
			echo ': ' . $desktop_version . $mobile_version;
		}
	}
}

if ( ! function_exists( 'inspiry_contact_fax_render' ) ) {
	function inspiry_contact_fax_render() {
		if ( get_option( 'theme_contact_fax' ) ) {
			include( INSPIRY_THEME_DIR . '/images/icon-printer.svg' );
			_e( 'Fax', 'framework' );
			echo ': ' . get_option( 'theme_contact_fax' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_display_email_render' ) ) {
	function inspiry_contact_display_email_render() {
		if ( get_option( 'theme_contact_display_email' ) ) {
			include( INSPIRY_THEME_DIR . '/images/icon-mail.svg' );
			_e( 'Email', 'framework' );
			echo ': ' . get_option( 'theme_contact_display_email' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_form_heading_render' ) ) {
	function inspiry_contact_form_heading_render() {
		if ( get_option( 'theme_contact_form_heading' ) ) {
			echo get_option( 'theme_contact_form_heading' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_form_name_label_render' ) ) {
	function inspiry_contact_form_name_label_render() {
		if ( get_option( 'theme_contact_form_name_label' ) ) {
			echo get_option( 'theme_contact_form_name_label' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_form_email_label_render' ) ) {
	function inspiry_contact_form_email_label_render() {
		if ( get_option( 'theme_contact_form_email_label' ) ) {
			echo get_option( 'theme_contact_form_email_label' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_form_number_label_render' ) ) {
	function inspiry_contact_form_number_label_render() {
		if ( get_option( 'theme_contact_form_number_label' ) ) {
			echo get_option( 'theme_contact_form_number_label' );
		}
	}
}

if ( ! function_exists( 'inspiry_contact_form_message_label_render' ) ) {
	function inspiry_contact_form_message_label_render() {
		if ( get_option( 'theme_contact_form_message_label' ) ) {
			echo get_option( 'theme_contact_form_message_label' );
		}
	}
}
