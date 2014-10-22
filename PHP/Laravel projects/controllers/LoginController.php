<?php

/**
 * The login controller handles all user authentication for admin routes
 */

class LoginController extends BaseController {

	//Make login page
	public function getLogin()
	{
		return View::make('auth.login')->with('page', 'login');
	}

	//Attempt to authenticate a user
	public function postLogin()
	{
		//Get the email and password
		$email = Input::get('email');
		$password = Input::get('password');

		//Attempt authentication. If successful, remember user
		if (Auth::attempt(array('email' => $email, 'password' => $password), true))
		{
			//Redirect to the page intended before redirected to login route
		    return Redirect::intended('admin');
		}

		//Could not be logged in, pop message
		return View::make('auth.login')
					 ->with('page', 'login')
					 ->with('message', 'You could not be logged in');
	}

	//Test function to see if the user is currently logged in
	public function getChecklogin()
	{
		return json_encode(Auth::check());
	}

	//Return create user page
	public function getCreate()
	{
		return View::make('auth.createuser')->with('page', 'createuser');
	}

	//Attempt to create a user
	public function postCreate()
	{
		//Get all input
		$user = Input::all();
		
		//Create our rules array
		$rules = array(
			'username' => 'required|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			//This is used in lieu of role-based authentication
			'authcode' => 'required|in:'. Config::get('auth.key')
		);

		//Run validator
		$validator = Validator::make(
			$user,
			$rules
		);

		//If the validator passes, create the user
		if($validator->passes())
		{
			//Hash password with bcrypt
			$password = Hash::make($user['password']);

			$newuser = new User;

			$newuser->id = uniqid();
			$newuser->username = $user['username'];
			$newuser->email = $user['email'];
			$newuser->password = $password;

			$newuser->save();

			//Redirect to login page
			return Redirect::to('user/login');
		}

		//Validator failed, get messages and return to blade to display them
		$messages = $validator->messages();
		return View::make('auth.createuser')
			   ->with('page', 'createuser')
		       ->with('messages', $messages->all());
	}

	//Log out and redirect to homepage
	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

}