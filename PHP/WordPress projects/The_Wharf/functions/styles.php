<?php

/**
 * This file is for defining general and page-level style loading
 */

//Register all styles
//Declare dependencies here
add_action( 'wp_enqueue_scripts', 'tw_register_styles', 1);

function tw_register_styles(){
	
	//General styles
	wp_register_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_register_style( 'bootstrap-theme', get_stylesheet_directory_uri() . '/css/bootstrap-theme.min.css', array( 'bootstrap' ) );
	wp_register_style( 'datepicker', get_stylesheet_directory_uri() . '/css/datepicker.css', array( 'bootstrap' ) );
	wp_register_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css' );
	wp_register_style( 'ie8', get_stylesheet_directory_uri() . '/css/ie8.css' );
	wp_register_style( 'fs-boxer', get_stylesheet_directory_uri() . '/css/jquery.fs.boxer.css' );
	wp_register_style( 'style', get_stylesheet_directory_uri() . '/css/style.css' );
	wp_register_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css', array( 'bootstrap', 'style' ) );
	wp_register_style( 'admin', get_stylesheet_directory_uri() . '/css/admin.css', array( 'bootstrap' ) );
	wp_register_style( 'owl-carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.css' );
	wp_register_style( 'owl-carousel-theme', get_stylesheet_directory_uri() . '/css/owl.theme.css', array( 'owl-carousel' ) );
	wp_register_style( 'owl-carousel-transitions', get_stylesheet_directory_uri() . '/css/owl.transitions.css', array( 'owl-carousel' ) );

}

//Enqueue general styles
add_action( 'wp_enqueue_scripts', 'tw_enqueue_main_styles', 2 );

function tw_enqueue_main_styles(){

	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'bootstrap-theme' );
	wp_enqueue_style( 'custom' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'style' );
	wp_enqueue_style( 'datepicker' );
	wp_enqueue_style( 'fs-boxer' );
}

//Enqueue admin styles
add_action( 'admin_head', 'tw_enqueue_admin_styles' );

function tw_enqueue_admin_styles(){

	wp_enqueue_style( 'admin' );

}

//Enqueue homepage styles
add_action( 'wp_enqueue_scripts', 'tw_enqueue_home_styles', 3 );

function tw_enqueue_home_styles(){

	if( is_home() || is_front_page() ){

		wp_enqueue_style( 'owl-carousel' );
		wp_enqueue_style( 'owl-carousel-theme' );
		wp_enqueue_style( 'owl-carousel-transitions' );

	}

}