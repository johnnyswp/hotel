<?php

class Country extends Eloquent {

	protected $table = 'countries';
	public $timestamps = false;

	public function provinces()
	{
		return $this->hasMany('Province');
	}

}