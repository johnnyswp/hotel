<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminPrasesController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $exchanges = Exchanges::all();
		return View::make('admin.exchanges.index')->with('exchanges',$exchanges);
	}

	public function create()
	{
		return View::make('admin.exchanges.create');
	}

	public function store()
	{
		$data = array(
		 	//data person
	        "name"         =>  Input::get("name"),
          "code"         =>  Input::get("code"),            
	    );
	
		$rules = array(
	        "name"        => "required",
          "code"        => "required",
	    );

        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $exchanges = new Exchanges;
            $exchanges->name  = Input::get("name");
            $exchanges->symbol  = Input::get("code");
            $exchanges->state  = 1;
            if($exchanges->save()){
               return Redirect::to('admin/exchanges')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }
	}

	public function edit($id)
    {
        $exchanges = Exchanges::find($id);
        return View::make('admin.exchanges.edit')->with('exchanges',$exchanges);
    }

    public function update($id)
    {
    	  $data = array(
        //data person
            "name"         =>  Input::get("name"),
            "symbol"         =>  Input::get("symbol"),            
        );
      
        $rules = array(
          "name"        => "required",
          "symbol"        => "required",
        );
    
        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $exchanges = Exchanges::find($id);
            $exchanges->name  = Input::get("name");
            $exchanges->symbol  = Input::get("symbol");
            $exchanges->state  = 1;
            if($exchanges->save()){
               return Redirect::to('admin/exchanges')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }

    }

    public function destroy($id)
    {
      $exchanges = Exchanges::find($id);
      if($exchanges){
      	$exchanges->delete();
        return Redirect::back()->withConfirm("Eliminado Exitosamente");
      }else{
        return Redirect::back()->withErrors("Error");
      }
    }
}