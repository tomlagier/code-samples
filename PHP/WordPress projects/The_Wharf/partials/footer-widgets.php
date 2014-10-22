<?php 

/**
 * The widget area in the footer
 */

?>

<div class="footer-widget-area container animated">
	<div class="row">
	
		<?php dynamic_sidebar( 'footer-widgets' ) ?>

		<div class="footer-widget col-md-15 col-xs-6 widget hidden-sm hidden-ms hidden-xs footer-logo">	
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" alt="" />
			</a>
		</div>

	</div>
</div>