<?php
/**
 * Child Property Card
 *
 * Child property card to be displayed on property detail page under children properties.
 */
global $post;
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$is_featured        = get_post_meta( $post->ID, 'REAL_HOMES_featured', true );
?>
<li <?php post_class( 'rh_prop_card' ); ?>>
    <article <?php post_class( 'rh_list_card' ); ?>>
        <div class="rh_list_card__wrap">
            <figure class="rh_list_card__thumbnail">
				<?php if ( $is_featured ) : ?>
                    <div class="rh_label rh_label__list">
                        <div class="rh_label__wrap">
							<?php esc_html_e( 'Featured', 'framework' ); ?>
                            <span></span>
                        </div>
                    </div>
				<?php endif; ?>

                <a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail( $post->ID ) ) : ?><?php $post_thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'modern-property-child-slider' ); ?>
                        <span class="post_thumbnail" style="display: block; background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></span><!-- /.post_thumbnail -->
					<?php else : ?><?php $post_thumbnail_url = get_inspiry_image_placeholder_url( 'modern-property-child-slider' ); ?>
                        <span class="post_thumbnail" style="display: block; background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></span><!-- /.post_thumbnail -->
					<?php endif; ?>
                </a>

				<?php inspiry_display_property_label( $post->ID ); ?>

                <div class="rh_list_card__btns">
					<?php
                    $fav_button = get_option( 'theme_enable_fav_button' );
					if ( 'true' === $fav_button ) {
						$property_id = get_the_ID();
						if ( is_added_to_favorite( $property_id ) ) { ?>
                            <span class="favorite-placeholder highlight__red" data-tooltip="<?php esc_attr_e( 'Added to favorites', 'framework' ); ?>">
						        <?php include INSPIRY_THEME_DIR . '/images/icons/icon-favorite.svg'; ?>
					        </span>
                        <?php } else { ?>
                            <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" class="add-to-favorite-form">
                                <input type="hidden" name="property_id" value="<?php echo esc_attr( $property_id ); ?>"/>
                                <input type="hidden" name="action" value="add_to_favorite"/>
                            </form>
                            <span class="favorite-placeholder highlight__red hide" data-tooltip="<?php esc_attr_e( 'Added to favorites', 'framework' ); ?>">
						        <?php include INSPIRY_THEME_DIR . '/images/icons/icon-favorite.svg'; ?>
					        </span>
                            <a href="#" class="favorite add-to-favorite" data-tooltip="<?php esc_attr_e( 'Add to favorite', 'framework' ); ?>">
								<?php include INSPIRY_THEME_DIR . '/images/icons/icon-favorite.svg'; ?>
                            </a>
							<?php
						}
					}

					$inspiry_property_images = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image&size=' . 'modern-property-detail-slider', get_the_ID() );
					if ( ! empty( $inspiry_property_images ) ) :
						$inspiry_property_images = count( $inspiry_property_images );
						$inspiry_property_images = sprintf( _n( '%s Photo', '%s Photos', $inspiry_property_images, 'framework' ), $inspiry_property_images ); ?>
                        <span class="property-photos" data-tooltip="<?php echo esc_attr( $inspiry_property_images ); ?>">
                            <i class="fa fa-camera"></i>
                        </span>
					<?php endif;

					$compare_properties_module = get_option( 'theme_compare_properties_module' );
					$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
					if ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) {
						get_template_part( 'assets/modern/partials/properties/compare/button' );
					}
					?>
                </div>
            </figure>
            <div class="rh_list_card__details_wrap rh_prop_card__details">
                <div class="rh_list_card__details_inner_wrap">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                    <p class="rh_prop_card__excerpt"><?php framework_excerpt( 12 ); ?></p>

                    <div class="rh_prop_card__meta_wrap">
		                <?php if ( ! empty( $property_bedrooms ) ) : ?>
                            <div class="rh_prop_card__meta">
                                <span class="rh_meta_titles"><?php esc_html_e( 'Bedrooms', 'framework' ); ?></span>
                                <div>
					                <?php include INSPIRY_THEME_DIR . '/images/icons/icon-bed.svg'; ?>
                                    <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                                </div>
                            </div><!-- /.rh_prop_card__meta -->
		                <?php endif; ?>

		                <?php if ( ! empty( $property_bathrooms ) ) : ?>
                            <div class="rh_prop_card__meta">
                                <span class="rh_meta_titles"><?php esc_html_e( 'Bathrooms', 'framework' ); ?></span>
                                <div>
					                <?php include INSPIRY_THEME_DIR . '/images/icons/icon-shower.svg'; ?>
                                    <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                                </div>
                            </div><!-- /.rh_prop_card__meta -->
		                <?php endif; ?>

		                <?php if ( ! empty( $property_size ) ) : ?>
                            <div class="rh_prop_card__meta">
                                <span class="rh_meta_titles"><?php esc_html_e( 'Area', 'framework' ); ?></span>
                                <div>
					                <?php include INSPIRY_THEME_DIR . '/images/icons/icon-area.svg'; ?>
                                    <span class="figure">
                                        <?php echo esc_html( $property_size ); ?>
                                    </span>
					                <?php if ( ! empty( $size_postfix ) ) : ?>
                                        <span class="label">
                                            <?php echo esc_html( $size_postfix ); ?>
                                        </span>
					                <?php endif; ?>
                                </div>
                            </div><!-- /.rh_prop_card__meta -->
		                <?php endif; ?>
                    </div><!-- /.rh_prop_card__meta_wrap -->

	                <?php
	                /* Property features terms */
	                $property_features = get_the_terms( get_the_ID(), 'property-feature' );

	                if ( $property_features && ! is_wp_error( $property_features ) ) :
		                $property_features_counter = 1;
		                $property_features_to_display = 3;
		                $total_property_features = count( $property_features );
		                $more_features = '+' . ( $total_property_features - $property_features_to_display );
		                ?>
                        <div class="property-features">
                            <h4 class="title"><?php esc_attr_e( 'Features', 'framework' ); ?></h4>
			                <?php foreach ( $property_features as $property_feature ) :
				                $property_features_counter++;
                                ?>
                                <span class="feature-<?php echo esc_attr( $property_feature->slug ); ?>"><?php echo ucwords( $property_feature->name ); ?></span>
				                <?php
				                if ( $property_features_to_display < $property_features_counter ) : ?>
                                    <span class="more-features"><?php echo esc_html( $more_features ); ?></span>
					                <?php
					                break;
				                endif;
			                endforeach; ?>
                        </div>
	                <?php endif; ?>

	                <div class="rh_prop_card__priceLabel">
                        <span class="rh_prop_card__status"><?php echo esc_html( display_property_status( get_the_ID() ) ); ?></span>
                        <p class="rh_prop_card__price"><?php
                            if ( function_exists( 'ere_property_price' ) ) {
		                        ere_property_price();
	                        } ?></p>
                    </div><!-- /.rh_prop_card__priceLabel -->
                </div><!-- /.rh_list_card__details_inner_wrap -->
            </div><!-- /.rh_prop_card__details -->
        </div><!-- /.rh_list_card__wrap -->
    </article><!-- /.rh_list_card -->
</li>