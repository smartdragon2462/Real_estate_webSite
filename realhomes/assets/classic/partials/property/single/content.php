<?php
/**
 * Single Property Contents
 *
 * @package    realhomes
 * @subpackage classic
 */

?>

<article class="property-item clearfix">

    <div class="outer-wrapper clearfix">
	    <?php inspiry_property_qr_code(); ?>
        <div class="wrap clearfix">
		    <?php
		    $address_display = get_option( 'inspiry_display_property_address', 'true' );
		    if ( 'true' === $address_display ) {
			    ?>
                <address class="title">
				    <?php
				    /* Property Address if exists */
				    $property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
				    if ( ! empty( $property_address ) ) {
					    echo esc_html( $property_address );
				    }
				    ?>
                </address>
			    <?php
		    }

		    $status_terms = get_the_terms( get_the_ID(), 'property-status' );
		    $type_terms = get_the_terms( get_the_ID(), "property-type" );

		    $property_price = null;
		    if ( function_exists('ere_get_property_price') ) {
			    $property_price = ere_get_property_price();
		    }

		    if ( ! empty( $status_terms )||
		         ! empty( $property_price ) ||
		         ( $type_terms )
		    ) {
			    ?>
                <h5 class="price">

				    <?php
				    if ( ! empty( $status_terms ) ) {
					    $margin_left_none = '';
					    if ( empty( $property_price ) && !( $type_terms ) ) {
						    $margin_left_none = 'margin-right-0';
					    }
					    ?>
                        <span class="status-label <?php echo esc_attr( $margin_left_none );?>">
				<i class="tag-arrow">
					<?php include INSPIRY_THEME_DIR . '/images/arrow.svg'; ?>
				</i>
						    <?php

						    /* Property Status. For example: For Sale, For Rent */

						    $status_count = 0;
						    foreach ( $status_terms as $term ) {
							    if ( $status_count > 0 ) {
								    echo ', ';
							    }
							    echo esc_html( $term->name );
							    $status_count ++;
						    }

						    ?>
				</span>
					    <?php
				    }


				    if ( ! empty( $property_price ) || ( $type_terms ) ) {

					    ?>

                        <span class="price-and-type">
					<i class="tag-arrow">
						<?php include INSPIRY_THEME_DIR . '/images/arrow.svg'; ?>
					</i>
						    <?php
						    /* Property Price */
						    if ( function_exists( 'ere_property_price' ) ) {
							    ere_property_price();
						    }


						    /* Property Type. For example: Villa, Single Family Home */
						    echo inspiry_get_property_types( $post->ID );
						    ?>
			</span>
					    <?php
				    }
				    ?>
                </h5>
			    <?php
		    }
		    ?>
        </div>
    </div>

	<div class="property-meta clearfix">
		<?php
		// Property meta.
		get_template_part( 'assets/classic/partials/property/single/metas' );
		?>
	</div>

	<div class="content clearfix">
		<?php
		// Contents from WordPress editor.
		the_content();

		// Property additional details from meta boxes.
		get_template_part( 'assets/classic/partials/property/single/additional-details' );

		// Common note from theme options.
		get_template_part( 'assets/classic/partials/property/single/common-note' );
		?>
	</div>

    <?php get_template_part( 'assets/classic/partials/property/single/features' ); ?>
</article>
