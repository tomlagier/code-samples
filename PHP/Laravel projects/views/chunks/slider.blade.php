<!-- Homepage case studies full-screen fading slider -->

<section id="case-studies" class="slider-centered" data-nav="case-studies">
	<div id="case-studies-slider">
		<ul class="slides">
			@foreach($caseStudySlides as $slide)
			@if($slide->active)

			<!-- Individual slide -->

			<li class="has-parallax cover-bg">
				
				<!-- Slide content box -->

				<div class="row slide-content content-box {{$slide->position}}">
					<h2>{{$slide->title}}</h2>
					<p>{{$slide->description}}</p>
					<div><a href="/work" class="btn"><h6 class="alt-h">See All</h6></a></div>
				</div>
				
				<!-- Slide background image -->

				<img alt="Slider Background" class="slider-bg" src="/img/sliders/{{$slide->image}}" />
			</li>
			@endif
			@endforeach
		</ul>
	</div>
</section>