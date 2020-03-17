<div class="form-option images-field-wrapper">
	<?php
	global $target_property;

	if (inspiry_is_edit_property()) {
		 ?>
        <div id="gallery-thumbs-container" class="clearfix">
			<?php
			$thumbnail_size = 'thumbnail';
			$properties_images = rwmb_meta('REAL_HOMES_property_images', 'type=plupload_image&size='.$thumbnail_size, $target_property->ID);
			$featured_image_id = get_post_thumbnail_id($target_property->ID);
			if (!empty($properties_images)) {
				foreach ($properties_images as $prop_image_id => $prop_image_meta) {
					$is_featured_image =  ($featured_image_id == $prop_image_id);
					$featured_icon = ($is_featured_image) ? 'fa-star' : 'fa-star-o';
					echo '<div class="gallery-thumb">';
					echo '<img src="'.$prop_image_meta['url'].'" alt="'.$prop_image_meta['title'].'" />';
					echo '<a class="remove-image" data-property-id="'.$target_property->ID.'" data-attachment-id="' . $prop_image_id . '" href="#remove-image" ><i class="fa fa-trash-o"></i></a>';
					echo '<a class="mark-featured" data-property-id="'.$target_property->ID.'" data-attachment-id="' . $prop_image_id . '" href="#mark-featured" ><i class="fa '. $featured_icon . '"></i></a>';
					echo '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
					echo '<input type="hidden" class="gallery-image-id" name="gallery_image_ids[]" value="' . $prop_image_id . '"/>';
					if ($is_featured_image) {
						echo '<input type="hidden" class="featured-img-id" name="featured_image_id" value="' . $prop_image_id . '"/>';
					}
					echo '</div>';
				}
			} ?>
        </div>
		<?php

	} else {
		?>
        <div id="gallery-thumbs-container" class="clearfix"></div>
		<?php

	}

	if ( isset($target_property) &&
	     get_post_meta( $target_property->ID, 'REAL_HOMES_property_images', false ) &&
	     ! empty( get_post_meta( $target_property->ID, 'REAL_HOMES_property_images', false ) ) ) {
		$get_images_count = count( array_filter( get_post_meta( $target_property->ID, 'REAL_HOMES_property_images', false ) ) );
	} else {
		$get_images_count = 0;
	}
	$inspiry_submit_max_number_images = get_option( 'inspiry_submit_max_number_images', 48 );
	?>

    <div id="drag-and-drop" class="rh_drag_and_drop_wrapper <?php if($get_images_count == $inspiry_submit_max_number_images ){ echo esc_attr('hide');}; ?>" data-max-images="<?php echo esc_attr($inspiry_submit_max_number_images) ?>">
        <div class="drag-drop-msg"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;<?php esc_html_e('Drag and drop images here', 'framework'); ?></div>
        <div class="drag-or"><?php esc_html_e('or', 'framework'); ?></div>
        <div class="drag-btn">
            <button id="select-images"  class="real-btn">
				<?php esc_html_e('Select Images', 'framework'); ?>
            </button>
        </div>
        <div class="limit_left">
            <span class="uploaded"><?php echo esc_html($get_images_count);?></span>
		    <?php echo '/'?>
	        <?php echo esc_html($inspiry_submit_max_number_images); ?>
        </div>
    </div>
    <div class="rh_max_file_limit_message <?php if($get_images_count < $inspiry_submit_max_number_images ){ echo esc_attr('hide');}; ?>">
        <p><?php esc_html_e('You have reached maximum files upload limit','framework'); ?></p>
        <div class="limit_left">
            <span class="uploaded"><?php echo count(array_filter(get_post_meta($target_property->ID,'REAL_HOMES_property_images')));?></span>
			<?php echo '/'?>
			<?php echo get_option('inspiry_submit_max_number_images',48); ?>
        </div>
    </div>
    <div class="field-description">
		<?php esc_html_e('* An image should have minimum width of 770px and minimum height of 386px.', 'framework'); ?><br/>
		<?php esc_html_e('* You can mark an image as featured by clicking the star icon, Otherwise first image will be considered featured image.', 'framework'); ?><br/>
        <span class="rh_max_files_limit_message"><?php printf( esc_html__( 'Your selected files are exceeding from limit of %s ', 'framework' ), $inspiry_submit_max_number_images) ; ?></span>

    </div>
    <div id="errors-log"></div>
</div>