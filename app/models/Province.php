<?php

class Province extends Eloquent {

	protected $table = 'provincies';
	public $timestamps = false;

	public function cities()
	{
		return $this->hasMany('City');
	}

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function addresses()
	{
		return $this->hasMany('Address');
	}

}