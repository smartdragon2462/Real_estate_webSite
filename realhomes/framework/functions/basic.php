<?php
/**
 * This file contain theme's basic functions
 *
 * @package RH
 */

if ( ! function_exists( 'inspiry_logo_img' ) ) {
	/**
	 * Display logo image
	 * @since 3.7.1
	 *
	 * @param string $logo_url Logo img url.
	 * @param string $retina_logo_url Retina logo image url.
	 *
	 * @return void
	 */
	function inspiry_logo_img( $logo_url, $retina_logo_url ) {

		global $is_IE;

		if ( ! empty( $logo_url ) && ! empty( $retina_logo_url ) && ! $is_IE ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" srcset="' . esc_url( $logo_url ) . ', ' . esc_url( $retina_logo_url ) . ' 2x">';
		} else if ( ! empty( $retina_logo_url ) ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $retina_logo_url ) . '">';
		} else {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '">';
		}
	}
}

if ( ! function_exists( 'inspiry_post_nav' ) ) {

	/**
	 * Return link to previous and next entry.
	 *
	 * @param bool $same_category - True if from same category.
	 */
	function inspiry_post_nav( $same_category = false ) {

		if ( ( 'true' === get_option( 'inspiry_property_prev_next_link' ) && is_singular( 'property' ) )
		     || ( 'true' === get_option( 'inspiry_post_prev_next_link' ) && is_singular( 'post' ) )
		) {

			$entries['prev'] = get_previous_post( $same_category );
			$entries['next'] = get_next_post( $same_category );

			$output = '';

			foreach ( $entries as $key => $entry ) {
				if ( empty( $entry ) ) {
					continue;
				}

				$the_title = get_the_title( $entry->ID );
				$link      = get_permalink( $entry->ID );
				$image     = has_post_thumbnail( $entry );

				$entry_title = $entry_img = '';
				$class       = ( $image ) ? 'with-image' : 'without-image';
				$icon        = ( 'prev' == $key ) ? 'angle-left' : 'angle-right';

				?>
				<a class='inspiry-post-nav inspiry-post-<?php echo esc_attr( $key ) . ' ' . esc_attr( $class ); ?>' href='<?php echo esc_url( $link ); ?>'>
					<span class='label'><i class="fa fa-<?php echo esc_attr( $icon ); ?>"></i></span>
					<span class='entry-info-wrap'>
					<span class='entry-info'>
						<?php if ( 'prev' == $key ) : ?>
							<span class='entry-title'><?php echo esc_html( $the_title ); ?></span>
							<?php if ( $image ) : ?>
								<span class='entry-image'>
									<?php echo get_the_post_thumbnail( $entry, 'thumbnail' ); ?>
								</span>
							<?php else : ?>
								<span class="entry-image">
									<img src="<?php echo esc_url( get_inspiry_image_placeholder_url( 'thumbnail' ) ); ?>">
								</span>
							<?php endif; ?><?php else : ?><?php if ( $image ) : ?>
							<span class='entry-image'>
									<?php echo get_the_post_thumbnail( $entry, 'thumbnail' ); ?>
								</span>
						<?php else : ?>
							<span class="entry-image">
									<img src="<?php echo esc_url( get_inspiry_image_placeholder_url( 'thumbnail' ) ); ?>">
								</span>
						<?php endif; ?>
							<span class='entry-title'><?php echo esc_html( $the_title ); ?></span>
						<?php endif; ?>
					</span>
				</span>
				</a>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'list_gallery_images' ) ) {
	/**
	 * Get list of Gallery Images - use in gallery post format
	 *
	 * @param string $size
	 */
	function list_gallery_images( $size = 'post-featured-image' ) {
		global $post;

		if ( !function_exists( 'rwmb_meta' ) ) {
			return;
		}
		$gallery_images = rwmb_meta( 'REAL_HOMES_gallery', 'type=plupload_image&size=' . $size, $post->ID );

		if ( ! empty( $gallery_images ) ) {
			foreach ( $gallery_images as $gallery_image ) {
				$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
				echo '<li><a href="' . $gallery_image['full_url'] . '" title="' . $caption . '" class="' . get_lightbox_plugin_class() . '"  ' . generate_gallery_attribute('blog-gallery-post') . '>';
				echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
				echo '</a></li>';
			}
		} else if ( has_post_thumbnail( $post->ID ) ) {
			echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
			the_post_thumbnail( $size );
			echo '</a></li>';
		}
	}
}

if ( ! function_exists( 'framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo get_framework_excerpt( $len, $trim );
	}
}

if ( ! function_exists( 'get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return array|string
	 */
	function get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'comment_custom_excerpt' ) ) {
	/**
	 * Output comment's excerpt of required length from given contents
	 *
	 * @param int $len number of words
	 * @param string $comment_content comment contents
	 * @param string $trim text after excerpt
	 */
	function comment_custom_excerpt( $len = 15, $comment_content = "", $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $comment_content, $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";
		echo wp_kses( $excerpt, wp_kses_allowed_html( 'post' ) );
	}
}

if ( ! function_exists( 'get_framework_custom_excerpt' ) ) {
	/**
	 * Return excerpt of required length from given contents
	 *
	 * @param string $contents contents to extract excerpt
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 *
	 * @return array|string
	 */
	function get_framework_custom_excerpt( $contents = "", $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $contents, $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'admin_js' ) ) {
	/**
	 * Register and load admin javascript
	 *
	 * @param string $hook - Page name.
	 */
	function admin_js( $hook ) {
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_register_script( 'admin-script', INSPIRY_COMMON_URI . 'js/admin.js', array( 'jquery' ), INSPIRY_THEME_VERSION );
			wp_enqueue_script( 'admin-script' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'admin_js', 10, 1 );
}

/**
 * Disable Post Format UI in WordPress 3.6 and Keep the Old One Working
 */
add_filter( 'enable_post_format_ui', '__return_false' );

if ( ! function_exists( 'remove_category_list_rel' ) ) {
	/**
	 * Remove rel attribute from the category list
	 *
	 * @param $output
	 *
	 * @return mixed
	 */
	function remove_category_list_rel( $output ) {
		$output = str_replace( ' rel="tag"', '', $output );
		$output = str_replace( ' rel="category"', '', $output );
		$output = str_replace( ' rel="category tag"', '', $output );

		return $output;
	}

	add_filter( 'wp_list_categories', 'remove_category_list_rel' );
	add_filter( 'the_category', 'remove_category_list_rel' );
}

if ( ! function_exists( 'get_lightbox_plugin_class' ) ) {
	/**
	 * Get Lightbox Plugin Class
	 *
	 * @return string
	 */
	function get_lightbox_plugin_class() {
		$lightbox_plugin = get_option( 'theme_lightbox_plugin', 'venobox' );
		return $lightbox_plugin;
	}
}

if ( ! function_exists( 'generate_gallery_attribute' ) ) {
	/**
	 * Generate Gallery Attribute
	 *
	 * @param string $gallery_name
	 *
	 * @return string
	 */
	function generate_gallery_attribute( $gallery_name = 'real_homes' ) {
		$lightbox_plugin = get_lightbox_plugin_class();

		if ( 'pretty-photo' === $lightbox_plugin ) {
			return 'data-rel="prettyPhoto[' . $gallery_name . ']"';
		} elseif ( 'swipebox' === $lightbox_plugin ) {
			return 'rel="gallery_' . $gallery_name . '"';
		} else {
			return 'data-gall="gallery_' . $gallery_name . '"';
		}
	}
}


if ( ! function_exists( 'addhttp' ) ) {
	/**
	 * Add http:// in url if not exists
	 *
	 * @param $url
	 *
	 * @return string
	 */
	function addhttp( $url ) {
		if ( ! preg_match( "~^(?:f|ht)tps?://~i", $url ) ) {
			$url = "http://" . $url;
		}

		return $url;
	}
}

if ( ! function_exists( 'custom_login_logo_url' ) ) {
	/**
	 * WordPress login page logo URL
	 *
	 * @return string|void
	 */
	function custom_login_logo_url() {
		return home_url();
	}

	add_filter( 'login_headerurl', 'custom_login_logo_url' );
}

if ( !function_exists( 'custom_login_logo_title' ) ) {
	/**
	 * WordPress login page logo url title
	 *
	 * @return string|void
	 */
	function custom_login_logo_title() {
		return get_bloginfo( 'name' );
	}

	add_filter( 'login_headertext', 'custom_login_logo_title' );
}

if ( ! function_exists( 'custom_login_style' ) ) {
	/**
	 * WordPress login page custom styles
	 */
	function custom_login_style() {
		wp_enqueue_style( 'login-style', INSPIRY_COMMON_URI . 'css/login-style.css', false );
	}

	add_action( 'login_enqueue_scripts', 'custom_login_style' );
}

if ( ! function_exists( 'alert' ) ) {
	/**
	 * Alert function to display messages on member pages
	 *
	 * @param string $heading
	 * @param string $message
	 */
	function alert( $heading = '', $message = '' ) {
		echo '<div class="inspiry-message">';
		echo '<strong>' . $heading . '</strong> <span>' . $message . '</span>';
		echo '</div>';
	}
}

if ( ! function_exists( 'display_notice' ) ) {
	/**
	 * display_notice function to display messages on member pages
	 *
	 * @param array $notices
	 */
	function display_notice( $notices = array() ) {

		if ( ! is_array( $notices ) || empty( $notices ) ) {
			return false;
		}

		echo '<div class="inspiry-message">';
		foreach ( $notices as $notice ) {
			echo '<strong>' . esc_html( $notice['heading'] ) . '</strong> ';
			echo '<span>';
			echo ( ! empty( $notice['message'] ) ) ? esc_html( $notice['message'] ) : esc_html__( 'No more properties are available.', 'framework' );
			echo '</span><br>';
		}
		echo '</div>';

	}
}

if ( ! function_exists( 'modify_user_contact_methods' ) ) {
	/**
	 * Add Additional Contact Info to User Profile Page
	 *
	 * @param $user_contactmethods
	 *
	 * @return mixed
	 */
	function modify_user_contact_methods( $user_contactmethods ) {
		$user_contactmethods['mobile_number']   = esc_html__( 'Mobile Number', 'framework' );
		$user_contactmethods['office_number']   = esc_html__( 'Office Number', 'framework' );
		$user_contactmethods['fax_number']      = esc_html__( 'Fax Number', 'framework' );
		$user_contactmethods['whatsapp_number'] = esc_html__( 'WhatsApp Number', 'framework' );
		$user_contactmethods['facebook_url']    = esc_html__( 'Facebook URL', 'framework' );
		$user_contactmethods['twitter_url']     = esc_html__( 'Twitter URL', 'framework' );
		$user_contactmethods['linkedin_url']    = esc_html__( 'LinkedIn URL', 'framework' );
		$user_contactmethods['instagram_url']   = esc_html__( 'Instagram URL', 'framework' );

		return $user_contactmethods;
	}

	add_filter( 'user_contactmethods', 'modify_user_contact_methods' );
}

if ( ! function_exists( 'get_icon_for_extension' ) ) {
	/**
	 * Fontawsome icon based on file extension
	 *
	 * @param $ext
	 *
	 * @return string
	 */
	function get_icon_for_extension( $ext ) {
		switch ( $ext ) {
			/* PDF */
			case 'pdf':
				return '<i class="fa fa-file-pdf-o"></i>';

			/* Images */
			case 'jpg':
			case 'png':
			case 'gif':
			case 'bmp':
			case 'jpeg':
			case 'tiff':
			case 'tif':
				return '<i class="fa fa-file-image-o"></i>';

			/* Text */
			case 'txt':
			case 'log':
			case 'tex':
				return '<i class="fa fa-file-text-o"></i>';

			/* Documents */
			case 'doc':
			case 'odt':
			case 'msg':
			case 'docx':
			case 'rtf':
			case 'wps':
			case 'wpd':
			case 'pages':
				return '<i class="fa fa-file-word-o"></i>';

			/* Spread Sheets */
			case 'csv':
			case 'xlsx':
			case 'xls':
			case 'xml':
			case 'xlr':
				return '<i class="fa fa-file-excel-o"></i>';

			/* Zip */
			case 'zip':
			case 'rar':
			case '7z':
			case 'zipx':
			case 'tar.gz':
			case 'gz':
			case 'pkg':
				return '<i class="fa fa-file-zip-o"></i>';

			/* Audio */
			case 'mp3':
			case 'wav':
			case 'm4a':
			case 'aif':
			case 'wma':
			case 'ra':
			case 'mpa':
			case 'iff':
			case 'm3u':
				return '<i class="fa fa-file-audio-o"></i>';

			/* Video */
			case 'avi':
			case 'flv':
			case 'm4v':
			case 'mov':
			case 'mp4':
			case 'mpg':
			case 'rm':
			case 'swf':
			case 'wmv':
				return '<i class="fa fa-file-video-o"></i>';

			/* Others */
			default:
				return '<i class="fa fa-file-o"></i>';
		}
	}
}

if ( ! function_exists( 'get_inspiry_image_placeholder' ) ) {
	/**
	 * Returns image place holder for given size
	 *
	 * @param string $image_size - Image size.
	 *
	 * @return string
	 */
	function get_inspiry_image_placeholder( $image_size ) {

		global $_wp_additional_image_sizes;

		$holder_width  = 0;
		$holder_height = 0;
		$holder_text   = get_bloginfo( 'name' );

		$protocol = 'http';
		$protocol = ( is_ssl() ) ? 'https' : $protocol;

		if ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$holder_width  = get_option( $image_size . '_size_w' );
			$holder_height = get_option( $image_size . '_size_h' );

		} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {

			$holder_width  = $_wp_additional_image_sizes[ $image_size ]['width'];
			$holder_height = $_wp_additional_image_sizes[ $image_size ]['height'];

		}

		if ( intval( $holder_width ) > 0 && intval( $holder_height ) > 0 ) {
			return '<img src="' . $protocol . '://placehold.it/' . $holder_width . 'x' . $holder_height . '&text=' . urlencode( $holder_text ) . '" />';
		}

		return '';
	}
}

if ( ! function_exists( 'get_inspiry_image_placeholder_url' ) ) {

	/**
	 * Returns the URL of placeholder image.
	 *
	 * @param string $image_size - Image size.
	 *
	 * @return string|boolean - URL of the placeholder OR `false` on failure.
	 * @since 3.1.0
	 */
	function get_inspiry_image_placeholder_url( $image_size ) {

		global $_wp_additional_image_sizes;

		$holder_width  = 0;
		$holder_height = 0;
		$holder_text   = get_bloginfo( 'name' );

		$protocol = 'http';
		$protocol = ( is_ssl() ) ? 'https' : $protocol;

		if ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$holder_width  = get_option( $image_size . '_size_w' );
			$holder_height = get_option( $image_size . '_size_h' );

		} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {

			$holder_width  = $_wp_additional_image_sizes[ $image_size ]['width'];
			$holder_height = $_wp_additional_image_sizes[ $image_size ]['height'];

		}

		if ( intval( $holder_width ) > 0 && intval( $holder_height ) > 0 ) {
			return $protocol . '://placehold.it/' . $holder_width . 'x' . $holder_height . '&text=' . urlencode( $holder_text );
		}

		return false;

	}
}

if ( ! function_exists( 'inspiry_image_placeholder' ) ) {
	/**
	 * Output image place holder for given size
	 *
	 * @param string $image_size - Image size.
	 */
	function inspiry_image_placeholder( $image_size ) {
		echo get_inspiry_image_placeholder( $image_size );
	}
}

if ( ! function_exists( 'inspiry_log' ) ) {
	/**
	 * Function to help in debugging
	 *
	 * @param $message
	 */
	function inspiry_log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_get_maps_type' ) ) :
	/**
	 * Returns the type currently available for use.
	 */
	function inspiry_get_maps_type() {
		$google_maps_api_key = get_option( 'inspiry_google_maps_api_key', false );

		if ( ! empty( $google_maps_api_key ) ) {
			return 'google-maps';    // For Google Maps
		}

		return 'open-street-map';    // For OpenStreetMap https://www.openstreetmap.org/
	}
endif;

if ( ! function_exists( 'inspiry_is_map_needed' ) ) {
	/**
	 * Check if google map script is needed or not
	 *
	 * @return bool
	 */
	function inspiry_is_map_needed() {
		if ( is_page_template( 'templates/contact.php' ) && ( get_option( 'theme_show_contact_map' ) == 'true' ) ) {
			return true;
		} elseif ( is_page_template( 'templates/submit-property.php' ) ) {
			return true;
		} elseif ( is_singular( 'property' ) && ( get_option( 'theme_display_google_map' ) == 'true' ) ) {
			return true;
		} elseif ( is_page_template( 'templates/home.php' ) ) {
			$theme_homepage_module = get_option( 'theme_homepage_module' );
			if ( isset( $_GET['module'] ) ) {
				$theme_homepage_module = $_GET['module'];
			}
			if ( $theme_homepage_module == 'properties-map' ) {
				return true;
			}
		} elseif ( is_page_template( 'templates/properties-search.php' ) ) {
			$theme_search_module = get_option( 'theme_search_module', 'properties-map' );
			if ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'properties-map' == $theme_search_module ) ) {
				return true;
			} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'simple-banner' == $theme_search_module ) ) {
				return false;
			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				return true;
			}
		} elseif ( is_page_template( array('templates/properties-search.php', 'templates/half-map-layout.php', 'templates/properties-search-left-sidebar.php', 'templates/properties-search-right-sidebar.php') ) ) {
			return true;
		} elseif ( is_page_template( array( 'templates/list-layout.php', 'templates/grid-layout.php', 'templates/list-layout-full-width.php', 'templates/grid-layout-full-width.php' ) ) || is_tax( 'property-city' ) || is_tax( 'property-status' ) || is_tax( 'property-type' ) || is_tax( 'property-feature' ) || is_post_type_archive( 'property' ) ) {
			// Theme Listing Page Module
			$theme_listing_module = get_option( 'theme_listing_module' );
			// Only for demo purpose only
			if ( isset( $_GET['module'] ) ) {
				$theme_listing_module = $_GET['module'];
			}
			if ( $theme_listing_module == 'properties-map' ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_fix_select2_wc' ) ) {

	/**
	 * inspiry_fix_select2_wc.
	 *
	 * This function removes select2 JS and CSS of WooCommerce
	 * so that theme can use its own.
	 *
	 * @since 2.6.2
	 */
	function inspiry_fix_select2_wc() {

		if ( class_exists( 'woocommerce' ) ) {

			/**
			 * Settings for CSS optimisation
			 */
			$inspiry_optimise_css = get_option( 'inspiry_optimise_css' );

			wp_dequeue_style( 'select2' );
			wp_deregister_style( 'select2' );

			wp_dequeue_style( 'main-css' );
			wp_deregister_style( 'main-css' );

			wp_dequeue_script( 'select2' );

			wp_dequeue_script( 'custom' );

			// select2 CSS.
			wp_enqueue_style(
				'select2',
				INSPIRY_DIR_URI . '/scripts/vendors/select2/select2.css',
				array(),
				'4.0.2'
			);

			// main styles.
			if ( 'true' == $inspiry_optimise_css ) {
				wp_enqueue_style(
					'main-css',
					INSPIRY_DIR_URI . '/styles/css/main.min.css',
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			} else {
				wp_enqueue_style(
					'main-css',
					INSPIRY_DIR_URI . '/styles/css/main.css',
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			}

			// select2 JS.
			wp_enqueue_script(
				'select2',
				INSPIRY_DIR_URI . '/scripts/vendors/select2/select2.full.min.js',
				array( 'jquery' ),
				'4.0.2',
				true
			);

			// Theme's main script.
			wp_register_script(
				'custom-js',
				INSPIRY_DIR_URI . '/scripts/js/custom.js',
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);

			/* Responsive menu title */
			$localized_array_fix = array(
				'nav_title' => esc_html__( 'Go to...', 'framework' ),
			);
			wp_localize_script( 'custom-js', 'localized', $localized_array_fix );

			/* Finally enqueue theme's main script */
			wp_enqueue_script( 'custom-js' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_fix_select2_wc', 100 );
}

if ( ! function_exists( 'inspiry_hex_to_rgba' ) ) {

	/**
	 * Convert hexdec color string to rgb(a) string
	 *
	 * @param string $color - Color string in rgb.
	 * @param float $opacity - Opacity of the color.
	 *
	 * @since 2.6.2
	 */
	function inspiry_hex_to_rgba( $color, $opacity = false ) {

		$default = '';

		// Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		// Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		// Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );

		// Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
		}

		// Return rgb(a) color string
		return $output;
	}
}

if ( ! function_exists( 'inspiry_hex_darken' ) ) {

	/**
	 * Function: Returns the hex color darken to percentage.
	 *
	 * @param string $hex - hex color.
	 * @param int $percent - percentage in number without % symbol.
	 *
	 * @return string
	 *
	 * @since 3.5.0
	 */

	function inspiry_hex_darken( $hex, $percent = 0 ) {
		$color = '';
		if ( ! empty( $hex ) ) {
			preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors );
			str_replace( '%', '', $percent );
			$color = "#";
			for ( $i = 1; $i <= 3; $i ++ ) {
				$primary_colors[ $i ] = hexdec( $primary_colors[ $i ] );
				$primary_colors[ $i ] = round( $primary_colors[ $i ] * ( 100 - ( $percent * 2 ) ) / 100 );
				$color .= str_pad( dechex( $primary_colors[ $i ] ), 2, '0', STR_PAD_LEFT );
			}
		}

		return $color;
	}
}

if ( ! function_exists( 'inspiry_author_properties_count' ) ) {
	/**
	 * Function: Returns the number listed properties of an author.
	 *
	 * @param int $author_id - Author ID for properties.
	 *
	 * @return integer
	 *
	 * @since 3.3.2
	 */
	function inspiry_author_properties_count( $author_id ) {

		if ( empty( $author_id ) ) {
			return 0;
		}

		$properties_args = array(
			'post_type'      => 'property',
			'posts_per_page' => - 1,
			'author'         => $author_id,
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_agent_display_option',
					'value'   => 'my_profile_info',
					'compare' => '=',
				),
			),
		);

		$properties = new WP_Query( $properties_args );
		if ( $properties->have_posts() ) {
			return $properties->found_posts;
		}

		return 0;
	}
}

if ( ! function_exists( 'inspiry_filter_excerpt_more' ) ) {

	/**
	 * Filter the more text of excerpt.
	 *
	 * @param  string $more - More string of the excerpt.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	function new_excerpt_more( $more ) {
		return '...';
	}

	add_filter( 'excerpt_more', 'new_excerpt_more' );
}

if ( ! function_exists( 'inspiry_backend_safe_string' ) ) {
	/**
	 * Create a lower case version of a string without spaces so we can use that string for database settings
	 *
	 * @param string $string to convert
	 *
	 * @return string the converted string
	 */
	function inspiry_backend_safe_string( $string, $replace = "_", $check_spaces = false ) {
		$string = strtolower( $string );

		$trans = array(
			'&\#\d+?;'       => '',
			'&\S+?;'         => '',
			'\s+'            => $replace,
			'ä'              => 'ae',
			'ö'              => 'oe',
			'ü'              => 'ue',
			'Ä'              => 'Ae',
			'Ö'              => 'Oe',
			'Ü'              => 'Ue',
			'ß'              => 'ss',
			'[^a-z0-9\-\._]' => '',
			$replace . '+'   => $replace,
			$replace . '$'   => $replace,
			'^' . $replace   => $replace,
			'\.+$'           => ''
		);

		$trans = apply_filters( 'inspiry_safe_string_trans', $trans, $string, $replace );

		$string = strip_tags( $string );

		foreach ( $trans as $key => $val ) {
			$string = preg_replace( "#" . $key . "#i", $val, $string );
		}

		if ( $check_spaces ) {
			if ( str_replace( '_', '', $string ) == '' ) {
				return;
			}
		}

		return stripslashes( $string );
	}
}

if ( ! function_exists( 'inspiry_hex2rgb' ) ) {
	/***
	 * Converts Hexadecimal color code to RGB
	 *
	 * @param $colour
	 * @param int $opacity
	 *
	 * @return bool|string
	 */
	function inspiry_hex2rgb( $colour, $opacity = 1 ) {
		if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return "rgba({$r},{$g},{$b},{$opacity})";
	}
}

if ( ! function_exists( 'inspiry_get_exploded_heading' ) ) {
	/**
	 * Returned exploded title into title and sub-title.
	 * (Modern design specific)
	 *
	 * @param $page_title
	 *
	 * @return string
	 */
	function inspiry_get_exploded_heading( $page_title ) {

		$explode_title = get_option( 'inspiry_explode_listing_title', 'yes' );

		if ( 'yes' == $explode_title ) {
			$page_title = explode( ' ', $page_title, 2 );

			if ( ! empty( $page_title ) && ( 1 < count( $page_title ) ) ) {
				?>
				<span class="sub"><?php echo esc_html( $page_title[0] ); ?></span>
				<span class="title"><?php echo esc_html( $page_title[1] ); ?></span>
				<?php
			} else {
				?><span class="title"><?php echo esc_html( $page_title[0] ); ?></span><?php
			}

		} else {
			?><span class="title"><?php echo esc_html( $page_title ); ?></span><?php
		}
	}
}

if ( ! function_exists( 'inspiry_is_gdpr_enabled' ) ) {
	/**
	 * Check if GDPR is enabled on forms
	 * @return bool
	 */
	function inspiry_is_gdpr_enabled() {

		$inspiry_gdpr = intval( get_option( 'inspiry_gdpr', '0' ) );

		if ( $inspiry_gdpr ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_gdpr_agreement_content' ) ) {
	/**
	 * Return GDPR field label text
	 *
	 * @param string $type
	 *
	 * @return mixed|void
	 */
	function inspiry_gdpr_agreement_content( $type = 'text' ) {

		if ( 'label' == $type ) {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_label', esc_html__( 'GDPR Agreement', 'framework' ) );
		} else if( 'validation-message' == $type ) {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_validation_text',  esc_html__( '* Please accept GDPR agreement', 'framework' ) );
		} else {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_text', esc_html__( 'I consent to having this website store my submitted information so they can respond to my inquiry.', 'framework' ) );
		}

		return $gdpr_agreement_content;
	}
}

if ( ! function_exists( 'inspiry_is_rvr_enabled' ) ) {
	/**
	 * Check if Realhomes Vacation Rentals plugin is activated and enabled
	 *
	 * @return bool
	 */
	function inspiry_is_rvr_enabled() {
		$rvr_settings = get_option( 'rvr_settings' );
		$rvr_enabled  = $rvr_settings['rvr_activation'];

		if ( $rvr_enabled && class_exists( 'Realhomes_Vacation_Rentals' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_language_switcher' ) ) {
	/**
	 * Display language list of selected WPML languages.
	 *
	 * @since 3.6.1
	 */
	function inspiry_language_switcher() {
		echo inspiry_get_language_switcher();
	}
}

if ( ! function_exists( 'inspiry_get_language_switcher' ) ) {
	/**
	 * Retrieve language list of selected WPML languages.
	 *
	 * @since 3.6.1
	 */
	function inspiry_get_language_switcher() {

		if ( function_exists( 'wpml_get_active_languages_filter' ) ) {

			$inspiry_language_switcher = get_option( 'theme_wpml_lang_switcher', 'true' );

			if ( 'true' === $inspiry_language_switcher ) {

				$languages = wpml_get_active_languages_filter( null, null );

				if ( ! empty( $languages ) ) {

					$switcher_language_display = get_option( 'theme_switcher_language_display', 'language_name_and_flag' );
					$active_language           = '';
					$languages_list            = '';

					foreach ( $languages as $language ) {
						$code             = $language['code'];
						$native_name      = $language['native_name'];
						$language_code    = $language['language_code'];
						$country_flag_url = $language['country_flag_url'];

						$language_name_in_current_language = get_option( 'theme_switcher_language_name_in_current_language', 'native_name' );
						if( 'translated_name' === $language_name_in_current_language ){
							$native_name = $language['translated_name'];
                        }

						if ( ! $language['active'] ) {
							$languages_list .= '<li class="inspiry-language ' . esc_attr( $code ) . '">';
							$languages_list .= '<a class="inspiry-language-link" href="' . esc_url( $language['url'] ) . '">';

							if( 'language_flag_only' === $switcher_language_display ){
								$languages_list .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
							}elseif ( 'language_name_only' == $switcher_language_display ){
								$languages_list .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';

							}else{
								$languages_list .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
								$languages_list .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';
                            }
							$languages_list .= '</a>';
							$languages_list .= '</li>';
						} else {
							$active_language .= '<li class="inspiry-language ' . esc_attr( $code ) . ' current" >';
							if( 'language_flag_only' === $switcher_language_display ){
								$active_language .= '<img class="inspiry-no-language-name" src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
                            }elseif ( 'language_name_only' == $switcher_language_display ){
								$active_language .= '<span class="inspiry-language-native inspiry-no-language-flag">' . esc_html( $native_name ) . '</span>';
                            }else{
								$active_language .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
								$active_language .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';
                            }
						}
					}

					$html = '<div class="inspiry-language-switcher"><ul>';
					$html .= $active_language;

					if ( ! empty( $languages_list ) ) {
						$html .= '<ul class="rh_languages_available">' . $languages_list . '</ul>';
					}

					$html .= '</li></ul></div>';

					return $html;
				}
			}
		}
	}
}

if ( ! function_exists( 'inspiry_property_qr_code' ) ) {
	/**
	 * Display QR code image generated with google chart API.
	 */
	function inspiry_property_qr_code() {

		$inspiry_qr_code_url = 'https://chart.googleapis.com/chart?cht=qr&chs=90x90&chl=' . get_the_permalink() . '&choe=UTF-8';

		printf( '<img class="only-for-print inspiry-qr-code" src="%s" alt="%s">', esc_url( $inspiry_qr_code_url ), get_the_title() );
    }
}

if ( ! function_exists( 'inspiry_property_detail_page_link_text' ) ) {
	/**
	 * Display property detail page link text.
	 */
	function inspiry_property_detail_page_link_text() {
		echo get_option( 'inspiry_property_detail_page_link_text', esc_html__( 'View Property', 'framework' ) );
	}
}


if ( !function_exists( 'inspiry_embed_code_allowed_html' ) ) {
	/**
	 * @return array Array of allowed tags for embed code.
	 */
	function inspiry_embed_code_allowed_html() {
		$embed_code_allowed_html = wp_kses_allowed_html( 'post' );

		// iframe
		$embed_code_allowed_html['iframe'] = array(
			'src'             => array(),
			'height'          => array(),
			'width'           => array(),
			'frameborder'     => array(),
			'allowfullscreen' => array(),
			'allowvr'         => array(),
		);

		return apply_filters( 'inspiry_embed_code_allowed_html', $embed_code_allowed_html );
	}
}


if ( !function_exists( 'inspiry_allowed_html' ) ) {
	/**
	 * @return array Array of allowed html tags.
	 */
	function inspiry_allowed_html() {

		$allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'alt'   => array(),
			),
			'b'      => array(),
			'br'     => array(),
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(),
			'strong' => array(),
		);

		return apply_filters( 'inspiry_allowed_html', $allowed_html );
	}
}