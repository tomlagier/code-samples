<?php
/**
 * This file is for creating custom menus, including a custom menu walker
 */

//Register menu locations
register_nav_menu('main', 'Main Menu');
register_nav_menu('secondary', 'Secondary (Lower) Menu');
register_nav_menu('sidebar', 'Sidebar Menu');
register_nav_menu('footer', 'Footer Menu');

//Custom menu walkers
require_once( 'walkers/main-walker.php' );
require_once( 'walkers/second-walker.php' );

/** Add home icon to main menu **/

// add_filter( 'wp_nav_menu_items', 'tw_add_home_icon', 10, 2 );

// function tw_add_home_icon ( $items, $args ) {
// 	$is_index = (is_home() || is_front_page());
// 	$home_classes = "current_page_item current-menu-item";

// 	$home_item = '<li class="menu-item ' . ($is_index ? $home_classes : '') . '  page_item"><a class="menu-item--home" href="' . esc_url( home_url( '/' ) ) . '"><i class="fa fa-home hidden-xs"></i><span class="visible-xs-inline">Home</span></a></li>';

//     if ($is_index && $args->theme_location == 'main') {
//         $items = $home_item . $items;
//     }

//     return $items;
// }