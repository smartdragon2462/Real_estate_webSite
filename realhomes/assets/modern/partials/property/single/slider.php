<?php
/**
 * Single Property: Slider
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;

$size = 'modern-property-detail-slider';

$gallery_slider_type = get_post_meta( $post->ID, 'REAL_HOMES_gallery_slider_type', true );
$properties_images   = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image&size=' . $size, get_the_ID() );

if ( ! empty( $properties_images ) && count( $properties_images ) ) { ?>
	<?php if ( 'thumb-on-bottom' == $gallery_slider_type ) : ?>
        <div class="property-detail-slider-wrapper clearfix">
            <div id="property-detail-slider-two" class="property-detail-slider-two inspiry_property_portrait_slider flexslider">
                <ul class="slides">
					<?php
					$title_in_lightbox = get_option( 'inspiry_display_title_in_lightbox' );
					foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
						echo '<li>';
						if ( 'true' == $title_in_lightbox ) {
							echo '<a href="' . $prop_image_meta['full_url'] . '" class="' . get_lightbox_plugin_class() . '" ' . generate_gallery_attribute() . ' title="' . $prop_image_meta['title'] . '">';
						} else {
							echo '<a href="' . $prop_image_meta['full_url'] . '" class="' . get_lightbox_plugin_class() . '" ' . generate_gallery_attribute() . ' >';
						}
						echo '<img src="' . $prop_image_meta['url'] . '" alt="' . $prop_image_meta['title'] . '" />';
						echo '</a>';
						echo '</li>';
					}
					?>
                </ul>
            </div>
            <div id="property-detail-slider-carousel-nav" class="property-detail-slider-carousel-nav inspiry_property_portrait_thumbnails flexslider">
                <ul class="slides">
					<?php
					foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
						$slider_thumb = wp_get_attachment_image_src( $prop_image_id, 'property-thumb-image' );
						echo '<li>';
						echo '<img src="' . $slider_thumb[0] . '" alt="' . $prop_image_meta['title'] . '" />';
						echo '</li>';
					}
					?>
                </ul>
            </div>
        </div>
	<?php else : ?>
        <div id="property-detail-flexslider" class="inspiry_property_portrait_slider clearfix">
            <div class="flexslider">
                <ul class="slides">
					<?php
					$title_in_lightbox = get_option( 'inspiry_display_title_in_lightbox' );
					foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {

//						$slider_thumb = wp_get_attachment_image_src( $prop_image_id, 'property-detail-slider-thumb' );

						echo '<li>';
						if ( 'true' == $title_in_lightbox ) {
							echo '<a href="' . $prop_image_meta['full_url'] . '" class="' . get_lightbox_plugin_class() . '" ' . generate_gallery_attribute() . ' title="' . $prop_image_meta['title'] . '">';
						} else {
							echo '<a href="' . $prop_image_meta['full_url'] . '" class="' . get_lightbox_plugin_class() . '" ' . generate_gallery_attribute() . ' >';
						}
						echo '<img src="' . $prop_image_meta['url'] . '" alt="' . $prop_image_meta['title'] . '" />';
						echo '</a>';
						echo '</li>';
					}
					?>
                </ul>
            </div>
        </div>
	<?php endif; ?>
	<?php if ( has_post_thumbnail() ) : ?>
        <div id="property-featured-image" class="clearfix only-for-print">
			<?php
			$image_id  = get_post_thumbnail_id();
			$image_url = wp_get_attachment_url( $image_id );
			echo '<img src="' . esc_url( $image_url ) . '" alt="' . get_the_title() . '" />';
			?>
        </div>
	<?php endif; ?>
	<?php
} elseif ( has_post_thumbnail() ) { ?>
    <div id="property-featured-image" class="clearfix">
		<?php
		$image_id  = get_post_thumbnail_id();
		$image_url = wp_get_attachment_url( $image_id );
		echo '<a href="' . esc_url( $image_url ) . '" class="' . get_lightbox_plugin_class() . '" ' . generate_gallery_attribute() . '>';
		echo '<img src="' . esc_url( $image_url ) . '" alt="' . get_the_title() . '" />';
		echo '</a>';
		?>
    </div>
	<?php
}