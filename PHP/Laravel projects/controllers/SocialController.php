<?php

/**
 * Controller for performing HTTP requests to social APIs. Leverages OAuth where necessary.
 * Requires phpoauthlib to generate oauth requests (headers) and tokens. See the Oauth Test project for more examples
 * of using phpoauthlib.
 */

use \OAuth\ServiceFactory;
use \OAuth\Common\Http\Uri\UriFactory;
use OAuth\OAuth1\Service\Twitter;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use OAuth\OAuth1\Token\StdOAuth1Token;


class SocialController extends BaseController {

	//Gets Facebook wall using the Facebook API
	public function getFacebook()
	{
		//Pull API keys from configuration
		$appId = Config::get('social.facebook.app_id');
		$appSecret = Config::get('social.facebook.app_secret');		
		$profileId = Config::get('social.facebook.profile_id');
		
		//CURL request to get an authToken 
		$authToken = $this->fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$appId}&client_secret={$appSecret}");
		
		//CURL request to pull the Facebook wall
		$facebookFeed = $this->fetchUrl("https://graph.facebook.com/{$profileId}/feed?{$authToken}");

		return $facebookFeed;
	}
  
  	//Get Twitter wall using their API. Need to authenticate using OAuth 1.0 which is a bit of a pain.
	public function getTwitter()
	{
		//Fire up a new OAuth session
		$storage = new Session();

		//Create our config. 3rd param is required redirect URI that is unnecessary for a simple feed request
		$credentials = new Credentials(
			Config::get('social.twitter.client_key'),
			Config::get('social.twitter.client_secret'),
			'http://google.com'
		);

		//Create our service factory and use it to create the twitter service (from artdarek oauth-4-laravel)
		$serviceFactory = new ServiceFactory();
		$twitterService = $serviceFactory->createService('twitter', $credentials, $storage);

		//Create oauth token from our private twitter auth token
        $token = new StdOAuth1Token(Config::get('social.twitter.auth_token'));

        //Set its secret from our private secret
		$token->setAccessTokenSecret(Config::get('social.twitter.auth_token_secret'));

		//Store it in the twitterservice
		$twitterService->getStorage()->storeAccessToken('Twitter', $token);

		//Fina-fuckin'-ly perform our request
	    $twitterFeed = $twitterService->request('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=StudioGood');

	    return $twitterFeed;
	}

	//Compared to that monstrosity, this is a cakewalk.. in the park. Just perform a simple HTTP request with the profile and client ID
	public function getInstagram()
	{
		//Grab vars from config
		$profileId = Config::get('social.instagram.profile_id');
		$clientId = Config::get('social.instagram.client_id');

		//Return feed
		$instagramFeed = $this->fetchUrl("https://api.instagram.com/v1/users/{$profileId}/media/recent/?client_id={$clientId}");

		return $instagramFeed;
	}

	//CURL Shortcut for OAuth
	function fetchUrl($url){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		// You may need to add the line below
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

		$feedData = curl_exec($ch);
		curl_close($ch); 

		return $feedData;
	}

}