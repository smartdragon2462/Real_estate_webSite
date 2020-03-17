<?php
/**
 * This file contains functions related to submit property template
 */

if ( ! function_exists( 'inspiry_image_upload' ) ) {
	/**
	 * Ajax image upload for property submit and update
	 */
	function inspiry_image_upload() {

		// Verify Nonce
		$nonce = $_REQUEST[ 'nonce' ];
		if ( ! wp_verify_nonce( $nonce, 'inspiry_allow_upload' ) ) {
			$ajax_response = array(
				'success' => false,
				'reason' => esc_html__( 'Security check failed!', 'framework' ),
			);
			echo json_encode( $ajax_response );
			die;
		}

		$submitted_file = $_FILES[ 'inspiry_upload_file' ];
		$uploaded_image = wp_handle_upload( $submitted_file, array( 'test_form' => false ) );   //Handle PHP uploads in WordPress, sanitizing file names, checking extensions for mime type, and moving the file to the appropriate directory within the uploads directory.

		if ( isset( $uploaded_image[ 'file' ] ) ) {
			$file_name = basename( $submitted_file[ 'name' ] );
			$file_type = wp_check_filetype( $uploaded_image[ 'file' ] );   // Retrieve the file type from the file name.

			if ( preg_match( '!^image/!', $file_type[ 'type' ] ) && file_is_displayable_image( $uploaded_image[ 'file' ] ) ){

				// Prepare an array of post data for the attachment.
				$attachment_details = array(
					'guid' => $uploaded_image[ 'url' ],
					'post_mime_type' => $file_type[ 'type' ],
					'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment_details, $uploaded_image[ 'file' ] );     // This function inserts an attachment into the media library
				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_image[ 'file' ] ); // This function generates metadata for an image attachment. It also creates a thumbnail and other intermediate sizes of the image attachment based on the sizes defined

				if ( ! empty( $attach_data ) ) {
					wp_update_attachment_metadata( $attach_id, $attach_data ); // Update metadata for an attachment.

					if ( isset( $_REQUEST['size'] ) ) {
						$thumbnail_url = inspiry_get_thumbnail_url( $attach_data, $_REQUEST['size'] );
					} else {
						$thumbnail_url = inspiry_get_thumbnail_url( $attach_data );
					}

					$ajax_response = array( 'success' => true, 'url' => $thumbnail_url, 'attachment_id' => $attach_id );
					echo json_encode( $ajax_response );
					die;
				}
			}else{
				$ajax_response = array( 'success' => false, 'reason' => esc_html__( 'Invalid image format!','framework' ) );
				echo json_encode( $ajax_response );
				die;
			}
		} else {
			$ajax_response = array( 'success' => false, 'reason' => esc_html__( 'Image upload failed!', 'framework' ) );
			echo json_encode( $ajax_response );
			die;
		}
	}

	add_action( 'wp_ajax_ajax_img_upload', 'inspiry_image_upload' );    // only for logged in user
}


if ( ! function_exists( 'inspiry_get_thumbnail_url' ) ) {
	/**
	 * Get thumbnail url based on attachment data
	 *
	 * @param $attach_data
	 * @param $size
	 * @return string
	 */
	function inspiry_get_thumbnail_url( $attach_data, $size = 'thumbnail' ) {
		$upload_dir = wp_upload_dir();

		if( 'full' === $size ){
			return $upload_dir[ 'baseurl' ] . '/' . $attach_data[ 'file' ];
		}

		$image_path_array = explode( '/', $attach_data[ 'file' ] );
		$image_path_array = array_slice( $image_path_array, 0, count( $image_path_array ) - 1 );
		$image_path = implode( '/', $image_path_array );
		$thumbnail_name = $attach_data[ 'sizes' ][ $size ][ 'file' ];
		return $upload_dir[ 'baseurl' ] . '/' . $image_path . '/' . $thumbnail_name;
	}
}


if ( ! function_exists( 'inspiry_remove_gallery_image' ) ) {
	/**
	 * Property Submit Form - Gallery Image Removal
	 */
	function inspiry_remove_gallery_image() {

		// Verify Nonce
		$nonce = $_POST[ 'nonce' ];
		if ( ! wp_verify_nonce( $nonce, 'inspiry_allow_upload' ) ) {
			$ajax_response = array(
				'post_meta_removed' => false,
				'attachment_removed' => false,
				'reason' => esc_html__('Security check failed!', 'framework')
			);
			echo json_encode( $ajax_response );
			die;
		}

		$post_meta_removed = false;
		$attachment_removed = false;

		if ( isset( $_POST[ 'property_id' ] ) && isset( $_POST[ 'attachment_id' ] ) ) {
			$property_id = intval( $_POST[ 'property_id' ] );
			$attachment_id = intval( $_POST[ 'attachment_id' ] );
			if ( $property_id > 0 && $attachment_id > 0 ) {
				$post_meta_removed = delete_post_meta( $property_id, 'REAL_HOMES_property_images', $attachment_id );
				$attachment_removed = wp_delete_attachment( $attachment_id );
			} else if ( $attachment_id > 0 ) {
				if ( false === wp_delete_attachment( $attachment_id ) ) {
					$attachment_removed = false;
				} else {
					$attachment_removed = true;
				}
			}
		}

		$ajax_response = array(
			'post_meta_removed' => $post_meta_removed,
			'attachment_removed' => $attachment_removed,
		);

		echo json_encode( $ajax_response );
		die;

	}

	add_action( 'wp_ajax_remove_gallery_image', 'inspiry_remove_gallery_image' );
}


if ( ! function_exists( 'insert_attachment' ) ) {
	/**
	 * Insert Attachment Method for Property Submit Template
	 *
	 * @param $file_handler
	 * @param $post_id
	 * @param bool|false $setthumb
	 * @return int|WP_Error
	 */
	function insert_attachment( $file_handler, $post_id, $setthumb = false ) {

		// check to make sure its a successful upload
		if ( $_FILES[ $file_handler ][ 'error' ] !== UPLOAD_ERR_OK )
			__return_false();

		require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

		$attach_id = media_handle_upload( $file_handler, $post_id );

		if ( $setthumb ) {
			update_post_meta( $post_id, '_thumbnail_id', $attach_id );
		}

		return $attach_id;
	}
}


if ( ! function_exists( 'edit_form_taxonomy_options' ) ) {
	/**
	 * Property Edit Form Taxonomy Options
	 *
	 * @param $property_id
	 * @param $taxonomy_name
	 */
	function edit_form_taxonomy_options( $property_id, $taxonomy_name ) {

		$existing_term_id = 0;
		$tax_terms = get_the_terms( $property_id, $taxonomy_name );
		if ( ! empty( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				$existing_term_id = $tax_term->term_id;
				break;
			}
		}

		$existing_term_id = intval( $existing_term_id );

		if ( $existing_term_id == 0 || empty( $existing_term_id ) ) {
			echo '<option value="-1" selected="selected">' . esc_html__( 'None', 'framework' ) . '</option>';
		} else {
			echo '<option value="-1">' . esc_html__( 'None', 'framework' ) . '</option>';
		}

		$taxonomy_terms = get_terms( array(
			'taxonomy'   => $taxonomy_name,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false
		) );

		if ( ! empty( $taxonomy_terms ) ) {
			foreach ( $taxonomy_terms as $term ) {
				if ( $existing_term_id == intval( $term->term_id ) ) {
					echo '<option value="' . $term->term_id . '" selected="selected">' . $term->name . '</option>';
				} else {
					echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
				}
			}
		}
	}
}


if ( ! function_exists( 'edit_form_hierarchical_options' ) ) {
	/**
	 * Property Edit Form Hierarchical Taxonomy Options
	 *
	 * @param $property_id
	 * @param $taxonomy_name
	 */
	function edit_form_hierarchical_options( $property_id, $taxonomy_name ) {

		$existing_term_id = 0;
		$tax_terms = get_the_terms( $property_id, $taxonomy_name );
		if ( ! empty( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				$existing_term_id = $tax_term->term_id;
				break;
			}
		}

		$existing_term_id = intval( $existing_term_id );
		if ( $existing_term_id == 0 || empty( $existing_term_id ) ) {
			echo '<option value="-1" selected="selected">' . esc_html__( 'None', 'framework' ) . '</option>';
		} else {
			echo '<option value="-1">' . esc_html__( 'None', 'framework' ) . '</option>';
		}

		$top_level_terms = get_terms( array(
			'taxonomy'   => $taxonomy_name,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
			'parent'     => 0
		) );

		generate_id_based_hirarchical_options( $taxonomy_name, $top_level_terms, $existing_term_id );

	}
}