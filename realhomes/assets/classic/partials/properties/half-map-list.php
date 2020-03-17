<?php
/**
 * Half Map with Properties List
 *
 * Displays properties in list layout
 *
 * @package    realhomes
 * @subpackage classic
 */

global $page;
?>
<div class="half-map-layout">
	<div class="half-map-layout-map">
		<?php get_template_part( 'assets/classic/partials/banners/map' ); ?>
	</div><!-- /.half-map-layout-map -->
	<div class="half-map-layout-properties">

        <div class="container contents listing-grid-layout listing-grid-full-width-layout">
            <div class="row">
                <div class="span12 main-wrap">

                    <!-- Main Content -->
                    <div class="main">
                        <section class="listing-layout">
							<?php
							$title_display = get_post_meta( $post->ID, 'REAL_HOMES_page_title_display', true );
							if ( 'hide' !== $title_display ) {
								$theme_listing_module = get_option( 'theme_listing_module' );
								if( 'properties-map' == $theme_listing_module ) : ?>
                                    <h1 class="title-heading"><?php the_title(); ?></h1>
								<?php else : ?>
                                    <h3 class="title-heading"><?php the_title(); ?></h3>
									<?php
								endif;
							}
							?>
                            <div class="list-container inner-wrapper clearfix">
                                <?php
                                if ( 'hide' !== $title_display ) {
                                    $theme_listing_module = get_option( 'theme_listing_module' );
                                    if( 'properties-map' == $theme_listing_module ) : ?>
                                        <h1 class="page-title"><?php the_title(); ?></h1>
                                    <?php else : ?>
                                        <h3 class="page-title"><?php the_title(); ?></h3>
                                        <?php
                                    endif;
                                }
                                ?>
								<?php get_template_part( 'assets/classic/partials/properties/sort-controls' ); ?>
								<?php if ( have_posts() ) : ?>
									<?php while ( have_posts() ) : ?>
										<?php the_post(); ?>
                                            <article class="rh_listing_content" <?php post_class(); ?>>
												<?php the_content(); ?>
                                            </article>
									<?php endwhile; ?>
								<?php endif; ?>
								<?php

								$number_of_properties = intval( get_option( 'theme_number_of_properties' ) );
								if ( ! $number_of_properties ) {
									$number_of_properties = 6;
								}

								global $paged;
								if ( is_front_page() ) {
									$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
								}

								$property_listing_args = array(
									'post_type'      => 'property',
									'posts_per_page' => $number_of_properties,
									'paged'          => $paged,
								);

								// Apply properties filter.
								$property_listing_args = apply_filters( 'inspiry_properties_filter', $property_listing_args );

								$property_listing_args = sort_properties( $property_listing_args );

								$property_listing_query = new WP_Query( $property_listing_args );

								if ( $property_listing_query->have_posts() ) :
									while ( $property_listing_query->have_posts() ) :
										$property_listing_query->the_post();

										get_template_part( 'assets/classic/partials/properties/list-card' );

									endwhile;
									wp_reset_postdata();
								else :
									?>
                                    <div class="alert-wrapper">
                                        <h4><?php esc_html_e( 'Sorry No Results Found', 'framework' ); ?></h4>
                                    </div>
									<?php
								endif;
								?>
                            </div>

							<?php theme_pagination( $property_listing_query->max_num_pages ); ?>

                        </section>
                    </div><!-- End Main Content -->
                </div> <!-- End span12 -->
            </div><!-- End contents row -->
        </div>
    </div><!-- /.half-map-layout-properties -->
</div><!-- /.half-map-layout -->