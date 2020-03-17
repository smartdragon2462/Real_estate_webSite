<?php
/**
 * Displays contact template related stuff.
 *
 * @package realhomes
 */

get_header();

$header_variation = get_option( 'inspiry_contact_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

?>

<section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">

	<div class="rh_page">

		<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
			<div class="rh_page__head">
				<h2 class="rh_page__title"><?php the_title(); ?></h2>
			</div>
		<?php endif; ?>
		
		<div class="rh_page__contact">

			<?php if ( have_posts() ) : ?>

				<div class="rh_blog rh_blog__single">

					<?php while ( have_posts() ) : ?><?php the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'rh_blog__post' ); ?> >

							<div class="rh_content entry-content">
								<?php the_content(); ?>
							</div>

						</article>

					<?php endwhile; ?>

				</div>
			<?php endif; ?>

			<div class="rh_contact">

				<div class="rh_contact__wrap">

					<div class="rh_contact__form">
						<?php
							/**
							 * Contact Form
							 */
							$inspiry_contact_form_shortcode = get_option( 'inspiry_contact_form_shortcode' );

							if ( ! empty( $inspiry_contact_form_shortcode ) ) {

								/* Contact Form Shortcode */
								echo do_shortcode( $inspiry_contact_form_shortcode );

							} else {

								// Default Contact Form.
								$theme_contact_email = get_option( 'theme_contact_email' );

								if ( ! empty( $theme_contact_email ) ) {
									$name_label    = get_option( 'theme_contact_form_name_label' );
									$email_label   = get_option( 'theme_contact_form_email_label' );
									$number_label  = get_option( 'theme_contact_form_number_label' );
									$message_label = get_option( 'theme_contact_form_message_label' );
									$contact_form_name_label    = empty( $name_label ) ? esc_html__( 'Name', 'framework' ) : $name_label;
									$contact_form_email_label   = empty( $email_label ) ? esc_html__( 'Email', 'framework' ) : $email_label;
									$contact_form_number_label  = empty( $number_label ) ? esc_html__( 'Phone Number', 'framework' ) : $number_label;
									$contact_form_message_label = empty( $message_label ) ? esc_html__( 'Message', 'framework' ) : $message_label;

									?>
									<section id="contact-form">
										<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
											<p class="rh_contact__input rh_contact__input_text">
												<label for="name"><?php echo esc_html( $contact_form_name_label ); ?></label>
												<input type="text" name="name" id="name" class="required" placeholder="<?php esc_attr_e( 'Your Name', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
											</p>

											<p class="rh_contact__input rh_contact__input_text">
												<label for="email"><?php echo esc_html( $contact_form_email_label ); ?></label>
												<input type="text" name="email" id="email" class="email required" placeholder="<?php esc_attr_e( 'Your Email', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide a valid email address', 'framework' ); ?>">
											</p>

											<p class="rh_contact__input rh_contact__input_text">
												<label for="number"><?php echo esc_html( $contact_form_number_label ); ?></label>
												<input type="text" name="number" id="number" placeholder="<?php esc_attr_e( 'Your Phone', 'framework' ); ?>">
											</p>

											<p class="rh_contact__input rh_contact__input_textarea">
												<label for="message"><?php echo esc_html( $contact_form_message_label ); ?></label>
												<textarea cols="40" rows="6" name="message" id="message" class="required" placeholder="<?php esc_attr_e( 'Your Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
											</p>
											<?php
												$is_gdpr_enabled = inspiry_is_gdpr_enabled();
												if ( $is_gdpr_enabled ) {

													$gdpr_agreement_text = inspiry_gdpr_agreement_content();

													if ( ! empty( $gdpr_agreement_text ) ) {
														?>
														<p id="rh_inspiry_gdpr" class="rh_inspiry_gdpr rh_contact__input clearfix">
															<?php

																$gdpr_agreement_label   = inspiry_gdpr_agreement_content( 'label' );
																$gdpr_agreement_val_msg = inspiry_gdpr_agreement_content( 'validation-message' );

																if ( ! empty( $gdpr_agreement_label ) ) {
																	?>
																	<span class="gdpr-checkbox-label"><?php echo esc_html( $gdpr_agreement_label ); ?>
																		<span class="required-label">*</span></span>
																	<?php
																}

															?>
															<input type="checkbox" id="inspiry-gdpr" class="required" name="gdpr" title="<?php echo esc_attr( $gdpr_agreement_val_msg ); ?>" value="<?php echo strip_tags( $gdpr_agreement_text ); ?>">
															<label for="inspiry-gdpr"><?php echo wp_kses( $gdpr_agreement_text, inspiry_allowed_html() ); ?></label>
														</p>
														<?php
													}
												}

											if ( class_exists( 'Easy_Real_Estate' ) ) {
												/* Display reCAPTCHA if enabled and configured from customizer settings */
												if ( ere_is_reCAPTCHA_configured() ) {
													?>
													<div class="rh_contact__input rh_contact__input_recaptcha inspiry-recaptcha-wrapper clearfix">
														<div class="inspiry-google-recaptcha"></div>
													</div>
													<?php
												}
											}
											?>

											<p class="rh_contact__input rh_contact__submit">
												<input type="submit" id="submit-button" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>" class="rh_btn rh_btn--primary" name="submit">
												<span id="ajax-loader"><?php include INSPIRY_THEME_DIR . '/images/loader.svg'; ?></span>
												<input type="hidden" name="action" value="send_message"/>
												<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'send_message_nonce' ) ); ?>"/>
											</p>

											<div id="error-container"></div>
											<div id="message-container"></div>
										</form>
									</section>
									<?php
								}
							}
						?>
					</div>
					<!-- /.rh_contact__form -->

					<?php
						$show_details = get_option( 'theme_show_details' );
						if ( 'true' === $show_details ) {
							$contact_address       = stripslashes( get_option( 'theme_contact_address' ) );
							$contact_cell          = get_option( 'theme_contact_cell' );
							$contact_phone         = get_option( 'theme_contact_phone' );
							$contact_fax           = get_option( 'theme_contact_fax' );
							$contact_display_email = get_option( 'theme_contact_display_email' );
							?>

							<div class="rh_contact__details">

								<?php if ( ! empty( $contact_phone ) ) : ?>
									<div class="rh_contact__item">
										<div class="icon"><?php include INSPIRY_THEME_DIR . '/images/icons/icon-phone.svg'; ?></div>
										<p class="content">
											<span class="label"><?php esc_html_e( 'Phone', 'framework' ); ?></span><?php echo esc_html( $contact_phone ); ?>
										</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_cell ) ) : ?>
									<div class="rh_contact__item">
										<div class="icon"><?php include INSPIRY_THEME_DIR . '/images/icons/icon-mobile.svg'; ?></div>
										<p class="content">
											<span class="label"><?php esc_html_e( 'Mobile', 'framework' ); ?></span><?php
                                            echo esc_html( $contact_cell );
                                            ?>
										</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_fax ) ) : ?>
									<div class="rh_contact__item">
										<div class="icon"><?php include INSPIRY_THEME_DIR . '/images/icons/icon-fax.svg'; ?></div>
										<p class="content">
											<span class="label"><?php esc_html_e( 'Fax', 'framework' ); ?></span><?php
                                            echo esc_html( $contact_fax );
                                            ?>
										</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_display_email ) ) : ?>
									<div class="rh_contact__item">
										<div class="icon"><?php include INSPIRY_THEME_DIR . '/images/icons/icon-mail.svg'; ?></div>
										<p class="content">
											<span class="label"><?php
                                                esc_html_e( 'Email', 'framework' );
											?></span><a href="mailto:<?php echo esc_attr( antispambot( $contact_display_email ) ); ?>"><?php
                                                echo esc_html( antispambot( $contact_display_email ) );
                                                ?></a>
										</p>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $contact_address ) ) : ?>
									<div class="rh_contact__item">
										<div class="icon"><?php include INSPIRY_THEME_DIR . '/images/icons/icon-marker.svg'; ?></div>
										<p class="content">
											<span class="label"><?php esc_html_e( 'Address', 'framework' ); ?></span><?php echo inspiry_kses( $contact_address ); ?>
										</p>
									</div>
								<?php endif; ?>

							</div>							<!-- /.rh_contact__details -->
							<?php
						}


					/*
					 * Contact Map
					 */
					$show_contact_map = get_option( 'theme_show_contact_map' );
					if ( 'true' === $show_contact_map ) {
						?>
						<!-- Map Container -->
						<div class="rh_contact__map">
							<!-- Works for Both Google Maps and Open Street Maps -->
							<div id="map_canvas"></div>
						</div>
						<!-- /.rh_contact__map -->
						<?php
					}
					?>

				</div>
				<!-- /.rh_contact__wrap -->

			</div>
			<!-- /.rh_contact -->

		</div>
		<!-- /.rh_page__contact -->

	</div>
	<!-- /.rh_page -->


</section>	<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
