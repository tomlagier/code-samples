<?php

/**
 * Model for per-person social networks for people page
 */
class Social extends Eloquent {
	protected $table = 'social_table';

	//Each social belongs to a person
	public function person() {
		return $this->belongsTo('Person', 'person_id');
	}
}