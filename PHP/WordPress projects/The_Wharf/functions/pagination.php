<?php

/**
 * Contains the definition for pagination.
 */

/**
 * Returns null if there is no extra pages. 
 * Otherwise, returns properly formatted pagination;
 * @return {string} Pagination HTML
 */
if(! function_exists( 'tw_get_pagination' ) ){

	function tw_get_pagination(){

		//If there is only one page, return null
		global $wp_query;
		
		if( $wp_query->max_num_pages <= 1 ){
			return null;
		}

		$pagination_args = array(

			'prev_text' => __( '&laquo; Prev' ),
			'next_text' => __( 'Next &raquo;' ),
			'mid_size' 	=> __( '1' ),

		);

		return paginate_links( $pagination_args );

	}

}