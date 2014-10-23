/**
 * This file shows my approach to setting up some simple AJAX. 
 * It enables a calendar that pulls events from a WordPress plugin.
 * It also uses some ultra-simple JS templating using a neat little trick involving script tags.
 *
 * Written by Tom Lagier
 */

$ = jQuery;

CFE_Events_List = {

	//Initialize
	init: function(){
		this.getSelectors();
		this.setCategory();
		this.getEvents();
		this.setupControls();
	},

	//Gets overwritten by wp_localize_script(), see CFE_Intranet/functions/cfe-scripts.php
	//ajax_url: '',

	//Set up jQuery aliases to minimize redundant element lookups
	getSelectors : function(){
	
		this.wrapper = $('#events-listing');
		this.panel = $('.events-list-panel');
		this.loader = $('.events-list-loader');
		this.nextButton = $('.events-list-next');
		this.prevButton= $('.events-list-prev');
		this.eventTemplate= $('#events-list-event-template');
		
	},

	//Gets category from query string at page load and passes it along to events manager
	setCategory: function(){

		var category = null;

		//Taken from http://css-tricks.com/snippets/javascript/get-url-variables/
		var query = window.location.search.substring(1);
		vars = query.split('&');

		for( var i = 0; i < vars.length; i++ ){
			var pair = vars[i].split('=');
			if (pair[0] == 'category'){
				category = decodeURI(pair[1]);
			}
		}

		if(!category){
			category = 'All events';
		}

		//Update category
		this.wrapper.attr('data-category', category);

	},

	//Sends our AJAX request
	getEvents: function(){

		this.showLoader();

		//Fire that shit up
		$.ajax({
			url : ajax_object.ajax_url,
			data : this.getSettings(),
			dataType : 'json',
			success : function( response ){
				//Validate response
				//Handle errors
				//Display response
				CFE_Events_List.displayEvents( response.events );
			},
			error : function( error ){
				//Handle error
				console.log( error );
			},
		});

	},

	//Pull settings from data attributes of wrapper
	getSettings: function(){

		return {
			"action" : "cfe_events_list",
			"month" : this.wrapper.attr('data-month'),
			"year" : this.wrapper.attr('data-year'),
			"category" : this.wrapper.attr('data-category')
		};


	},

	//Gets the text value of a month by month number.
	getMonth: function( month ){

		var months = [
						'January', 
						'February',
						'March',
						'April',
						'May',
						'June',
						'July',
						'August',
						'September',
						'October',
						'November',
						'December'
					];

		return months[month - 1];

	},

	//Increments the month and year
	//TODO: Not DRY
	getNextMonth: function(){

		var month = parseInt( this.wrapper.attr( 'data-month' ) );
		var year = parseInt( this.wrapper.attr('data-year') );

		month++;

		//Roll over if going Dec -> Jan
		if( month > 12 ){
			month = 1;
			year++;
		}

		this.wrapper.attr( 'data-month', month );
		this.wrapper.attr( 'data-year', year );

		this.wrapper.find('.events-list-month').text( this.getMonth(month) );

		this.getEvents();

	},

	//Decrements the month and year
	//TODO: Not DRY
	getPrevMonth: function(){

		var month = parseInt( this.wrapper.attr( 'data-month' ) );
		var year = parseInt( this.wrapper.attr('data-year') );

		month--;

		//Roll over if going Jan -> Dec
		if( month < 0 ){
			month = 12;
			year--;
		}


		this.wrapper.attr( 'data-month', month );
		this.wrapper.attr( 'data-year', year );

		this.wrapper.find('.events-list-month').text( this.getMonth(month) );

		this.getEvents();

	},

	//Displays all events queried
	displayEvents: function( events ){

		//Remove all current events
		this.panel.html('');

		//Create a templated event for each returned event
		for( var singleEvent in events ){

			this.panel.append( this.createEvent( events[singleEvent] ) );

		}

		//Hide the loader
		this.hideLoader();

	},

	createEvent: function( singleEvent ){

		//Get HTML as string
		eventMarkup = this.eventTemplate.clone().html();

		//Apply templating - fields in singleEvent must match fields in eventTemplate
		// 
		// {
		// 	"date" : day of month, leading zero,
		// 	"month" : three-letter month abbreviation,
		// 	"link" : relative URL to individual event,
		// 	"title" : event title,
		// 	"day" : day of week,
		// 	"time" : event start time,
		// }
		
		var re;

		for( var eventAttr in singleEvent ){
			re = new RegExp( "{{" + eventAttr + "}}", "g" );
			eventMarkup = eventMarkup.replace( re, singleEvent[eventAttr] );
		}

		//Convert from string to HTML
		eventMarkup = $.parseHTML( eventMarkup );
		eventMarkup = $(eventMarkup[1]);

		//Return our shiny new event to be appended
		return eventMarkup;

	},

	//Sets up next and previous navigation
	setupControls : function(){

		this.nextButton.on( 'click', function(){

			CFE_Events_List.getNextMonth();

		} );

		this.prevButton.on( 'click', function(){

			CFE_Events_List.getPrevMonth();

		} );

	},

	//Fades in loading GIF
	showLoader: function(){

		this.panel.fadeOut('fast');

		this.loader.addClass( 'visible' );

	},

	//Fades out loading GIF
	hideLoader: function(){

		this.panel.fadeIn('fast');

		this.loader.removeClass( 'visible' );

	}
};

//Go! Go! Go!
$(document).ready(function(){
	CFE_Events_List.init();
});