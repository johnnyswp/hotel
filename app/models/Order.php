<?php
class Order extends Eloquent {

	protected $table = 'orders';
	public $timestamps = true;

	public function room()
	{
		return $this->belongsTo('Room');
	}

}