<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminPlanController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $plans = Plan::all();
		return View::make('admin.plan.index')->with('plans',$plans);
	}

	public function create()
	{
		return View::make('admin.plan.create');
	}

	public function store()
	{
		$data = array(
		 	//data person
	        "name"      =>  Input::get("name"),            
	        "code"      =>  Input::get("code"), 
	        "rooms" =>  Input::get("rooms"), 
	        "items"     =>  Input::get("items"), 
	        "time"      =>  Input::get("time"), 
	        "time_test" =>  Input::get("time_test"), 
	        "price"     =>  Input::get("price"),                 
	    );
	
		$rules = array(
	        'name'      => 'required',
	        'code'      => 'required',
	        'rooms' => 'required',
	        'items'     => 'required',
	        'time'      => 'required',
	        'time_test' => 'required',
	        'price'     => 'required',

	    );
        

        $messages = array(
	        'required'  => 'El campo :attribute es obligatorio.'
         );
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::to('admin/planes/create')->withErrors($validation)->withInput();
        }else{
            $plan = new Plan;
            $plan->name = Input::get("name");
            $plan->code = Input::get("code");
            $plan->rooms = Input::get("rooms");
            $plan->items = Input::get("items");
            $plan->time = Input::get("time");
            $plan->state = Input::get("state");
            $plan->time_test = Input::get("time_test");
            $plan->price = Input::get("price");
            $plan->save();
           
            return Redirect::to('admin/planes')->with('flash_message', 'Agregado con exito');
        }
	}

	public function edit($id)
    {
       $plan = Plan::find($id);
       return View::make('admin.plan.edit')->with('plan',$plan);
    }

    public function update($id)
    {
    	$data = array(
		 	//data person
	        "name"      =>  Input::get("name"),            
	        "code"      =>  Input::get("code"), 
	        "rooms"      =>  Input::get("rooms"), 
	        "items"   =>  Input::get("items"), 
	        "time"      =>  Input::get("time"), 
	        "time_test" =>  Input::get("time_test"), 
	        "price"     =>  Input::get("price"),                 
	    );
	
		$rules = array(
	        'name'      => 'required',
	        'code'      => 'required',
	        'rooms'      => 'required',
	        'items'   => 'required',
	        'time'      => 'required',
	        'time_test' => 'required',
	        'price'     => 'required',

	    );
        

        $messages = array(
	        'required'  => 'El campo :attribute es obligatorio.'
         );
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::to('admin/planes/'.$id.'/edit')->withErrors($validation)->withInput();
        }else{
            $plan = Plan::find($id);
            $plan->name = Input::get("name");
            $plan->code = Input::get("code");
            $plan->rooms = Input::get("rooms");
            $plan->items = Input::get("items");
            $plan->time = Input::get("time");
            $plan->state = Input::get("state");
            $plan->time_test = Input::get("time_test");
            $plan->price = Input::get("price");
            $plan->save();
           
            return Redirect::to('admin/planes')->with('flash_message', 'Agregado con exito');
        }

    }

    public function destroy($id)
    {
      $plan = Plan::find($id);
      if($plan){
      	$plan->delete();
        return Redirect::back()->withConfirm("Eliminado Exitosamente");
      }else{
        return Redirect::back()->withErrors("Error");
      }
    }
}