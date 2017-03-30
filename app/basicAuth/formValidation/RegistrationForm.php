<?php namespace basicAuth\formValidation;

use Laracasts\Validation\FormValidator;

class RegistrationForm extends FormValidator {

	protected $rules = [
		'email' => 'required|email|unique:users',
		'password' => 'required|confirmed|min:6',
		'first_name' => 'required',
		'last_name' => 'required',
		'username'  => 'required|unique:users',
		'country_id' => 'required',
		'country' => 'required',
		'hotel_name'=> 'required|min:2|max:25',
		'infoemail' => 'required|email',
		'city' => 'required',
		'address_hotel'=> 'required|min:1|max:25',
        'lang'=> 'required',
        'exchange_id'=> 'required',
        'picture'=> 'mimes:jpeg,gif,png',

	];
}


