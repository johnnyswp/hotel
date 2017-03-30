<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminPhrasesLanguagesController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
      $phrasesLangs = PhraseLang::all();
		  return View::make('admin.phrases_languages.index')->with('phrasesLangs',$phrasesLangs);
	}

	public function create()
	{
        $langs = Language::get();
        $phrases = Phrase::get();

        $languges = array(''=>'Seleccione un lenguaje');
        foreach ($langs as $lang) {
            $languges[$lang->id] = $lang->language;
        }

        $phr = array(''=>'Seleccione una frase');
        foreach ($phrases as $phrase) {
            $phr[$phrase->id] = $phrase->name;
        }

		return View::make('admin.phrases_languages.create')->with('langs',$languges)->with('phrases',$phr);
	}

	public function store()
	{
		$data = array(
		 	//data person
	        "name"         =>  Input::get("name"),            
	        "language_id"  =>  Input::get("language_id"),
          "phrase_id"  =>  Input::get("phrase_id"),
	    );
	
		$rules = array(
	        "name"        => "required",
          "language_id" => "required",
          "phrase_id" => "required",
	    );

        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $phraseLang = new PhraseLang;
            $phraseLang->name  = Input::get("name");
            $phraseLang->language_id  = Input::get("language_id");
            $phraseLang->phrase_id  = Input::get("phrase_id");
            if($phraseLang->save()){
               return Redirect::to('admin/phrases-languages')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }
	}

	public function edit($id)
    {
        $langs = Language::get();
        $phrases = Phrase::get();

        $languges = array(''=>'Seleccione un lenguaje');
        foreach ($langs as $lang) {
            $languges[$lang->id] = $lang->language;
        }

        $phr = array(''=>'Seleccione una frase');
        foreach ($phrases as $phrase) {
            $phr[$phrase->id] = $phrase->name;
        }

        $phraseLang = PhraseLang::find($id);
        return View::make('admin.phrases_languages.edit')->with('phraseLang',$phraseLang)->with('langs',$languges)->with('phrases',$phr);
    }

    public function update($id)
    {
    	$data = array(
      //data person
          "name"         =>  Input::get("name"),            
          "language_id"  =>  Input::get("language_id"),
          "phrase_id"  =>  Input::get("phrase_id"),
      );
  
    $rules = array(
          "name"        => "required",
          "language_id" => "required",
          "phrase_id" => "required",
      );

        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $phraseLang = PhraseLang::find($id);
            $phraseLang->name  = Input::get("name");
            $phraseLang->language_id  = Input::get("language_id");
            $phraseLang->phrase_id  = Input::get("phrase_id");
            if($phraseLang->save()){
               return Redirect::to('admin/phrases-languages')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }

    }

    public function destroy($id)
    {
      $phraseLang = PhraseLang::find($id);
      if($phraseLang){
      	$phraseLang->delete();
        return Redirect::back()->withConfirm("Eliminado Exitosamente");
      }else{
        return Redirect::back()->withErrors("Error");
      }
    }
}