<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminPaketSmsController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $plans = PlanSms::all();
		return View::make('admin.paketSms.index')->with('plans',$plans);
	}

	public function create()
	{
		return View::make('admin.paketSms.create');
	}

	public function store()
	{
		$data = array(
		 	//data person
	        "name"      =>  Input::get("name"),            
	        "sms"       =>  Input::get("sms"), 
	        "price"     =>  Input::get("price"),                 
	    );
	
		$rules = array(
	        'name'      => 'required',
	        'sms'       => 'required',
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
            return Redirect::to('admin/paquetes-sms/create')->withErrors($validation)->withInput();
        }else{
            $plan = new PlanSms;
            $plan->name  = Input::get("name");
            $plan->sms   = Input::get("sms");
            $plan->price = Input::get("price");
            $plan->save();
           
            return Redirect::to('admin/paquetes-sms')->with('flash_message', 'Agregado con exito');
        }
	}

	public function edit($id)
    {
       $plan = PlanSms::find($id);
       return View::make('admin.paketSms.edit')->with('plan',$plan);
    }

    public function update($id)
    {
    	$data = array(
            //data person
            "name"      =>  Input::get("name"),            
            "sms"       =>  Input::get("sms"), 
            "price"     =>  Input::get("price"),                 
        );
    
        $rules = array(
            'name'      => 'required',
            'sms'       => 'required',
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
            return Redirect::to('admin/paquetes-sms/'.$id.'/edit')->withErrors($validation)->withInput();
        }else{
            $plan = PlanSms::find($id);
            $plan->name  = Input::get("name");
            $plan->sms   = Input::get("sms");
            $plan->price = Input::get("price");
            $plan->save();
           
            return Redirect::to('admin/paquetes-sms')->with('flash_message', 'Agregado con exito');
        }

    }

    public function destroy($id)
    {
      $plan = PlanSms::find($id);
      if($plan){
      	$plan->delete();
        return Redirect::back()->withConfirm("Eliminado Exitosamente");
      }else{
        return Redirect::back()->withErrors("Error");
      }
    }
}