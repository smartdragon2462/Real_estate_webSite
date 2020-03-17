<?php
/**
 * Property video.
 *
 * @package    realhomes
 * @subpackage classic
 */

$display_video = get_option( 'theme_display_video' );
if ( 'true' === $display_video ) {
	$tour_video_url       = get_post_meta( $post->ID, 'REAL_HOMES_tour_video_url', true );
	$tour_video_image_id  = get_post_meta( $post->ID, 'REAL_HOMES_tour_video_image', true );
	$tour_video_image_src = wp_get_attachment_image_src( $tour_video_image_id, 'property-detail-video-image' );
	$tour_video_image     = $tour_video_image_src[0];

	if ( ! empty( $tour_video_url ) ) {
		?>
		<div class="property-video">
			<?php
			$property_video_title = get_option( 'theme_property_video_title' );
			if ( ! empty( $property_video_title ) ) {
				?><span class="video-label"><?php echo esc_html( $property_video_title ); ?></span><?php
			}
			?>
			<a href="<?php echo esc_url( $tour_video_url ); ?>" class="inspiry-lightbox-item" data-autoplay="true" data-vbtype="video">
				<div class="play-btn"></div>
				<?php
				if ( ! empty( $tour_video_image ) ) {
					echo '<img src="' . esc_url( $tour_video_image ) . '" alt="' . get_the_title( get_the_ID() ) . '">';
				} elseif ( has_post_thumbnail( get_the_ID() ) ) {
					the_post_thumbnail( 'property-detail-video-image' );
				} else {
					inspiry_image_placeholder( 'property-detail-video-image' );
				}

                ?>
			</a>
		</div>
		<?php
	}else {

		$inspiry_video_group = get_post_meta( get_the_ID(), 'inspiry_video_group', true );

		if ( $inspiry_video_group && ! empty( $inspiry_video_group ) ) {

			?>
            <div class="rh_property__video">
				<?php
				$property_video_title = get_option( 'theme_property_video_title' );
				if ( ! empty( $property_video_title ) ) {
					?><span class="video-label"><?php echo esc_html( $property_video_title ); ?></span><?php
				}
				?>
                <div class="rh_wrapper_property_videos_slider flexslider">
                    <ul class="slides">
						<?php
						foreach ( $inspiry_video_group as $videos ) {
							$group_video_id = $videos['inspiry_video_group_image'][0];

							$group_video_title = $videos['inspiry_video_group_title'];
							$group_video_url   = $videos['inspiry_video_group_url'];


							$group_video_src = wp_get_attachment_image_src( $group_video_id, 'property-detail-video-image' );
							if ( ! empty( $group_video_url ) ) {
								?>
                                <li>
                                    <div class="rh_property_video">
                                        <div class="rh_property_video_inner">
											<?php
											if ( ! empty( $group_video_title ) ) {
												?>
                                                <span class="rh_video_title"><?php echo esc_html( $group_video_title ); ?></span>
												<?php
											}

											?>
                                            <a href="<?php echo esc_url( $group_video_url ); ?>"
                                               class="inspiry-lightbox-item"
                                               data-autoplay="true" data-vbtype="video">
                                                <div class="play-btn"></div>
												<?php
												if ( ! empty( $group_video_src[0] ) ) {
													echo '<img src="' . esc_url( $group_video_src[0] ) . '" alt="' . get_the_title( get_the_ID() ) . '">';
												} elseif ( has_post_thumbnail( get_the_ID() ) ) {
													the_post_thumbnail( 'property-detail-video-image' );
												} else {
													inspiry_image_placeholder( 'property-detail-video-image' );
												}
												?>
                                            </a>
											<?php

											?>
                                        </div>
                                    </div>
                                </li>
								<?php
							}
						}
						?>
                    </ul>
                </div>
            </div>
			<?php
		}
	}
}