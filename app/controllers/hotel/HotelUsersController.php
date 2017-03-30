<?php

use basicAuth\Repo\UserRepositoryInterface;
use basicAuth\formValidation\CompanyUsersEditForm;

class HotelUsersController extends \BaseController {

	/**
	 * @var $user
	 */
	protected $user;

	/**
	* @var adminUsersEditForm
	*/
	protected $companyUsersEditForm;

	/**
	* @param AdminUsersEditForm $AdminUsersEditForm
	*/
	function __construct(UserRepositoryInterface $user, CompanyUsersEditForm $companyUsersEditForm)
	{
		$this->user = $user;
		$this->companyUsersEditForm = $companyUsersEditForm;

		//$this->beforeFilter('currentUser', ['only' => ['show', 'edit', 'update']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
		$users = User::where('hotel_id', $hotel->id)->get();	
		return View::make('hotel.pages.usuarios')->withUsers($users);
	}

	public function create()
	{
		$countrys = Country::orderBy('name', 'ASC')->get();
        $countries = array();
        foreach ($countrys as $country) {
            $countries[$country->id] = $country->name."(".$country->prefix.")";
        }

		return View::make('hotel.pages.alta_usuario')->withCountries($countries);
	}

	public function store()
	{
		$data = array(
            "first_name"     =>  Input::get("first_name"),
            "last_name"      =>  Input::get("last_name"),
            "email"          =>  Input::get("email"),
            "phone"          =>  Input::get("phone"),
            "username"       =>  Input::get("username"),
            "password"       =>  Input::get("password"),
            "type"           =>  Input::get("type"),
        );

        $rules = array(
            "first_name"     =>  'required|min:1|max:255',
            "last_name"      =>  'required|min:1|max:100',
            'email'          =>  'email|unique:users',
		    'password'       =>  'required|confirmed',
            "phone"          =>  'min:1|max:100',
            "username"       =>  'required|unique:users',
            "type_user"      =>  'required',
        );

        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }
        else
        { 
        
            $input = Input::only('email', 'password', 'first_name', 'last_name', 'username', 'position', 'country_id', 'phone');
            
            if(in_array('1', Input::get('type_user')) and in_array('2', Input::get('type_user')))
            	$input['type_user'] = 0;
            elseif(in_array('1', Input::get('type_user')))
            	$input['type_user'] = 1;
            elseif(in_array('2', Input::get('type_user')))
            	$input['type_user'] = 2;

            $input['activated'] = 1;
            $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
            $input['hotel_id'] = $hotel->id;

            if(Input::get("email")=="")
                $input['email'] = User::generaEmail();
            else
                $input['email'] = Input::get("email");

            if($user = $this->user->create($input)){
		         // Find the group using the group name
    	         $usersGroup = Sentry::findGroupByName('Hotels');
    	         // Assign the group to the user
    	         $user->addGroup($usersGroup);

                return Redirect::to('hotel/users')->withFlash_message(trans('main.Guardado Exitosamente'));
            }else{
              return Redirect::back()->withErrors(trans('main.Error'))->withInput();      
            }
         
        }
	}

	public function show($id)
	{
		$user = $this->user->find($id);

		$user_group = $user->getGroups()->first()->name;

		$groups = Sentry::findAllGroups();

		return View::make('protected.company.show_user')->withUser($user)->withUserGroup($user_group);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	*/
	public function edit($id)
	{
		$user = $this->user->find($id);

		$groups = Sentry::findAllGroups();

		$user_group = $user->getGroups()->first()->id;

		$array_groups = array('7'=>'recepcionista', '8'=>'cocina');
        
        $countrys = Country::orderBy('name', 'ASC')->get();
        $countries = array();
        foreach ($countrys as $country) {
            $countries[$country->id] = $country->name."(".$country->prefix.")";
        }

		return View::make('hotel.pages.edit_usuario', ['user' => $user, 'groups' => $array_groups, 'user_group' =>$user_group, 'countries'=>$countries]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = array(
            "first_name"     =>  Input::get("first_name"),
            "last_name"      =>  Input::get("last_name"),
            "email"          =>  Input::get("email"),
            "phone"          =>  Input::get("phone"),
            "username"       =>  Input::get("username"),
            "type_user"       =>  Input::get("type_user"),
        );

        $rules = array(
            "first_name"     =>  'required|min:1|max:255',
            "last_name"      =>  'required|min:1|max:100',
            'email'          =>  "required|email|unique:users,email,$id",
            "phone"          =>  'required|min:1|max:100',
            "username"       =>  "required|unique:users,username,$id",
            "type_user"          =>  'required',
        );

        $messages = array();
    
        $validation = Validator::make(Input::all(), $rules, $messages);
             //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }
        else
        { 
		    $user = $this->user->find($id);
		    $input = Input::only('email', 'first_name', 'last_name', 'username', 'position', 'birthday', 'country_id', 'phone');
            if(in_array('1', Input::get('type_user')) and in_array('2', Input::get('type_user')))
            	$input['type_user'] = 0;
            elseif(in_array('1', Input::get('type_user')))
            	$input['type_user'] = 1;
            elseif(in_array('2', Input::get('type_user')))
            	$input['type_user'] = 2;

		    $user->fill($input)->save();
    
		    return Redirect::to('hotel/users')->withFlashMessage('User has been updated successfully!');
	    }    
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
    {
       $hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
       $user = User::where('id', $id)->where('hotel_id', $hotel->id)->first();
       if($user){
          $user->delete();
          return Redirect::back()->withFlash_message(trans('main.Eliminado Exitosamente'));
        }else{
          return Redirect::back()->withErrors(trans('main.Error'));
        } 
    }

}