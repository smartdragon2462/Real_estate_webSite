<?php
/**
 * Section:	`Styles`
 * Panel: 	`Header`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_header_styles_customizer' ) ) :

	/**
	 * inspiry_header_styles_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_header_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Styles Section
		 */
		$wp_customize->add_section( 'inspiry_header_styles', array(
			'title' => esc_html__( 'Header Styles', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_header_menu_top_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_menu_top_color',
					array(
						'label'       => esc_html__( 'Menu wrapper Background Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'active_callback' => function(){
							if ( 'two' == get_option( 'inspiry_header_mod_variation_option' ) ||
							     'three' == get_option( 'inspiry_header_mod_variation_option' ) ) {
								return true;
							}
							return false;
						}
					)
				)
			);
				$wp_customize->add_setting( 'theme_header_meta_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_meta_bg_color',
					array(
						'label'       => esc_html__( 'Header Meta wrapper Background Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'active_callback' => 'inspiry_header_variation_option_two'
					)
				)
			);


		}

		/* Header Background Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_header_bg = '#252A2B';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_header_bg = '#303030';
		}
		$wp_customize->add_setting( 'theme_header_bg_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,              // WP_Customize_Manager.
				'theme_header_bg_color',    // Setting id.
				array(
					'label' => esc_html__( 'Header/Banner Background Color', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Applies when no banner image appears. Default Color is %s', 'framework' ), $default_header_bg ),
				)
			)
		);

		/* Logo Text Color */
		$wp_customize->add_setting( 'theme_logo_text_color', array(
			'type' => 'option',
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_logo_text_color',
				array(
					'label' => esc_html__( 'Logo Text Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		/* Logo Text Hover Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_logo_hover = '#4dc7ec';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_logo_hover = '#1ea69a';
		}
		$wp_customize->add_setting( 'theme_logo_text_hover_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_logo_text_hover_color',
				array(
					'label' => esc_html__( 'Logo Text Hover Color', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description' => sprintf(esc_html__('Default Color is %s','framework') , $default_logo_hover),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Tagline Text Color */
			$wp_customize->add_setting( 'theme_tagline_text_color', array(
				'type' => 'option',
				'default' => '#8b9293',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_tagline_text_color',
					array(
						'label' => esc_html__( 'Tagline Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Tagline Background Color */
			$wp_customize->add_setting( 'theme_tagline_bg_color', array(
				'type' => 'option',
				'default' => '#343a3b',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_tagline_bg_color',
					array(
						'label' => esc_html__( 'Tagline Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Text Color */
			$wp_customize->add_setting( 'theme_header_text_color', array(
				'type' => 'option',
				'default' => '#929A9B',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_text_color',
					array(
						'label' => esc_html__( 'Header Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Links Hover Color */
			$wp_customize->add_setting( 'theme_header_link_hover_color', array(
				'type' => 'option',
				'default' => '#b0b8b9',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_link_hover_color',
					array(
						'label' => esc_html__( 'Header Links Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Borders Color */
			$wp_customize->add_setting( 'theme_header_border_color', array(
				'type' => 'option',
				'default' => '#343A3B',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_border_color',
					array(
						'label' => esc_html__( 'Header Borders Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Main Menu Text Color */

		}

		$wp_customize->add_setting( 'theme_main_menu_text_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_main_menu_text_color',
				array(
					'label' => esc_html__( 'Main Menu Text Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		$wp_customize->add_setting( 'theme_main_menu_text_hover_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_main_menu_text_hover_color',
				array(
					'label' => esc_html__( 'Main Menu Text Hover Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Main Menu Text Color */


			/* Main Menu Text Hover Color */
			$wp_customize->add_setting( 'inspiry_main_menu_hover_bg', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_main_menu_hover_bg',
					array(
						'label' => esc_html__( 'Main Menu Hover Background/border', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #ea723d','framework'),
					)
				)
			);
		}

		/* Drop Down Menu Background Color */
		$default_dd_menu_bg = '';
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_bg = '#ec894d';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_bg = '#ffffff';
		}
		$wp_customize->add_setting( 'theme_menu_bg_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_bg_color',
				array(
					'label' => esc_html__( 'Drop Down Menu Background Color', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description' => sprintf(esc_html__('Default Color is %s','framework') , $default_dd_menu_bg),
				)
			)
		);

		/* Drop Down Menu Text Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_text_color = '#ffffff';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_text_color = '#808080';
		}
		$wp_customize->add_setting( 'theme_menu_text_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_text_color',
				array(
					'label' => esc_html__( 'Drop Down Menu Text Color', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description'=> sprintf(esc_html__('Default color is %s','framework') , $default_dd_menu_text_color),
				)
			)
		);

		/* Drop Down Menu Background Color on Mouse Over */

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_bg_color = '#dc7d44';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_bg_color = '#ffffff';
		}

		$wp_customize->add_setting( 'theme_menu_hover_bg_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_hover_bg_color',
				array(
					'label' => esc_html__( 'Drop Down Menu Background Color on Mouse Over', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description'=> sprintf(esc_html__('Default color is %s','framework') , $default_menu_bg_color),
				)
			)
		);

		/* Drop Down Menu Text Color on Mouse Over */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_text_color = '#ffffff';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_text_color = '#000000';
		}
		$wp_customize->add_setting( 'theme_menu_hover_text_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_hover_text_color',
				array(
					'label' => esc_html__( 'Drop Down Menu Text Color on Mouse Over', 'framework' ),
					'section' => 'inspiry_header_styles',
					'description'=> sprintf(esc_html__('Default color is %s','framework') , $default_menu_text_color),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {


			/* Header Phone Number Background Color */
			$wp_customize->add_setting( 'theme_phone_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_bg_color',
					array(
						'label' => esc_html__( 'Header Phone Number Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #4dc7ec','framework'),
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_phone_text_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color',
					array(
						'label' => esc_html__( 'Phone Number Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #e7eff7','framework'),
					)
				)
			);
		}


		if( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'theme_phone_text_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color',
					array(
						'label' => esc_html__( 'Phone/Email Number Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #ffffff','framework'),
					)
				)
			);

			$wp_customize->add_setting( 'theme_phone_text_color_hover', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color_hover',
					array(
						'label' => esc_html__( 'Phone/Email Number Text Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #ffffff','framework'),
					)
				)
			);

	}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'theme_header_social_icon_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_social_icon_color',
					array(
						'label'       => esc_html__( 'Social Icon Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'active_callback' => 'inspiry_header_variation_option_two'
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_social_icon_color_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_social_icon_color_hover',
					array(
						'label'       => esc_html__( 'Social Icon Hover Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'active_callback' => 'inspiry_header_variation_option_two'
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_phone_icon_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_icon_bg_color',
					array(
						'label' => esc_html__( 'Header Phone Icon Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
						'description' => esc_html__('Default color is #37b3d9','framework'),
					)
				)
			);
		}

		if ( 'modern' == INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_home_sticky_header_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_home_sticky_header_labels',
					array(
						'label' => esc_html__('Sticky Header ','framework'),
						'section' 	=> 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_site_title_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_site_title_color',
					array(
						'label'       => esc_html__( 'Site Title Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#444444' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_site_title_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_site_title_hover_color',
					array(
						'label'       => esc_html__( 'Site Title Hover Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#444444' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_bg_color',
					array(
						'label'       => esc_html__( 'Sticky Header Background', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#303030' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_menu_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_menu_color',
					array(
						'label'       => esc_html__( 'Sticky Header Menu Text Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_menu_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_menu_hover_color',
					array(
						'label'       => esc_html__( 'Sticky Header Menu Background Hover Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_menu_text_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_menu_text_hover_color',
					array(
						'label'       => esc_html__( 'Sticky Header Menu Hover Text Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#444444' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_contact_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_contact_color',
					array(
						'label'       => esc_html__( 'Sticky Header Contacts Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_btn_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_btn_color',
					array(
						'label'       => esc_html__( 'Sticky Header Submit Button Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_btn_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_btn_hover_color',
					array(
						'label'       => esc_html__( 'Sticky Header Submit Button Hover Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_modern_sticky_header_btn_hover_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_modern_sticky_header_btn_hover_text_color',
					array(
						'label'       => esc_html__( 'Sticky Header Submit Button Hover Text Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#444444' ),
					)
				)
			);

		}

	}

	add_action( 'customize_register', 'inspiry_header_styles_customizer' );
endif;


if ( ! function_exists( 'inspiry_header_styles_defaults' ) ) :

	/**
	 * inspiry_header_styles_defaults.
	 *
	 * @since  2.6.3
	 */

	function inspiry_header_styles_defaults( WP_Customize_Manager $wp_customize ) {
		$header_styles_settings_ids = array(
			'theme_header_bg_color',
			'theme_logo_text_color',
			'theme_logo_text_hover_color',
			'theme_tagline_text_color',
			'theme_tagline_bg_color',
			'theme_header_text_color',
			'theme_header_link_hover_color',
			'theme_header_border_color',
			'theme_main_menu_text_color',
			'inspiry_main_menu_hover_bg',
			'theme_menu_bg_color',
			'theme_menu_text_color',
			'theme_menu_hover_bg_color',
			'theme_phone_bg_color',
			'theme_phone_text_color',
			'theme_phone_icon_bg_color',
			'theme_language_switcher_bg_color',
			'theme_language_switcher_link_color',
			'theme_language_switcher_link_hover_color'
		);
		inspiry_initialize_defaults( $wp_customize, $header_styles_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_header_styles_defaults' );
endif;

if ( ! function_exists( 'inspiry_header_variation_option_one' ) ) {
	/**
	 * Checks if header variation two is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_one() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'one' == $theme_homepage_module ) {
			return true;
		}
		return false;
	}
}

if ( ! function_exists( 'inspiry_header_variation_option_two' ) ) {
	/**
	 * Checks if header variation two is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_two() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'two' == $theme_homepage_module ) {
			return true;
		}
		return false;
	}
}

if ( ! function_exists( 'inspiry_header_variation_option_three' ) ) {
	/**
	 * Checks if header variation two is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_three() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'three' == $theme_homepage_module ) {
			return true;
		}
		return false;
	}
}