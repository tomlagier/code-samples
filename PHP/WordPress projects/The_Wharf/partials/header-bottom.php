<?php 

/**
 * This file contains the definition for the secondary menu area on the homepage.x
 */

?>

<!-- Begin secondary nav row --> 
<nav role="navigation" id="secondary-nav" class="navigation-secondary">
	<?php wp_nav_menu( array(
		'theme_location'  => 'secondary',
		'walker' 		  => new TW_Walker_Secondary_Nav_Menu(),
		'menu_class'	  => 'menu menu-secondary-menu js-mobile-heading-offset',
		'container'		  => 'div',
		'container_class' => 'container secondary-nav-wrapper'
	) ); ?>
<!-- End secondary nav row -->
</nav>
<div class="mobile-navigation">
	<div class="toggle-nav-label" data-target="main-nav">
		<div class="mobile-label">Be Here
			<div class="subline">Play, Shop, Dine, Stay and Live Here</div>
		</div>
	</div>
	<div class="toggle-nav-label" data-target="secondary-nav">
		<div class="mobile-label">Menu
		<div class="subline">General Information About The Wharf</div>
		</div>
	</div>
</div>