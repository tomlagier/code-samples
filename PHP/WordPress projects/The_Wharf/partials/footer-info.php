<?php

/**
 * This file contains the definition for the lower part of the yellow footer area, which contains a menu, some copyright text, and the social icons.
 */

?>

<div class="footer-info container animated">
					
	<div class="footer-copyright row">

		<div class="footer-socials footer-socials-mobile col-sm-4 visible-sm visible-xs">
			<div class="social-link facebook">FB</div>
			<div class="social-link twitter">TW</div>
			<div class="social-link pinterest">PN</div>
		</div>

		<div class="col-xs-12 footer-copyright">	
			The Wharf is a neighborhood development by Hoffman-Madison Waterfront in partnership with the District of Columbia. All rights reserved.
		</div>

		<div class="footer-menu col-sm-8">
			<?php wp_nav_menu( array(
				'theme_location'  => 'footer',
				'walker' 		  => new TW_Walker_Nav_Menu(),
				'menu_class'	  => 'menu-footer-menu menu',
				'container'		  => 'nav',
				'container_class' => 'navigation',
				'container_id' 	  => 'footer-nav'
			) ); ?>
		</div>

		<div class="footer-socials footer-socials-desktop col-sm-4 hidden-sm hidden-xs">
			<div class="social-link facebook">FB</div>
			<div class="social-link twitter">TW</div>
			<div class="social-link pinterest">PN</div>
		</div>

	</div>

</div>