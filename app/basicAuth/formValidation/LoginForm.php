<?php namespace basicAuth\formValidation;

use Laracasts\Validation\FormValidator;

class LoginForm extends FormValidator {

	protected $rules = [
		'email' => 'required',
		'password' => 'required',
	];
}


