<?php 

/**
 * Contains the definition for the middle bar of the header
 */

?>

<!-- Begin middle header row -->
<div class="header-middle">
	<div class="container">
		<div class="row">
			<div class="col-sm-2 col-md-3 header-middle--logo sm-full">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="js-center-vertical" rel="home">
					<img src="<?php header_image(); ?>" alt="" />
				</a>
			</div>
			<div class="col-sm-10 col-md-9">
					<?php wp_nav_menu( array(
					'theme_location'  => 'main',
					'walker' 		  => new TW_Walker_Nav_Menu(),
					'menu_class'	  => 'menu-main-menu menu js-mobile-heading-offset js-mobile-fill-screen',
					'container'		  => 'nav',
					'container_class' => 'navigation js-mobile-fill-screen',
					'container_id' 	  => 'main-nav'
				) ); ?>
			</div>
		</div>
	</div>
</div>
<!-- End middle header row -->