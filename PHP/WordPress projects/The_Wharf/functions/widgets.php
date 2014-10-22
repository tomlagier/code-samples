<?php

/**
 * This file is for registering all widgets. 
 * Widget definitions occur in their own files, this file just groups and registers
 * them, as well as registering widget areas. Sidebars are widget areas, so sidebars are registered as well.
 */

/** Widget/sidebar area registration **/

add_action( 'widgets_init', 'tw_widgets_init' );

function tw_widgets_init()
{

	//Footer widget area
	register_sidebar( array( 
		'name' => 'Footer Widget Area',
		'id' => 'footer-widgets',
		'class' => 'footer-widgets',
		'description' => 'Footer widgets, one column per widget. 4 columns total.',
		'before_widget' => '<div class="footer-widget col-md-15 col-xs-6 js-matchheight widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="footer-widget-title">',
		'after_title' => '</h3>',
	) );

	//Per-category sidebars
	tw_register_category_sidebars();

	//Generic sidebar for uncategorized posts and pages
	register_sidebar( array(
		'name' => 'Uncategorized Sidebar',
		'id' => 'sidebar-widgets-uncategorized',
		'description' => 'Widgets displayed in the sidebar for uncategorized posts and pages',
    	'before_widget' => '<div id="%1$s" class="%2$s sidebar-widget">',
    	'after_widget' => '</div>',
    	'before_title' => '<h3 class="sidebar-widget-title">',
    	'after_title' => '</h3>', 
	) );

}

function tw_register_category_sidebars()
{

	$display_category = get_category_by_slug( 'display' );

	$categories = get_categories( array(
		'child_of' => $display_category->term_id,
		'hide_empty' => false
	) );

	foreach( $categories as &$category) {
	  	register_sidebar( array(
			'name' => 'Category Sidebar : ' . $category->cat_name,
			'id' => 'sidebar-widgets-' . $category->slug,
			'description' => 'Widgets displayed in the sidebar for ' . $category->cat_name . ' category',
	    	'before_widget' => '<div id="%1$s" class="%2$s sidebar-widget">',
	    	'after_widget' => '</div>',
	    	'before_title' => '<h3 class="sidebar-widget-title">',
	    	'after_title' => '</h3>', 
	    ) );
	} 

}

/** Widget definitions **/

require_once( 'widgets/tw-related-posts.php' );
