<?php

class Stay extends Eloquent {

	protected $table = 'stays';
	public $timestamps = true;

	public function room()
	{
		return $this->belongsTo('Room');
	}
}