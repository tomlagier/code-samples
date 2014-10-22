<?php

/**
 * This file contains all theme functions. 
 * Functions are divided into theme core, helper, and external functions.
 * Theme core provide necessary structure for the theme to run.
 * Helper functions are quality of life abstractions for consistent display of things like dates and times.
 * External functions are groups of functions that deserve their own file, such as style and script loading.
 */

/** CORE **/

/** Set up theme title **/

if(! function_exists( 'tw_wp_title' ) ){

	add_filter( 'wp_title', 'tw_wp_title', 1, 2 );

	function tw_wp_title( $title, $sep ){

		if( is_feed() ){
			return $title;
		}

		$title .= get_bloginfo( 'name', 'display' );

		$site_description = get_bloginfo( 'description', 'display' );
		
		if($site_description && ( is_home() || is_front_page() ) ){
			$title .= " $sep $site_description";
		}

		return $title;

	}

}

/** Add support for header image **/

if(! function_exists( 'tw_add_header_image' ) ){

	add_action( 'after_setup_theme', 'tw_add_header_image' );

	function tw_add_header_image(){

		$header_defaults = array(
			'default-image' => get_template_directory_uri() . '/images/logo.png',
			'uploads'       => true
		);
		
		add_theme_support( 'custom-header', $header_defaults );
		
	}

}

/** Enable categories for images **/
/** From http://richardsweeney.com/add-a-category-to-media-items-in-wordpress/ **/

if(! function_exists( 'tw_add_categories_to_attachments' ) ){

	add_action( 'init' , 'tw_add_categories_to_attachments' );

	function tw_add_categories_to_attachments() {
	    
	    register_taxonomy_for_object_type( 'category', 'attachment' );

	}
	
}


/** Enable category filtering for images **/
/** From http://richardsweeney.com/add-a-category-to-media-items-in-wordpress/ **/

if(! function_exists( 'tw_add_image_category_filter' ) ){

	add_action( 'restrict_manage_posts', 'tw_add_image_category_filter' );

	function tw_add_image_category_filter() {
	    
	    $screen = get_current_screen();
	    if ( 'upload' == $screen->id ) {
	        $dropdown_options = array( 'show_option_all' => __( 'View all categories', 'olab' ), 'hide_empty' => false, 'hierarchical' => true, 'orderby' => 'name', );
	        wp_dropdown_categories( $dropdown_options );
	    }

	}

}


/** Enable categories for pages **/

if(! function_exists( 'tw_add_categories_to_pages' ) ){

	add_action( 'init' , 'tw_add_categories_to_pages' );

	function tw_add_categories_to_pages() {
	    
	    register_taxonomy_for_object_type( 'category', 'page' );

	}
	
}

/** Enable category filtering for pages **/
/** From http://richardsweeney.com/add-a-category-to-media-items-in-wordpress/ **/

if(! function_exists( 'tw_add_page_category_filter' ) ){

	add_action( 'restrict_manage_posts', 'tw_add_page_category_filter' );

	function tw_add_page_category_filter() {
	    
	    $screen = get_current_screen();
	    if ( 'page' == $screen->id ) {
	        $dropdown_options = array( 'show_option_all' => __( 'View all categories', 'olab' ), 'hide_empty' => false, 'hierarchical' => true, 'orderby' => 'name', );
	        wp_dropdown_categories( $dropdown_options );
	    }

	}

}


/** Add image sizes **/

if(! function_exists( 'tw_set_image_sizes' ) ){

	add_action( 'after_setup_theme', 'tw_set_image_sizes' );

	function tw_set_image_sizes(){

		add_image_size( 'homepage-slider-image', 1400, 567, true );
		add_image_size( 'homepage-slider-image-small', 500, 400, true );
		add_image_size( 'homepage-featured-thumbnail', 530, 360, true );
		add_image_size( 'archive-featured-thumbnail', 350, 350, true );
		add_image_size( 'post-featured-image', 424, 360, true );
		add_image_size( 'post-hero', 1400, 280, true );
		add_image_size( 'post-hero-small', 900, 180, true );

	}
	
}

/** Add featured images to posts **/

if(! function_exists( 'tw_add_featured_images' ) ){

	add_action( 'after_setup_theme', 'tw_add_featured_images' );

	function tw_add_featured_images(){

		add_theme_support( 'post-thumbnails' );

	}

}

/** Set excerpt size **/

if(! function_exists( 'tw_excerpt_length' ) && ! function_exists( 'tw_set_excerpt_length' ) ){

	add_action( 'after_setup_theme', 'tw_set_excerpt_length' );

	function tw_set_excerpt_length(){

		add_filter( 'excerpt_length', 'tw_excerpt_length', 999 );
	}

	function tw_excerpt_length(){
		if( is_home() || is_front_page() )
		{
			return 30;
		} else if ( is_search() ){
			return 60;
		} else {
			return 40;
		}
	}
	
}

/** HELPER FUNCTIONS **/

/**
 * Gets an array of display categories for use in filtering and matching
 * @return {array} array of category objects
 */

if(! function_exists( 'tw_get_display_categories' ) ){

	function tw_get_display_categories(){

		$display_category = get_category_by_slug( 'display' );

		return get_categories( array(
			'child_of' => $display_category->term_id,
			'hide_empty' => false
		) );

	}
	
}

/**
 * Gets an array of display category slugs
 * @return {array} of strings representing category slugs.
 */

if(! function_exists( 'tw_get_display_category_slugs' ) ){

	function tw_get_display_category_slugs(){

		$display_categories = get_display_categories();

		return array_map( function ( $category ){
			return $category->slug;
		}, $display_categories );

	}
	
}

/**
 * Returns an array of display categories that the passed post is a member of.
 * Returns false if the post is not a member of any display categories
 * @param  {array} $display_categories array of category slugs from get_display_category_slugs
 * @param  {array} $post_categories array of category objects from 
 * get_the_category()
 * @return {array} of strings representing category slugs that the post is a member of.
 */

if(! function_exists( 'tw_get_post_display_categories' ) ){

	function tw_get_post_display_categories( $display_categories, $post_categories ){

		//Slugs of all categories this post is a member of
		$post_category_slugs = array_map( function ( $category ){
			return $category->slug;	
		}, $post_categories );

		//Slugs of all display categories
		$display_category_slugs = array_map( function ( $category ){
			return $category->slug;
		}, $display_categories );

		//Slugs of all display categories this post is a member of
		$post_display_category_slugs = array_intersect( $display_category_slugs, $post_category_slugs );

		//If it's in any display categories, return them. Else return false
		if( count($post_display_category_slugs) > 0 ){
			return $post_display_category_slugs;
		} else {
			return null;
		}

	}
	
}

/**
 * Gets the featured image for a given category. 
 * If no featured image found, falls back to default image.
 * If no default image, falls back to a fallback.
 * @param  string $category_slug slug of the category to fetch header image for.
 * @return {array}                Array with both small and large URLs
 */

if(! function_exists( 'tw_get_category_header_image' ) ){

	function tw_get_category_header_image( $category_slug ){

		//Category image to fetch
		$header_image_args = array( 
			'post_type' 	=> 'attachment',
			'post_status' 	=> 'any',
			'category_name' => $category_slug,
			'orderby'		=> 'rand',
			'posts_per_page'=> 1,
		 );

		//Execute query
		$header_image_query = new WP_Query( $header_image_args );

		$header_image = array();

		//If there is a featured image
		if( $header_image_query->have_posts() ){
			$header_image_query->the_post();

			//Get attachment image src
			$image_small = wp_get_attachment_image_src( get_the_ID(), 'post-hero-small' );
			$header_image['small'] = $image_small[0];

			$image_large = wp_get_attachment_image_src( get_the_ID(), 'post-hero' );
			$header_image['large'] = $image_large[0];

		} else {
			$header_image = null;
		}

		//Reset the query
		wp_reset_query();

		return $header_image;

	}
	
}


/**
 * Gets a random header image from the default header image category
 * @return {array} Both small and large header image URLs
 */
function tw_get_default_header_image(){

	//No featured image, get a random default header image
	$default_header_image_args = array( 
		'post_type' 	=> 'attachment',
		'post_status' 	=> 'any',
		'category_name' => 'default-header-image',
		'orderby' 		=> 'rand',
		'posts_per_page'=> 1,
	 );

	//Execute query
	$default_header_image_query = new WP_Query( $default_header_image_args );

	//If there are default headers
	if( $default_header_image_query->have_posts() ){
		$default_header_image_query->the_post();

		//Get attachment image src
		$image_small = wp_get_attachment_image_src( get_the_ID(), 'post-hero-small' );
		$header_image['small'] = $image_small[0];

		$image_large = wp_get_attachment_image_src( get_the_ID(), 'post-hero' );
		$header_image['large'] = $image_large[0];

	} else {

		//Fallback
		$header_image['small'] = '/wp-content/uploads/2014/09/page-hero-900x180.jpeg';
		$header_image['large'] = '/wp-content/uploads/2014/09/page-hero.jpeg';

	}

	wp_reset_query();

	return $header_image;

}

/** Breadcrumbs **/
if(! function_exists( 'tw_filter_breadcrumbs' ) ){

	add_filter( 'wpseo_breadcrumb_links', 'tw_filter_breadcrumbs', 10, 2 );

	function tw_filter_breadcrumbs( $links ){

		//Remove any of our hidden breadcrumbs.
		$return_links = array_filter( $links, function( $link ){

			$hidden_crumbs = array( 'display', 'utility' );

			if( isset( $link['term']->slug ) && in_array( $link['term']->slug, $hidden_crumbs ) ){


				return false;

			}

			return true;

		} );

		//Reindex array
		return array_values( $return_links );

	}
}

/** EXTERNAL **/

//For resource requirement and conditional loading
require_once( 'functions/styles.php' );
require_once( 'functions/scripts.php' );

//Menu definitions
require_once( 'functions/menus.php' );

//Pagination definition
require_once( 'functions/pagination.php' );

//Note: also contains sidebar definitions
require_once( 'functions/widgets.php' );

/** THIRD PARTY **/
require_once( 'functions/vendor/Mobile_Detect.php' );