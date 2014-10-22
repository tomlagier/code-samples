<?php 

/**
 * This file is for defining general and page-specific script loading.
 */


//Register all scripts
//Declare dependencies here
add_action( 'wp_enqueue_scripts', 'tw_register_scripts', 1 );

function tw_register_scripts(){

	//Frameworks
	wp_register_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
	
	//Plugins
	wp_register_script( 'waypoints', get_stylesheet_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ) );
	wp_register_script( 'waypoints-sticky', get_stylesheet_directory_uri() . '/js/waypoints-sticky.min.js', array( 'jquery', 'waypoints' ) );
	wp_register_script( 'velocity', get_stylesheet_directory_uri() . '/js/jquery.velocity.min.js', array( 'jquery' ) );
	wp_register_script( 'velocity-ui', get_stylesheet_directory_uri() . '/js/velocity.ui.js', array( 'jquery', 'velocity' ) );
	wp_register_script( 'datepicker', get_stylesheet_directory_uri() . '/js/bootstrap.datepicker.min.js', array( 'jquery', 'bootstrap' ) );
	wp_register_script( 'doubletap', get_stylesheet_directory_uri() . '/js/doubletaptogo.js', array( 'jquery' ) );
	wp_register_script( 'dropdown-menu', get_stylesheet_directory_uri() . '/js/dropdown-menu.min.js', array( 'jquery' ) );
	wp_register_script( 'gmap3', get_stylesheet_directory_uri() . '/js/gmap3.min.js', array( 'jquery' ) );
	wp_register_script( 'isotope', get_stylesheet_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ) );
	wp_register_script( 'fs-boxer', get_stylesheet_directory_uri() . '/js/jquery.fs.boxer.min.js', array( 'jquery' ) );

	wp_register_script( 'stellar', get_stylesheet_directory_uri() . '/js/jquery.stellar.min.js', array( 'jquery' ) );
	wp_register_script( 'owl-carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ) );
	wp_register_script( 'match-heights', get_stylesheet_directory_uri() . '/js/jquery.matchheights.min.js', array( 'jquery' ) );
	wp_register_script( 'imagesloaded', get_stylesheet_directory_uri() . '/js/jquery.imagesloaded.js', array( 'jquery' ) );

	//Core scripts
	wp_register_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery', 'waypoints-sticky' ) );
	wp_register_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery', 'waypoints-sticky', 'velocity-ui', 'imagesloaded' ) );
}

//Add all universal scripts
add_action( 'wp_enqueue_scripts', 'tw_enqueue_main_scripts', 2 );

function tw_enqueue_main_scripts(){
	
	if( !is_admin() ){

		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'velocity' );
		wp_enqueue_script( 'velocity-ui' );
		wp_enqueue_script( 'doubletap' );
		wp_enqueue_script( 'dropdown-menu' );
		wp_enqueue_script( 'fs-boxer' );
		wp_enqueue_script( 'main' );
		wp_enqueue_script( 'custom' );
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'waypoints-sticky' );
		wp_enqueue_script( 'match-heights' );
		wp_enqueue_script( 'imagesloaded' );

	}
}

//Adds page specific scripts

add_action( 'wp_enqueue_scripts', 'tw_enqueue_home_scripts', 2 );

function tw_enqueue_home_scripts(){

	if( is_home() || is_front_page() ){

		wp_enqueue_script( 'owl-carousel' );

	}

}