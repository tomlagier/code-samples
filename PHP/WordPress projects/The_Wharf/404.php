<?php

/**
 * Definition of the 404 page, when there ain't no content at that URL!
 */

get_header(); ?>

<div id="page" class="404">

	<?php get_template_part( 'partials/category' , 'image' ); ?>

	<div class="page-wrapper container u-padded-section">
		<div class="row">
			<div class="col-md-12 page-body">
				
				<h1 class="content-title animated right">Sorry, that's a 404</h1>
				
				<div class="page-content animated left">
					There's nothing here.
				</div>

			</div>
		</div>
	</div>

</div>

<?php get_footer(); ?>