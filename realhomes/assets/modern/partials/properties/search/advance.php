<?php
/**
 * Properties advance search.
 *
 * @package    realhomes
 * @subpackage modern
 */

if(is_home()){
    $page_id = get_queried_object_id();
} else{
	$page_id = get_the_ID();
}

$REAL_HOMES_hide_advance_search = get_post_meta($page_id,'REAL_HOMES_hide_advance_search',true);

if ( ! '1' == $REAL_HOMES_hide_advance_search ) {

$show_search            = is_page_template( 'templates/home.php' ) ? get_option( 'theme_show_home_search' ) : inspiry_show_header_search_form();
$get_search_form_layout = get_option( 'inspiry_search_form_mod_layout_options', 'default' );
$get_header_variations  = get_option( 'inspiry_header_mod_variation_option', 'one' );
if ( inspiry_is_search_page_configured() && $show_search ) :


    $get_inspiry_search_fields_main_row = (int)get_option('inspiry_search_fields_main_row','4');
    $get_fields_count = count(get_option('theme_search_fields'));

	$advance_search_expand = '';
    if($get_inspiry_search_fields_main_row >= $get_fields_count){
        $advance_search_expand = 'rh_hide_advance_fields';
    }

    ?>
    <div class="rh_prop_search rh_prop_search_init <?php echo esc_attr($advance_search_expand);?>">
		<?php
		if ( inspiry_is_rvr_enabled() ) {
			get_template_part( 'assets/modern/partials/properties/search/rvr-form' );
		} else {
				switch ( $get_search_form_layout ) {
					case 'default';
						get_template_part( 'assets/modern/partials/properties/search/form' );
						break;
					case 'smart';
						get_template_part( 'assets/modern/partials/properties/search/form-smart' );
						break;
				}
		}

		?>
    </div>
    <!-- /.rh_prop_search -->
<?php
endif;
}
?>
