<?php
class Promotion extends Eloquent {

	protected $table = 'promotions';
	public $timestamps = true;
	protected $visible = array('price');

}