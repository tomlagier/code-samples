<?php 

/**
 * Contains the definition for the upper row of the header
 */

?>
<!-- Begin upper header row -->
<div class="header-upper">
	<div class="container">
		<div class="row">
			<div class="columns col-sm-12 absolute-header">
				<div class="header-upper--tagline font-smoothed js-center-vertical pull-left">
					<?php bloginfo( 'description', 'display' ); ?>
				</div>
				<div class="header-search pull-right">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
<!-- End upper header row -->
</div>