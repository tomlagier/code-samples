<?php

/**
 * People model, with relations to social and whimsey models
 */
class Person extends Eloquent {
	protected $table = 'peoples';

	//Each person has many social networks
	public function socials() {
		return $this->hasMany('Social');
	}

	//Each person has many whimseys
	public function whimseys() {
		return $this->hasMany('Whimsey');
	}

	//Convenient function to get a person with related models
	public static function getPerson($id) {
		$person = self::with('whimseys', 'socials')->find($id);
		return $person;
	}
}