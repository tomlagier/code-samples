//This file is used to enable the social sidebar

//Sizes the offset block at the top of the sidebar to keep all content below the header
function sizeOffsetBlock()
{
	var possOffset = $('#navigation').offset().top - $(window).scrollTop()
	var offset = $('#navigation').height() + ( possOffset > 0 ? possOffset : 0);
	$('.offset-block').height(offset);
	$('.sidebar-slide .inner').height($(window).height() - offset - 10);
}

//Make sure to keep the offset block sized on window scroll and resize
$(document).ready(function()
{
	sizeOffsetBlock();
});

$(window).on('scroll resize', function(){
	sizeOffsetBlock();
});

//Gets Facebook content and puts it in its sidebar wrapper
function getFacebook()
{
	//Define our variables
	var html = $('#facebook-slide'), entry, link, image, message, itemId, divider, wrapper;

	//Fire off an ajax request
	$.ajax(
		'/social/facebook',
		{
			success: function(response)
			{
				//Parse response
				response = JSON.parse(response);
				response = response.data;

				//Remove the loading gif
				html.find('.loading-gif').remove();

				//For each social item
				response.forEach(function(post)
				{
					//Only use items with a picture and a message
					if(typeof post.picture !== "undefined" && typeof post.message !== "undefined")
					{

						//Create our HTML
						entry = $('<div class="social-entry"></div>');

						//Get our ID and construct our permalink
						itemId = post.id.split('_');
						itemId = itemId[1];
						link = $('<a href="https://www.facebook.com/StudioGood/posts/' + itemId + '" target="_blank"></a>');

						//Construct our image
						image = $('<img class="social-image" src="' + post.picture + '" />');

						//Construct our message
						message = $('<div class="social-message"></div>');
						message.text(post.message);

						//Append our image and message to link, attach link to entry
						link.append(image).append(message);
						entry.append(link);

						//Create a new wrapper and divider
						divider = $('<div class="divider"></div>');
						wrapper = $('<div class="social-wrapper"></div>');

						//Attach entry and divider to wrapper
						wrapper.append(entry).append(divider);

						//Attach wrapper to facebook slide
						html.append(wrapper);
					}

				});

				//If the facebook tab was opened before the AJAX request finished executing
				if($('#facebook-tab').hasClass('active'))
				{
					//Swap that beezy in
					$('.sidebar-slide .inner').html($('#facebook-slide').html());
				}

			},

			//Should throw exception here
			error: function(response)
			{
				throw {
					name: 'HTTPException', 
					message: response
				};
			}
		}
	);
}

//Gets Twitter content from server
function getTwitter()
{
	//Define variables
	var html = $('#twitter-slide'), entry, link, image, user, message, itemId, divider, wrapper;

	//Fire of that AJAX request
	$.ajax(
		'/social/twitter',
		{
			success: function(response)
			{
				//Parse response
				response = JSON.parse(response);

				//Remove loading gif
				html.find('.loading-gif').remove();

				//For each tweet
				response.forEach(function(tweet){

					//Create a new entry
					entry = $('<div class="social-entry speech-bubble-left"></div>');

					//Create a new permalink
					link = $('<a href="http://twitter.com/' + tweet.user.screen_name + '/status/' + tweet.id_str + '" target="_blank"></a>');
					
					//Create an image if the image is defined
					if(typeof tweet.entities !== "undefined" && typeof tweet.entities.media !== "undefined" && tweet.entities.media.length > 0)
					{
						image = $('<img class="social-image" src="' + tweet.entities.media[0].media_url_https + '" />');
					}
					//Else create a placeholder
					else
					{
						image = $('<img class="social-image" src="/img/logo-placeholder.png" />');	
					}

					//Create a message
					message = $('<div class="social-message"></div>');
					message.text(tweet.text);

					//Create a divider
					divider = $('<div class="divider"></div>');

					//Append the image and message to the link, append link to entry, append entry and divider to wrapper
					link.append(image).append(message);
					entry.append(link);
					wrapper = $('<div class="social-wrapper"></div>');
					wrapper.append(entry).append(divider);

					//Stick it all on the twitter wrapper
					html.append(wrapper);
					
				});

				//If the tab has been opened since the request fired but before it finished, fade it in
				if($('#twitter-tab').hasClass('active'))
				{
					$('.sidebar-slide .inner').html($('#twitter-slide').html());
				}
			},

			//Throw exceptions for errors
			error: function(response)
			{
				throw {
					name: 'HTTPException', 
					message: response
				};
			}
		}
	);
}

//Gets instagram entries and adds them to hidden instagram container
function getInstagram()
{
	//Define variables
	var html = $('#instagram-slide'), entry, link, image, user, message, itemId, divider, wrapper;

	//Fire up the AJAXerator, Lem!
	$.ajax(
		'/social/instagram',
		{
			//Aww yeah, she's hummin' away
			success: function(response)
			{

				//What've we got here? Fresh batch o' instagrams, I reckon
				response = JSON.parse(response);
				response = response.data;

				//We're done loadin, git rid o' that shitty spinner
				html.find('.loading-gif').remove();

				//Now lets start mooshin' this here JSON into some good ol' HTML
				response.forEach(function(gram){

					//Each one o' these sumbitches got them an image and some text in a link, plus a divider.
					entry = $('<div class="social-entry"></div>');

					//Get the link together, 'n stick th'image right in thur
					link = $('<a href="'+ gram.link +'" target="_blank"></a>');
					image = $('<div class="social-image" style="background: url(' + gram.images.thumbnail.url + ') no-repeat 50% 50%;"></div>');

					//Plaster that message on
					message = $('<div class="social-message"></div>');
					message.text(gram.caption.text);

					//Whip up a lil' divider
					divider = $('<div class="divider"></div>');

					//Now start mixin'
					link.append(image).append(message);

					entry.append(link);

					wrapper = $('<div class="social-wrapper"></div>');

					wrapper.append(entry).append(divider);

					//And we're all set on that one.
					html.append(wrapper);
					
				});

				//If the sidebar slide has been toggled since the request started, fade it in
				if($('#instagram-tab').hasClass('active'))
				{
					$('.sidebar-slide .inner').html($('#instagram-slide').html());
				}
			},

			//Aw shit, we got a bug. Time to flush 'em out.
			error: function(response)
			{
				throw {
						name: 'HTTPException', 
						message: response
				};
			}
		}
	);
}

//Fire our ajax requests on doc ready
$(document).ready(function(){
	
	getFacebook();
	getTwitter();
	getInstagram();

	setupSidebarEvents();
	setupSidebarClose();

});

//On our tabs, but not the overheard tab (that's just a link), slide them open when clicked
function setupSidebarEvents()
{
	$('.sidebar-tab:not("#overheard-tab")').on('click', function(evt){
	    
	    //Set classes and open the sidebar
	    $('#social-nav').addClass('open');
	    $('.sidebar-tab').removeClass('active');

	    $(this).addClass('active');

	    var target = $($(this).attr('data-target'));

	    $('.sidebar-slide .inner').addClass('fade');

	    //Fade in the appropriate contents of the sidebar and scroll to the top of the sidebar window
	    setTimeout(function(){
	    	$('.sidebar-slide .inner').html(target.html());
	    	$('.sidebar-slide .inner').scrollTop(0);
	    	$('.sidebar-slide .inner').removeClass('fade');
	    }, 300);
	    
	});
}

//Close the sidebar when a click that's not on it happens
function setupSidebarClose()
{
	$('html').on('click', function(evt){
	    if($('#social-nav').hasClass('open'))
	    {
	    	//If the click isn't on the social sidebar
	        if($(evt.target).closest('#social-nav').length === 0)
	        {
	            $('#social-nav').removeClass('open');
	            $('.sidebar-tab').removeClass('active');
	        }
	    }
	});
}