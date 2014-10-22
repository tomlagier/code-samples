<?php
/**
 * The main template file
 *
 * This file contains the homepage definition for the The Wharf template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage The Wharf
 * @since The Wharf 0.1
 */

get_header();

get_template_part( 'partials/home', 'slider' ); 
get_template_part( 'partials/home', 'featured' );
get_template_part( 'partials/home', 'about' );

get_footer();