<!-- Desktop homepage numeric stats -->

<section id="stats" class="pad-large" data-nav="stats">
	<div class="row">
		
		@foreach($achievements as $stat)
			@if($stat->active)
			
			<!-- Individual stat -->

			<div class="medium-3 columns stat text-center">
				<div class="icon icon-{{$stat->icon}}"></div>
				<h1>{{$stat->count}} {{$stat->item}}</h1>
				<span>{{$stat->definition}}</span>
			</div>
			@endif
		@endforeach
		
	</div>
</section>