<?php
/**
 * Minimum Beds Field
 */
?>
<div class="option-bar rh-search-field small">
	<label for="select-bedrooms">
		<?php
        $inspiry_min_beds_label = get_option('inspiry_min_beds_label');
        echo !empty( $inspiry_min_beds_label ) ? esc_html( $inspiry_min_beds_label ) : esc_html__( 'Min Beds', 'framework' );
        ?>
	</label>
    <span class="selectwrap">
        <select name="bedrooms" id="select-bedrooms" class="search-select">
            <?php inspiry_min_beds(); ?>
        </select>
    </span>
</div>