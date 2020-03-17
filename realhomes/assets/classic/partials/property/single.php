<?php
/**
 * Property detail page.
 *
 * @package    realhomes
 * @subpackage classic
 */
get_header();

$theme_property_detail_variation = get_option( 'theme_property_detail_variation', 'default' );

// Banner Image.
$banner_image_path = '';
$banner_image_id   = get_post_meta( get_the_ID(), 'REAL_HOMES_page_banner_image', true );
if ( $banner_image_id ) {
	$banner_image_path = wp_get_attachment_url( $banner_image_id );
} else {
	$banner_image_path = get_default_banner();
}
?>
    <div class="page-head"
         style="background-repeat: no-repeat;background-position: center top;background-image: url('<?php echo esc_url( $banner_image_path ); ?>'); background-size: cover;">
		<?php if ( ! ( 'true' == get_option( 'theme_banner_titles' ) ) ) : ?>
            <div class="container">
                <div class="wrap clearfix">
                    <h1 class="page-title"><span><?php the_title(); ?></span></h1>
					<?php
					$display_property_breadcrumbs = get_option( 'theme_display_property_breadcrumbs' );
					if ( 'true' == $display_property_breadcrumbs ) {
						get_template_part( 'common/partials/breadcrumbs' );
					}
					?>
                </div>
            </div>
		<?php endif; ?>
    </div><!-- End Page Head -->

<?php
// Property detail page sections
$sortable_property_sections = array(
	'slider'                    => 'true',
	'content'                   => 'true',
	'floor-plans'               => 'true',
	'video'                     => get_option( 'theme_display_video', 'true' ),
	'virtual-tour'              => get_option( 'inspiry_display_virtual_tour', 'false' ),
	'map'                       => get_option( 'theme_display_google_map', 'true' ),
	'attachments'               => get_option( 'theme_display_attachments', 'true' ),
	'children'                  => 'true',
	'agent'                     => ( 'default' === $theme_property_detail_variation && get_option( 'theme_display_agent_info', 'true' ) ) ? 'true' : 'false',
	'energy-performance'        => get_option( 'inspiry_display_energy_performance', 'true' ),
	'rvr/availability-calendar' => get_option( 'inspiry_display_availability_calendar', 'true' )
);

$property_sections_order = array_keys( $sortable_property_sections );
$order_settings          = get_theme_mod( 'inspiry_property_sections_order_default', 'default' );
if ( 'custom' === $order_settings ) {
	$property_sections_order = get_option( 'inspiry_property_sections_order' );
	$property_sections_order = explode( ',', $property_sections_order );
}

?>
    <div class="container contents detail property-section-order-<?php echo esc_attr( $order_settings ); ?>">
        <div class="row">
            <div class="span9 main-wrap">
                <div class="main">
                    <div id="overview">
						<?php
						if ( have_posts() ) : while ( have_posts() ) : the_post();

							if ( ! post_password_required() ) {

								// Display sections according to their order
								if ( ! empty( $property_sections_order ) && is_array( $property_sections_order ) ) {
									foreach ( $property_sections_order as $section ) {
										if ( isset( $sortable_property_sections[ $section ] ) && 'true' === $sortable_property_sections[ $section ] ) {
											get_template_part( 'assets/classic/partials/property/single/' . $section );
										}
									}
								}
							} else {
								echo get_the_password_form();
							}
						endwhile;
						endif;
						?>
                    </div>
                </div><!-- End Main Content -->
				<?php
				/**
				 * Similar Properties
				 */
				get_template_part( 'assets/classic/partials/property/single/similar-properties' );

				/**
				 * Comments
				 * If comments are open or we have at least one comment, load up the comment template.
				 */
				if ( comments_open() || get_comments_number() ) : ?>
                    <div class="property-comments">
						<?php comments_template(); ?>
                    </div>
				<?php endif; ?>
            </div><!-- End span9 -->
			<?php
			if ( 'agent-in-sidebar' == $theme_property_detail_variation ) {
				?>
                <div class="span3 sidebar-wrap">
                    <aside class="sidebar property-sidebar">
						<?php
						get_template_part( 'assets/classic/partials/property/single/sidebar-agent' );

						if ( is_active_sidebar( 'property-sidebar' ) ) {
							dynamic_sidebar( 'property-sidebar' );
						}
						?>
                    </aside>
                </div>
				<?php
			} else {
				get_sidebar( 'property' );
			}
			?>
        </div><!-- End contents row -->
    </div><!-- End Content -->
<?php get_footer(); ?>