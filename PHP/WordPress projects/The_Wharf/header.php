<!DOCTYPE html>
<?php

/**
 * This file is the generic universal header 
 */

?>
<html>
	<head>
		<?php /** Meta section **/ ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="images/favicon.ico" rel="icon" type="image/png">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php /** Title **/ ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php /** Scripts and styles **/ ?>
		<?php wp_head(); ?>

		<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ie8.css" media="screen" /><![endif]-->

	</head>
	<body <?php body_class(); ?>>

	<?php 
		if( is_home() || is_front_page() ) { 
			get_template_part( 'partials/home', 'loader' ); 
		}
	?>

	  <!-- Start #site -->
	  <div id="site" class="site">

	  <!-- Start header -->
	  <header id="header" class="header" role="banner">
	  	<div class="header-row clearfix">
		<?php get_template_part('partials/header', 'top'); ?>
		<div class="navigation-wrapper js-sticky-nav">
		<?php get_template_part('partials/header', 'middle');
			  get_template_part('partials/header', 'bottom');?>
		</div>
	   <!-- End header -->
	  </header>
		<!-- Start #content -->
		<article id="content">

