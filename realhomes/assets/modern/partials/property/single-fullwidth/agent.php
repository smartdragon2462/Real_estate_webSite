<?php
/**
 * Agent of the single property.
 */

global $post; // Property.

/**
 * A function that works as re-usable template
 *
 * @param array $args - agent box arguments.
 */
function display_agent_box( $args ) {
	global $post;  // Property.

	$facebook_url    = get_post_meta( $args['agent_id'], 'REAL_HOMES_facebook_url', true );
	$twitter_url     = get_post_meta( $args['agent_id'], 'REAL_HOMES_twitter_url', true );
	$linked_in_url   = get_post_meta( $args['agent_id'], 'REAL_HOMES_linked_in_url', true );
	$instagram_url   = get_post_meta( $args['agent_id'], 'inspiry_instagram_url', true );

	$listed_properties	= 0;
	if ( function_exists( 'ere_get_agent_properties_count' ) ) {
		$listed_properties	= ere_get_agent_properties_count( $args['agent_id']  );
	}

	$theme_display_agent_contact_info     = get_option( 'theme_display_agent_contact_info', 'true' );
	$theme_display_agent_description      = get_option( 'theme_display_agent_description', 'true' );
	$theme_display_agent_detail_page_link = get_option( 'theme_display_agent_detail_page_link', 'true' );
	$inspiry_property_agent_form          = get_option( 'inspiry_property_agent_form', 'true' );
	$agent_section_classes                = '';

	if ( 'false' === $theme_display_agent_contact_info ) {
		$agent_section_classes .= ' no-agent-contact-info';
	}

	if ( 'false' === $theme_display_agent_description ) {
		$agent_section_classes .= ' no-agent-description';
	}

	if ( 'false' === $theme_display_agent_detail_page_link ) {
		$agent_section_classes .= ' no-agent-know-more-btn';
	}

	if ( 'false' === $inspiry_property_agent_form ) {
		$agent_section_classes .= ' no-agent-contact-form';
	}
	?>
    <div class="agent-content-wrapper single-property-section<?php echo esc_attr( $agent_section_classes ); ?>">
        <div class="container">
            <div class="rh_property__agent_detail clearfix">
                <div class="rh_property__agent_detail_left_col">
                    <div class="rh_property__agent_head">
                        <?php
                        if ( isset( $args['display_author'] ) && ( $args['display_author'] ) ) {
                            if ( isset( $args['profile_image_id'] ) && ( 0 < $args['profile_image_id'] ) ) {
                                ?>
                                <figure><?php echo wp_get_attachment_image( $args['profile_image_id'], 'agent-image' ); ?></figure>
                                <?php
                            } elseif ( isset( $args['agent_email'] ) ) {
                                ?>
                                <figure><?php echo get_avatar( $args['agent_email'], '210' ); ?></figure>
                                <?php
                            }
                        } else {
                            if ( isset( $args['agent_id'] ) && has_post_thumbnail( $args['agent_id'] ) ) {
                                ?>
                                <figure>
                                    <a href="<?php echo esc_url( get_permalink( $args['agent_id'] ) ); ?>">
                                        <?php echo get_the_post_thumbnail( $args['agent_id'], 'agent-image' ); ?>
                                    </a>
                                </figure>
                                <?php
                            }
                        }
                        ?>
                        <div class="rh_property__agent_title_wrap">
	                        <?php if ( isset( $args['agent_title_text'] ) && ! empty( $args['agent_title_text'] ) ) : ?>
                                <h3 class="name"><?php echo esc_html( $args['agent_title_text'] ); ?></h3>
                            <?php endif; ?>

                            <div class="listed_properties">
                                <p class="heading"><?php ( 1 === $listed_properties ) ? esc_html_e( 'Listed Property', 'framework' ) : esc_html_e( 'Listed Properties', 'framework' ); ?></p>
                                <p class="number"><?php echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0; ?></p>
                            </div>

	                        <?php if( 'true' === $theme_display_agent_detail_page_link ) :
		                        $theme_agent_detail_page_link_text = get_option( 'theme_agent_detail_page_link_text', esc_html__( 'View My Listings', 'framework' ) );
		                        ?>
                                <a href="<?php echo get_the_permalink( $args['agent_id'] ); ?>" class="rh_agent_card__link">
                                    <span><?php echo esc_html( $theme_agent_detail_page_link_text ); ?></span>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
	                    <?php if( 'true' === $theme_display_agent_description ) : ?>
                            <div class="description">
                                <?php
                                if ( isset( $args['agent_title_text'] ) && ! empty( $args['agent_title_text'] ) ) { ?>
                                    <p><?php echo esc_html( strip_tags( $args['agent_description'] ) ); ?></p>
                                    <?php if ( isset( $args['display_author'] ) && ( $args['display_author'] ) ) { ?>
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php esc_html_e( 'Read More', 'framework' ); ?></a>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url( get_permalink( $args['agent_id'] ) ); ?>"><?php esc_html_e( 'Read More', 'framework' ); ?></a>
                                    <?php } ?>
                                <?php } ?>
                            </div>
	                    <?php endif; ?>
	                    <?php if( 'true' === $theme_display_agent_contact_info ) : ?>
                            <div class="contacts-list">
                                <?php
                                if ( isset( $args['agent_office_phone'] ) && ! empty( $args['agent_office_phone'] ) ) : ?>
                                    <p class="contact office">
                                        <span><?php esc_html_e( 'Office', 'framework' ); ?> :&nbsp;</span><?php echo esc_html( $args['agent_office_phone'] ); ?>
                                    </p>
                                    <?php
                                endif;

                                if ( isset( $args['agent_mobile'] ) && ! empty( $args['agent_mobile'] ) ) : ?>
                                    <p class="contact mobile">
                                        <span><?php esc_html_e( 'Mobile', 'framework' ); ?> :&nbsp;</span><?php echo esc_html( $args['agent_mobile'] ); ?>
                                    </p>
                                    <?php
                                endif;

                                if ( isset( $args['agent_office_fax'] ) && ! empty( $args['agent_office_fax'] ) ) : ?>
                                    <p class="contact fax">
                                        <span><?php esc_html_e( 'Fax', 'framework' ); ?> :&nbsp;</span><?php echo esc_html( $args['agent_office_fax'] ); ?>
                                    </p>
                                    <?php
                                endif;

                                if ( isset( $args['agent_whatsapp'] ) && ! empty( $args['agent_whatsapp'] ) ) : ?>
                                    <p class="contact whatsapp">
                                        <span><?php esc_html_e( 'WhatsApp', 'framework' ); ?> :&nbsp;</span><?php echo esc_html( $args['agent_whatsapp'] ); ?>
                                    </p>
                                    <?php
                                endif;

                                if ( isset( $args['agent_email'] ) && ! empty( $args['agent_email'] ) ) : ?>
                                    <p class="contact email">
                                        <span><?php esc_html_e( 'Email', 'framework' ); ?> :&nbsp;</span>
                                        <a href="mailto:<?php echo esc_attr( antispambot( $args['agent_email'] ) ); ?>"><?php echo esc_html( antispambot( $args['agent_email'] ) ); ?></a>
                                    </p>
                                <?php endif; ?>

                                <div class="rh_agent_profile__social">
                                    <?php
                                    if ( ! empty( $facebook_url ) ) : ?>
                                        <a target="_blank" href="<?php echo esc_url( $facebook_url ); ?>"><i class="fa fa-facebook-official"></i></a>
                                        <?php
                                    endif;

                                    if ( ! empty( $twitter_url ) ) : ?>
                                        <a target="_blank" href="<?php echo esc_url( $twitter_url ); ?>"><i class="fa fa-twitter"></i></a>
                                        <?php
                                    endif;

                                    if ( ! empty( $linked_in_url ) ) : ?>
                                        <a target="_blank" href="<?php echo esc_url( $linked_in_url ); ?>"><i class="fa fa-linkedin-square"></i></a>
                                        <?php
                                    endif;

                                    if ( ! empty( $instagram_url ) ) : ?>
                                        <a target="_blank" href="<?php echo esc_url( $instagram_url ); ?>"><i class="fa fa-instagram"></i></a>
                                    <?php endif; ?>
                                </div>
                                <!-- /.rh_agent_profile__social -->
                            </div>
		                <?php endif; ?>
                    </div>
                </div>
                <?php if( 'true' === $inspiry_property_agent_form ) : ?>
                    <div class="rh_property__agent_detail_right_col">
                        <?php if ( isset( $args['agent_email'] ) && ! empty( $args['agent_email'] ) ) :
                            $agent_form_id = 'agent-form-id';
                            if ( isset( $args['agent_id'] ) ) {
                                $agent_form_id .= $args['agent_id'];
                            }
                            ?>
                            <div class="rh_property__agent_contact rh_agent_form">
                                <form id="<?php echo esc_attr( $agent_form_id ); ?>" class="agent-form contact-form-small" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">

                                    <div class="rh_agent_form__field rh_agent_form__text">
                                        <label for="name-<?php echo esc_attr( $agent_form_id ); ?>"><?php esc_html_e( 'Name', 'framework' ); ?></label>
                                        <input type="text" name="name" id="name-<?php echo esc_attr( $agent_form_id ); ?>" placeholder="<?php esc_attr_e( 'Your Name', 'framework' ); ?>" class="required" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
                                    </div>
                                    <!-- /.rh_agent_form__field rh_agent_form__text -->

                                    <div class="rh_agent_form__field rh_agent_form__text">
                                        <label for="email-<?php echo esc_attr( $agent_form_id ); ?>"><?php esc_html_e( 'Email', 'framework' ); ?></label>
                                        <input type="text" name="email" id="email-<?php echo esc_attr( $agent_form_id ); ?>" placeholder="<?php esc_attr_e( 'Your Email', 'framework' ); ?>" class="email required" title="<?php esc_attr_e( '* Please provide valid email address', 'framework' ); ?>">
                                    </div>
                                    <!-- /.rh_agent_form__field rh_agent_form__text -->

                                    <div class="rh_agent_form__field rh_agent_form__text">
                                        <label for="phone-<?php echo esc_attr( $agent_form_id ); ?>"><?php esc_html_e( 'Phone', 'framework' ); ?></label>
                                        <input type="text" name="phone" id="phone-<?php echo esc_attr( $agent_form_id ); ?>" placeholder="<?php esc_attr_e( 'Your Phone', 'framework' ); ?>" class="digits required" title="<?php esc_attr_e( '* Please provide valid phone number', 'framework' ); ?>">
                                    </div>
                                    <!-- /.rh_agent_form__field rh_agent_form__text -->

                                    <div class="rh_agent_form__field rh_agent_form__textarea">
                                        <label for="comment-<?php echo esc_attr( $agent_form_id ); ?>"><?php esc_html_e( 'Your Message', 'framework' ); ?></label>
                                        <textarea rows="6" name="message" id="comment-<?php echo esc_attr( $agent_form_id ); ?>" class="required" placeholder="<?php esc_attr_e( 'Your Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
                                    </div>
                                    <!-- /.rh_agent_form__field rh_agent_form__textarea -->

                                    <?php
                                    $is_gdpr_enabled = inspiry_is_gdpr_enabled();

                                    if ( $is_gdpr_enabled ) {

                                        $gdpr_agreement_text = inspiry_gdpr_agreement_content();

                                        if ( ! empty( $gdpr_agreement_text ) ) {
                                            ?>
                                            <div id="rh_inspiry_gdpr-<?php echo esc_attr( $agent_form_id ); ?>" class="rh_inspiry_gdpr clearfix">
                                                <?php
                                                $gdpr_agreement_label   = inspiry_gdpr_agreement_content( 'label' );
                                                $gdpr_agreement_val_msg = inspiry_gdpr_agreement_content( 'validation-message' );

                                                if ( ! empty( $gdpr_agreement_label ) ) {
                                                    ?>
                                                    <span class="gdpr-checkbox-label"><?php echo esc_html( $gdpr_agreement_label ); ?>
                                                        <span class="required-label">*</span>
                                                    </span>
                                                    <?php
                                                }
                                                ?>
                                                <input type="checkbox" id="inspiry-gdpr-<?php echo esc_attr( $agent_form_id ); ?>" class="required" name="gdpr" title="<?php echo esc_attr( $gdpr_agreement_val_msg ); ?>" value="<?php echo strip_tags( $gdpr_agreement_text ); ?>">
                                                <label for="inspiry-gdpr-<?php echo esc_attr( $agent_form_id ); ?>"><?php echo wp_kses( $gdpr_agreement_text, inspiry_allowed_html() ); ?></label>
                                            </div>
                                            <?php
                                        }
                                    }

                                    if ( class_exists( 'Easy_Real_Estate' ) ) {
                                        if ( ere_is_reCAPTCHA_configured() ) {
                                            ?>
                                            <div class="inspiry-recaptcha-wrapper clearfix">
                                                <div class="inspiry-google-recaptcha"></div>
                                            </div>
                                            <?php
                                        }
                                    }

                                    if(!empty($args['author_display_name'])){
                                        $author_name = $args['author_display_name'];
                                    }else{
                                        $author_name = '';
                                    }
                                    ?>
                                    <div class="rh_agent_form__row">
                                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
                                        <input type="hidden" name="target" value="<?php echo esc_attr( antispambot( $args['agent_email'] ) ); ?>">
                                        <input type="hidden" name="action" value="send_message_to_agent"/>
                                        <input type="hidden" name="property_id" value="<?php echo esc_attr(get_the_ID()) ?>">
                                        <input type="hidden" name="author_name" value="<?php echo esc_attr($author_name); ?>">
                                        <?php
                                        if(!empty($args['agent_id'])){
                                            ?>
                                            <input type="hidden" name="agent_id" value="<?php echo esc_attr($args['agent_id']); ?>">
                                            <?php
                                        }
                                        if(!empty($args['author_id'])){
                                            ?>
                                            <input type="hidden" name="author_id" value="<?php echo esc_attr($args['author_id'])?>">
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" name="property_title" value="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"/>
                                        <input type="hidden" name="property_permalink" value="<?php echo esc_url_raw( get_permalink( get_the_ID() ) ); ?>"/>
                                        <input type="submit" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>" name="submit" class="submit-button rh_btn rh_btn--primary">
                                        <span id="ajax-loader-<?php echo esc_attr( $agent_form_id ); ?>" class="ajax-loader">
                                            <?php include( INSPIRY_THEME_DIR . '/images/loader.svg' ); ?>
                                        </span>
                                    </div><!-- /.rh_agent_form__row -->
                                    <div class="rh_agent_form__row">
                                        <div id="error-container-<?php echo esc_attr( $agent_form_id ); ?>" class="error-container"></div>
                                        <div id="message-container-<?php echo esc_attr( $agent_form_id ); ?>" class="message-container"></div>
                                    </div><!-- /.rh_agent_form__row -->
                                </form>
                            </div>
                            <script type="text/javascript">
                                (function( $ ) {
                                    "use strict";

                                    if( jQuery().validate && jQuery().ajaxSubmit ) {

                                        var agentForm = $( '#<?php echo esc_attr( $agent_form_id ); ?>' );
                                        var submitButton = agentForm.find( '.submit-button' ),
                                            ajaxLoader = agentForm.find( '.ajax-loader' ),
                                            messageContainer = agentForm.find( '.message-container' ),
                                            errorContainer = agentForm.find( ".error-container" );

                                        // Property detail page form
                                        agentForm.validate( {
                                            errorLabelContainer : errorContainer, submitHandler : function( form ) {
                                                $( form ).ajaxSubmit( {
                                                    beforeSubmit : function() {
                                                        submitButton.attr( 'disabled', 'disabled' );
                                                        ajaxLoader.fadeIn( 'fast' );
                                                        messageContainer.fadeOut( 'fast' );
                                                        errorContainer.fadeOut( 'fast' );
                                                    }, success : function( ajax_response, statusText, xhr, $form ) {
                                                        var response = $.parseJSON( ajax_response );
                                                        ajaxLoader.fadeOut( 'fast' );
                                                        submitButton.removeAttr( 'disabled' );
                                                        if( response.success ) {
                                                            $form.resetForm();
                                                            messageContainer.html( response.message ).fadeIn( 'fast' );

                                                            // call reset function if it exists
                                                            if( typeof inspiryResetReCAPTCHA == 'function' ) {
                                                                inspiryResetReCAPTCHA();
                                                            }

                                                        } else {
                                                            errorContainer.html( response.message ).fadeIn( 'fast' );
                                                        }
                                                    }
                                                } );
                                            }
                                        } );
                                    }
                                })( jQuery );
                            </script>
                        <?php endif; ?>
                    </div>
	            <?php endif; ?>
            </div>
        </div>
    </div>
	<?php
}

/**
 * Logic behind displaying agents / author information
 */
$display_agent_info   = get_option( 'theme_display_agent_info' );
$agent_display_option = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_display_option', true );

if ( ( 'true' === $display_agent_info ) && ( 'none' != $agent_display_option ) ) {

	if ( 'my_profile_info' == $agent_display_option ) {

		$profile_args                       = array();
		$profile_args['display_author']     = true;
		$profile_args['author_id'] = get_the_author_meta('ID');
		$profile_args['author_display_name']     = get_the_author_meta( 'display_name' );
		$profile_args['agent_title_text']   = esc_html__( 'Submitted by', 'framework' ) . ' ' . get_the_author_meta( 'display_name' );
		$profile_args['profile_image_id']   = intval( get_the_author_meta( 'profile_image_id' ) );
		$profile_args['agents_count']       = 1;
		$profile_args['agent_mobile']       = get_the_author_meta( 'mobile_number' );
		$profile_args['agent_whatsapp']     = get_the_author_meta( 'mobile_whatsapp' );
		$profile_args['agent_office_phone'] = get_the_author_meta( 'office_number' );
		$profile_args['agent_office_fax']   = get_the_author_meta( 'fax_number' );
		$profile_args['agent_email']        = get_the_author_meta( 'user_email' );
		$profile_args['agent_description']  = get_framework_custom_excerpt( get_the_author_meta( 'description' ), 20 );
		display_agent_box( $profile_args );

	} else {

		$property_agents = get_post_meta( get_the_ID(), 'REAL_HOMES_agents' );
		// Remove invalid ids.
		$property_agents = array_filter( $property_agents, function( $v ) {
			return ( $v > 0 );
		} );
		// Remove duplicated ids.
		$property_agents = array_unique( $property_agents );
		if ( ! empty( $property_agents ) ) {
			$agents_count = count( $property_agents );
			foreach ( $property_agents as $agent ) {
				if ( 0 < intval( $agent ) ) {
					$agent_args                       = array();
					$agent_args['agent_id']           = intval( $agent );
					$agent_args['agents_count']       = $agents_count;
					$agent_args['agent_title_text']   = esc_html(get_option('inspiry_property_agent_label','Agent')) . ' ' . get_the_title( $agent_args['agent_id'] );
					$agent_args['agent_mobile']       = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_mobile_number', true );
					$agent_args['agent_whatsapp']     = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_whatsapp_number', true );
					$agent_args['agent_office_phone'] = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_office_number', true );
					$agent_args['agent_office_fax']   = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_fax_number', true );
					$agent_args['agent_email']        = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_agent_email', true );

					/*
					 * Excerpt for agent is bit tricky as we have to get excerpt if available otherwise post contents
					 */
					$temp_agent_excerpt = get_post_field( 'post_excerpt', $agent_args['agent_id'] );
					if ( empty( $temp_agent_excerpt ) || is_wp_error( $temp_agent_excerpt ) ) {
						$agent_args['agent_excerpt'] = get_post_field( 'post_content', $agent_args['agent_id'] );
					} else {
						$agent_args['agent_excerpt'] = $temp_agent_excerpt;
					}

					$agent_args['agent_description'] = get_framework_custom_excerpt( $agent_args['agent_excerpt'], 20 );
					display_agent_box( $agent_args );
				}
			}
		}
	}
}
