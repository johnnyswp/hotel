<?php namespace basicAuth\formValidation;

use Laracasts\Validation\FormValidator;

class AdminUsersEditForm extends FormValidator {

  /**
   * @var array
   */
  protected $rules =
    [
    ''    => 'integer|between:1,2',
     "first_name"     =>  'required|min:1|max:255',
     "last_name"      =>  'required|min:1|max:100',
     'email'          =>  'required|email|unique:users',
     "phone"          =>  'required|min:1|max:100',
     "username"       =>  'required|unique:users',
     "picture"        =>  'mimes:jpeg,gif,png'
    ];

  /**
   * @param int $id
   */
  public function excludeUserId($id)
  {
    $this->rules['email'] = "required|email|unique:users,email,$id";
    $this->rules['username'] = "required|unique:users,username,$id";

    return $this;
  }





}


