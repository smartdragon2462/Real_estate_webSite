<?php

if ( ! function_exists( 'inspiry_booking_dates_search' ) ) :
	/**
	 * Perform check-in & check-out search on properties
	 * to collect ineligible properties IDs
	 *
	 * @param $search_args
	 *
	 * @return array
	 */
	function inspiry_booking_dates_search( $search_args ) {

		if ( ( isset( $_GET['check-in'] ) && ! empty( $_GET['check-in'] ) ) || ( isset( $_GET['check-out'] ) && ! empty( $_GET['check-out'] ) ) ) {

			// properties ids that are ineligible for the search results
			$ineligible_properties = inspiry_reserved_properties_ids();

			if ( is_array( $search_args['post__not_in'] ) && ! empty( $search_args['post__not_in'] ) ) {
				$search_args['post__not_in'] = array_merge( $search_args['post__not_in'], $ineligible_properties );
			} else {
				$search_args['post__not_in'] = $ineligible_properties;
			}
		}

		return $search_args;
	}

	add_filter( 'real_homes_search_parameters', 'inspiry_booking_dates_search' );
endif;


if ( ! function_exists( 'inspiry_reserved_properties_ids' ) ) {
	/**
	 * Return properties ids that are already reserved for the searched dates
	 *
	 * @return array
	 */
	function inspiry_reserved_properties_ids() {

		// searched dates
		$begin = new DateTime( $_GET['check-in'] );
		$end   = new DateTime( $_GET['check-out'] );
		$end   = $end->modify( '+1 day' );

		$interval   = new DateInterval( 'P1D' );
		$date_range = new DatePeriod( $begin, $interval, $end );

		$searched_dates = array();
		foreach ( $date_range as $date ) {
			$searched_dates[] = $date->format( "Y-m-d" );
		}

		// getting ineligible properties ids
		$args       = array(
			'post_type'      => 'property',
			'posts_per_page' => - 1
		);
		$properties = get_posts( $args );

		$ineligible_properties = array();
		foreach ( $properties as $property ) {

			$availability_table = get_post_meta( $property->ID, 'rvr_property_availability_table', true );
			$reserved_dates     = array();

			if ( ! empty( $availability_table ) && is_array( $availability_table ) ) {
				foreach ( $availability_table as $dates ) {

					$begin = new DateTime( $dates[0] );
					$end   = new DateTime( $dates[1] );
					$end   = $end->modify( '+1 day' );

					$interval   = new DateInterval( 'P1D' );
					$date_range = new DatePeriod( $begin, $interval, $end );

					foreach ( $date_range as $date ) {
						$reserved_dates[] = $date->format( "Y-m-d" );
					}
				}

				$already_reserved_dates = array_intersect( $reserved_dates, $searched_dates );

				if ( ! empty( $already_reserved_dates ) ) {
					$ineligible_properties[] = $property->ID;
				}
			}
		}

		return $ineligible_properties;

	}
}


if ( ! function_exists( 'inspiry_guests_search' ) ) :
	/**
	 * Add property guest related search arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_guests_search( $meta_query ) {
		if ( isset( $_GET['guests'] ) && ! empty( $_GET['guests'] ) ) {
			$meta_query[] = array(
				'key'     => 'rvr_guests_capacity',
				'value'   => $_GET['guests'],
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_guests_search' );
endif;


if ( ! function_exists( 'inspiry_min_guests' ) ) {
	/**
	 * Generate values for minimum guests select box
	 */
	function inspiry_min_guests() {

		$min_guests_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		/* check and store searched value if there is any */
		$searched_value = '';
		if ( isset( $_GET['guests'] ) ) {
			$searched_value = $_GET['guests'];
		}

		/* Add any to select box */
		if ( $searched_value == inspiry_any_value() || empty( $searched_value ) ) {
			echo '<option value="' . inspiry_any_value() . '" selected="selected">' . rh_any_text() . '</option>';
		} else {
			echo '<option value="' . inspiry_any_value() . '">' . rh_any_text() . '</option>';
		}

		/* loop through min guests values and generate select options */
		if ( ! empty( $min_guests_values ) ) {
			foreach ( $min_guests_values as $guests_value ) {
				if ( $searched_value == $guests_value ) {
					echo '<option value="' . $guests_value . '" selected="selected">' . $guests_value . '</option>';
				} else {
					echo '<option value="' . $guests_value . '">' . $guests_value . '</option>';
				}
			}
		}

	}
}