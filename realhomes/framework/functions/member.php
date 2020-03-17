<?php
/**
 * This file contains functions related to Login, Register and Forgot Password Features
 */


if ( ! function_exists( 'inspiry_is_user_restricted' ) ) :
	/**
	 * Checks if current user is restricted or not
	 *
	 * @return bool
	 */
	function inspiry_is_user_restricted() {
		$current_user = wp_get_current_user();

		// get restricted level from theme options
		$restricted_level = get_option( 'theme_restricted_level' );
		if ( ! empty( $restricted_level ) ) {
			$restricted_level = intval( $restricted_level );
		} else {
			$restricted_level = 0;
		}

		// Redirects user below a certain user level to home url
		// Ref: https://codex.wordpress.org/Roles_and_Capabilities#User_Level_to_Role_Conversion
		if ( $current_user->user_level <= $restricted_level ) {
			return true;
		}

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_restrict_admin_access' ) ) :
	/**
	 * Restrict user access to admin if his level is equal or below restricted level
	 * Or request is an AJAX request or delete request from my properties page
	 */
	function inspiry_restrict_admin_access() {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			// let it go
		} else if ( isset( $_GET[ 'action' ] ) && ( $_GET[ 'action' ] == 'delete' ) ) {
			// let it go as it is from my properties delete button
		} else {
			if ( inspiry_is_user_restricted() ) {
				wp_redirect( esc_url_raw( home_url( '/' ) ) );
				exit;
			}
		}

	}

	add_action( 'admin_init', 'inspiry_restrict_admin_access' );
endif;


if ( ! function_exists( 'inspiry_ajax_login' ) ) :
	/**
	 * AJAX login request handler
	 */
	function inspiry_ajax_login() {

		// First check the nonce, if it fails the function will break.
		check_ajax_referer( 'inspiry-ajax-login-nonce', 'inspiry-secure-login' );

		if ( class_exists( 'Easy_Real_Estate' ) ) {
			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();
		}

		// Nonce is checked, get the POST data and sign user on.
		inspiry_auth_user_login( $_POST['log'], $_POST['pwd'], esc_html__( 'Login', 'framework' ) );

		die();
	}

	// Enable the user with no privileges to request ajax login.
	add_action( 'wp_ajax_nopriv_inspiry_ajax_login', 'inspiry_ajax_login' );

endif;


if ( ! function_exists( 'inspiry_auth_user_login' ) ) :
	/**
	 * This function process login request and displays JSON response
	 *
	 * @param $user_login
	 * @param $password
	 * @param $login
	 */
	function inspiry_auth_user_login( $user_login, $password, $login ) {

		$info = array();
		$info[ 'user_login' ] = $user_login;
		$info[ 'user_password' ] = $password;
		$info[ 'remember' ] = true;

		$user_signon = wp_signon( $info, true );

		if ( is_wp_error( $user_signon ) ) {
			echo json_encode( array(
				'success' => false,
				'message' => esc_html__( '* Wrong username or password.', 'framework' ),
			) );
		} else {
			wp_set_current_user( $user_signon->ID );
			echo json_encode( array(
				'success' => true,
				'message' => $login . ' ' . esc_html__( 'successful. Redirecting...', 'framework' ),
				'redirect' => $_POST[ 'redirect_to' ]
			) );
		}

		die();
	}
endif;


if ( ! function_exists( 'inspiry_ajax_register' ) ) :
	/**
	 * AJAX register request handler
	 */
	function inspiry_ajax_register() {

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'inspiry-ajax-register-nonce', 'inspiry-secure-register' );

		if ( class_exists( 'Easy_Real_Estate' ) ) {
			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();
		}

		// Nonce is checked, Get to work
		$info = array();
		$info[ 'user_nicename' ] = $info[ 'nickname' ] = $info[ 'display_name' ] = $info[ 'first_name' ] = $info[ 'user_login' ] = sanitize_user( $_POST[ 'register_username' ] );
		$info[ 'user_pass' ] = wp_generate_password( 12 );
		$info[ 'user_email' ] = sanitize_email( $_POST[ 'register_email' ] );

		// Register the user
		$user_register = wp_insert_user( $info );

		if ( is_wp_error( $user_register ) ) {

			$error = $user_register->get_error_codes();
			if ( in_array( 'empty_user_login', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => $user_register->get_error_message( 'empty_user_login' )
				) );
			} elseif ( in_array( 'existing_user_login', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'This username already exists.', 'framework' )
				) );
			} elseif ( in_array( 'existing_user_email', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'This email is already registered.', 'framework' )
				) );
			} else {
				echo json_encode( array(
					'success' => false,
					'message' => $user_register->get_error_message()
				) );
			}

		} else {

			// User notification function exists in plugin
			if ( class_exists('Easy_Real_Estate') ) {
				// Send email notification to newly registered user and admin
				ere_new_user_notification( $user_register, $info[ 'user_pass' ] );
			}

			echo json_encode( array(
				'success' => true,
				'message' => esc_html__( 'Registration is complete. Check your email for details!', 'framework' ),
			) );

		}

		die();
	}

	// Enable the user with no privileges to request ajax register
	add_action( 'wp_ajax_nopriv_inspiry_ajax_register', 'inspiry_ajax_register' );

endif;


if( !function_exists( 'inspiry_get_edit_profile_url' ) ) :
	/**
	 * Get edit profile URL
	 */
    function inspiry_get_edit_profile_url() {

	    /* Check edit profile page */
	    $inspiry_edit_profile_page = get_option('inspiry_edit_profile_page');
	    if ( !empty( $inspiry_edit_profile_page ) ) {

		    /* WPML filter to get translated page id if translation exists otherwise default id */
		    $inspiry_edit_profile_page = apply_filters( 'wpml_object_id', $inspiry_edit_profile_page, 'page', true  );

		    return get_permalink( $inspiry_edit_profile_page );
	    }

	    /* Check edit profile page url which is deprecated and this code is to provide backward compatibility */
	    $theme_profile_url = get_option('theme_profile_url');
	    if ( !empty( $theme_profile_url ) ) {
		    return $theme_profile_url;
	    }

	    /* Return false if all fails */
	    return false;
    }
endif;


if( !function_exists( 'inspiry_get_submit_property_url' ) ) :
	/**
	 * Get submit property page's URL
	 */
	function inspiry_get_submit_property_url() {

		/* Check submit property page */
		$inspiry_submit_property_page = get_option('inspiry_submit_property_page');
		if ( !empty( $inspiry_submit_property_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_submit_property_page = apply_filters( 'wpml_object_id', $inspiry_submit_property_page, 'page', true  );

			return get_permalink( $inspiry_submit_property_page );
		}

		/* Check submit property page url which is deprecated and this code is to provide backward compatibility */
		$theme_submit_url = get_option( 'theme_submit_url' );
		if ( !empty( $theme_submit_url ) ) {
			return $theme_submit_url;
		}

		/* Return false if all fails */
		return false;
	}
endif;


if( !function_exists( 'inspiry_get_my_properties_url' ) ) :
	/**
	 * Get my properties page URL
	 */
	function inspiry_get_my_properties_url() {

		/* Check my properties page */
		$inspiry_my_properties_page = get_option('inspiry_my_properties_page');
		if ( !empty( $inspiry_my_properties_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_my_properties_page = apply_filters( 'wpml_object_id', $inspiry_my_properties_page, 'page', true  );

			return get_permalink( $inspiry_my_properties_page );
		}

		/* Check my properties page url which is deprecated and this code is to provide backward compatibility */
		$theme_my_properties_url = get_option( 'theme_my_properties_url' );
		if ( !empty( $theme_my_properties_url ) ) {
			return $theme_my_properties_url;
		}

		/* Return false if all fails */
		return false;
	}
endif;


if( !function_exists( 'inspiry_get_favorites_url' ) ) :
	/**
	 * Get favorite properties page URL
	 */
	function inspiry_get_favorites_url() {

		/* Check favorite properties page */
		$inspiry_favorites_page = get_option('inspiry_favorites_page');
		if ( !empty( $inspiry_favorites_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_favorites_page = apply_filters( 'wpml_object_id', $inspiry_favorites_page, 'page', true  );

			return get_permalink( $inspiry_favorites_page );
		}

		/* Check favorite properties page url which is deprecated and this code is to provide backward compatibility */
		$theme_favorites_url = get_option( 'theme_favorites_url' );
		if ( !empty( $theme_favorites_url ) ) {
			return $theme_favorites_url;
		}

		/* Return false if all fails */
		return false;
	}
endif;


if ( ! function_exists( 'inspiry_get_compare_url' ) ) :
	/**
	 * Get compare properties page URL
	 */
	function inspiry_get_compare_url() {

		/* Check compare properties page */
		$inspiry_compare_page = get_option( 'inspiry_compare_page' );
		if ( ! empty( $inspiry_compare_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_compare_page = apply_filters( 'wpml_object_id', $inspiry_compare_page, 'page', true );

			return get_permalink( $inspiry_compare_page );
		}

		/* Return false if all fails */
		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_membership_url' ) ) :
	/**
	 * Get memberships page URL
	 */
	function inspiry_get_membership_url() {

		/* Check compare properties page */
		$inspiry_membership_page = get_option( 'inspiry_membership_page' );
		if ( ! empty( $inspiry_membership_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_membership_page = apply_filters( 'wpml_object_id', $inspiry_membership_page, 'page', true );

			return get_permalink( $inspiry_membership_page );
		}

		/* Return false if all fails */
		return false;
	}
endif;


if( !function_exists( 'inspiry_get_login_register_url' ) ) :
	/**
	 * Get login and register page URL
	 */
	function inspiry_get_login_register_url() {

		/* Check login and register page */
		$inspiry_login_register_page = get_option('inspiry_login_register_page');
		if ( !empty( $inspiry_login_register_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_login_register_page = apply_filters( 'wpml_object_id', $inspiry_login_register_page, 'page', true  );

			return get_permalink( $inspiry_login_register_page );
		}

		/* Check login and register page url which is deprecated and this code is to provide backward compatibility */
		$theme_login_url = get_option( 'theme_login_url' );
		if ( !empty( $theme_login_url ) ) {
			return $theme_login_url;
		}

		/* Return false if all fails */
		return false;
	}
endif;


if( !function_exists( 'inspiry_header_login_enabled' ) ) :
	/**
	 * Check if login in header is enabled
	 * @return bool
	 */
    function inspiry_header_login_enabled() {
		$inspiry_header_login = get_option( 'inspiry_header_login' );
	    if ( $inspiry_header_login == 'false' ) {
		    return false;
	    }
	    return true;
    }
endif;


if ( ! function_exists( 'inspiry_social_login_links' ) ) :
	function inspiry_social_login_links( $provider_id, $provider_name, $authenticate_url ) {
		?>
		<a rel="nofollow" href="<?php echo esc_url( $authenticate_url ); ?>" data-provider="<?php echo esc_attr( $provider_id ); ?>" class="wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?>">
			<?php
			if ( strtolower( $provider_id ) == 'google' ) {
				$provider_id = 'google-plus';
			} elseif ( strtolower( $provider_id ) == 'stackoverflow' ) {
				$provider_id = 'stack-overflow';
			} elseif ( strtolower( $provider_id ) == 'vkontakte' ) {
				$provider_id = 'vk';
			} elseif ( strtolower( $provider_id ) == 'twitchtv' ) {
				$provider_id = 'twitch';
			} elseif ( strtolower( $provider_id ) == 'live' ) {
				$provider_id = 'windows';
			}
			?>
			<span><i class="fa fa-<?php echo esc_attr( strtolower( $provider_id ) ); ?>"></i> <?php echo esc_html( $provider_name ); ?></span>
		</a>
		<?php
	}

	add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'inspiry_social_login_links', 10, 3 );
endif;

if ( ! function_exists( 'inspiry_get_gravatar' ) ) {
	/**
	 * Gravatar Image WP Custom Function
	 *
	 * @param  string $email user/author email address.
	 * @param  string $size  size of gravatar.
	 * @return string           gravatar image url
	 */
	function inspiry_get_gravatar( $email, $size ) {
	    // Convert email into md5 hash and set image size to 200 px.
	    $gravatar_url = 'https://www.gravatar.com/avatar/' . md5( $email ) . '?s=' . $size;
	    return $gravatar_url;
	}
}
