<?php

class City extends Eloquent {

	protected $table = 'cities';
	public $timestamps = false;

	public function province()
	{
		return $this->belongsTo('Province');
	}

	public function addresses()
	{
		return $this->hasMany('Address');
	}
}