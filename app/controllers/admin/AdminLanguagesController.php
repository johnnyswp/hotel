<?php
use \Api\V1\Helpers as H;
use Carbon\Carbon; 
class AdminLanguagesController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $langs = Language::all();
		return View::make('admin.languages.index')->with('langs',$langs);
	}

	public function create()
	{
        $txts = array('txt_hotel', 'txt_direccion', 'txt_catalogo', 'txt_delayed', 'txt_categoria', 'txt_habitacion', 'txt_descripcion', 'txt_total', 'txt_tiempo', 'txt_inicio', 'txt_enviar_pedido', 'txt_horario_de_entrega', 'txt_entrega_inmediata', 'txt_entrega_programa', 'txt_cancelar_pedido', 'txt_carrito_compra', 'txt_pedido_inmediato', 'txt_pedido_programado', 'txt_continuar_comprando', 'txt_telefonos', 'txt_lenguajes', 'txt_enviar', 'txt_aceptar', 'txt_order', 'txt_orders', 'txt_estado', 'txt_pass', 'txt_date', 'txt_time', 'txt_si', 'txt_no', 'txt_promociones', 'txt_fecha_entrega', 'txt_programmed', 'txt_just_now', 'txt_ready', 'txt_delivered', 'txt_message_pedido_ok', 'txt_message_no_datos', 'txt_message_selec_horario', 'txt_message_ingresar_contrasena', 'txt_message_eliminar_pedido', 'txt_no_vailable', 'txt_finalized', 'txt_domingo', 'txt_lunes', 'txt_martes', 'txt_miercoles', 'txt_jueves', 'txt_viernes', 'txt_sabado', 'txt_horario_disponible', 'txt_message_no_horario', 'txt_username','txt_datos_invalidos','txt_token_invalido');
		return View::make('admin.languages.create')->with('txts',$txts);
	}

	public function store()
	{
        $txts = array('txt_hotel', 'txt_direccion', 'txt_catalogo', 'txt_delayed', 'txt_categoria', 'txt_habitacion', 'txt_descripcion', 'txt_total', 'txt_tiempo', 'txt_inicio', 'txt_enviar_pedido', 'txt_horario_de_entrega', 'txt_entrega_inmediata', 'txt_entrega_programa', 'txt_cancelar_pedido', 'txt_carrito_compra', 'txt_pedido_inmediato', 'txt_pedido_programado', 'txt_continuar_comprando', 'txt_telefonos', 'txt_lenguajes', 'txt_enviar', 'txt_aceptar', 'txt_order', 'txt_orders', 'txt_estado', 'txt_pass', 'txt_date', 'txt_time', 'txt_si', 'txt_no', 'txt_promociones', 'txt_fecha_entrega', 'txt_programmed', 'txt_just_now', 'txt_ready', 'txt_delivered', 'txt_message_pedido_ok', 'txt_message_no_datos', 'txt_message_selec_horario', 'txt_message_ingresar_contrasena', 'txt_message_eliminar_pedido', 'txt_no_vailable', 'txt_finalized', 'txt_domingo', 'txt_lunes', 'txt_martes', 'txt_miercoles', 'txt_jueves', 'txt_viernes', 'txt_sabado', 'txt_horario_disponible', 'txt_message_no_horario', 'txt_username','txt_datos_invalidos','txt_token_invalido');

		$data = array(
		 	//data person
	        "language" =>  Input::get("language"),            
	        "flag"     =>  Input::file("flag"),
	    );

        foreach ($txts as $txt) {
           $data[$txt] = Input::get($txt);
        }


	
		$rules = array(
	        "language" => "required",
            "flag" =>  'mimes:jpeg,gif,png'
	    );
        foreach ($txts as $txt) {
           $rules[$txt] = "required";
        }

        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $lang = new Language;
            $lang->sufijo = Input::get("sufijo");
            $lang->language = Input::get("language");
            if(Input::get("state")==1)
                $lang->state   = 1;
            else
                $lang->state   = 0;

            if(Input::file('flag')!=NULL)
            {
                //agrega imagen de flag
                $file_flag=Input::file('flag');
                $ext = Input::file('flag')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $flag=$nameIMG.'.'.$ext;
                $flag= url().'/assets/img/flags/PIC'.$flag;
                $lang->flag = $flag;
            }else{
                $lang->flag = url().'/assets/img/no-image.png';
            }
            
            $lang->txt_hotel = Input::get('txt_hotel');
            $lang->txt_direccion = Input::get('txt_direccion');
            $lang->txt_catalogo = Input::get('txt_catalogo');
            $lang->txt_delayed = Input::get('txt_delayed');
            $lang->txt_categoria = Input::get('txt_categoria');
            $lang->txt_habitacion = Input::get('txt_habitacion');
            $lang->txt_descripcion = Input::get('txt_descripcion');
            $lang->txt_total = Input::get('txt_total');
            $lang->txt_tiempo = Input::get('txt_tiempo');
            $lang->txt_inicio = Input::get('txt_inicio');
            $lang->txt_enviar_pedido = Input::get('txt_enviar_pedido');
            $lang->txt_horario_de_entrega = Input::get('txt_horario_de_entrega');
            $lang->txt_entrega_inmediata = Input::get('txt_entrega_inmediata');
            $lang->txt_entrega_programa = Input::get('txt_entrega_programa');
            $lang->txt_cancelar_pedido = Input::get('txt_cancelar_pedido');
            $lang->txt_carrito_compra = Input::get('txt_carrito_compra');
            $lang->txt_pedido_inmediato = Input::get('txt_pedido_inmediato');
            $lang->txt_pedido_programado = Input::get('txt_pedido_programado');
            $lang->txt_continuar_comprando = Input::get('txt_continuar_comprando');
            $lang->txt_telefonos = Input::get('txt_telefonos');
            $lang->txt_lenguajes = Input::get('txt_lenguajes');
            $lang->txt_enviar = Input::get('txt_enviar');
            $lang->txt_aceptar = Input::get('txt_aceptar');
            $lang->txt_order = Input::get('txt_order');
            $lang->txt_orders = Input::get('txt_orders');
            $lang->txt_estado = Input::get('txt_estado');
            $lang->txt_pass = Input::get('txt_pass');
            $lang->txt_date = Input::get('txt_date');
            $lang->txt_time = Input::get('txt_time');
            $lang->txt_si = Input::get('txt_si');
            $lang->txt_no = Input::get('txt_no');
            $lang->txt_promociones = Input::get('txt_promociones');
            $lang->txt_fecha_entrega = Input::get('txt_fecha_entrega');
            $lang->txt_programmed = Input::get('txt_programmed');
            $lang->txt_just_now = Input::get('txt_just_now');
            $lang->txt_ready = Input::get('txt_ready');
            $lang->txt_delivered = Input::get('txt_delivered');
            $lang->txt_message_pedido_ok = Input::get('txt_message_pedido_ok');
            $lang->txt_message_no_datos = Input::get('txt_message_no_datos');
            $lang->txt_message_selec_horario = Input::get('txt_message_selec_horario');
            $lang->txt_message_ingresar_contrasena = Input::get('txt_message_ingresar_contrasena');
            $lang->txt_message_eliminar_pedido = Input::get('txt_message_eliminar_pedido');
            $lang->txt_no_vailable = Input::get('txt_no_vailable');
            $lang->txt_finalized = Input::get('txt_finalized');
            $lang->txt_domingo = Input::get('txt_domingo');
            $lang->txt_lunes = Input::get('txt_lunes');
            $lang->txt_martes = Input::get('txt_martes');
            $lang->txt_miercoles = Input::get('txt_miercoles');
            $lang->txt_jueves = Input::get('txt_jueves');
            $lang->txt_viernes = Input::get('txt_viernes');
            $lang->txt_sabado = Input::get('txt_sabado');
            $lang->txt_horario_disponible = Input::get('txt_horario_disponible');
            $lang->txt_message_no_horario = Input::get('txt_message_no_horario');
            $lang->txt_username = Input::get('txt_username');
            $lang->txt_datos_invalidos = Input::get('txt_datos_invalidos');
            $lang->txt_token_invalido = Input::get('txt_token_invalido');
            
            if($lang->save()){
                if(Input::file('flag')!=NULL)
                {
                    $file_flag->move("assets/img/flags/",$flag); 
                }

                $path = app_path();
                if (!File::exists($path.'/lang/'.$lang->sufijo))
                 {
                    File::makeDirectory($path.'/lang/'.$lang->sufijo, 0775);
                    File::copyDirectory($path.'/lang/es',$path.'/lang/'.$lang->sufijo);
                     
                 }
                 
                 $option = OptionAdmin::where('code','lang')->first();
                 $option->value =  $option->value.",'".$lang->sufijo."'";
                 $option->save();

                // Abrir el archivo
                $archivo = $path.'/config/app.php';
                $abrir = fopen($archivo,'r+');
                $contenido = fread($abrir,filesize($archivo));
                fclose($abrir);
                // Separar linea por linea
                $contenido = explode("\n",$contenido);
                // Modificar linea deseada ( 2 ) 
                $contenido[6] = "    'languages' => array(".$option->value."),";
                // Unir archivo
                $contenido = implode("\n",$contenido);
                // Guardar Archivo
                $abrir = fopen($archivo,'w');
                fwrite($abrir,$contenido);
                fclose($abrir);

               return Redirect::to('admin/languages')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }
	}

	public function edit($id)
    {
       $txts = array('txt_hotel', 'txt_direccion', 'txt_catalogo', 'txt_delayed', 'txt_categoria', 'txt_habitacion', 'txt_descripcion', 'txt_total', 'txt_tiempo', 'txt_inicio', 'txt_enviar_pedido', 'txt_horario_de_entrega', 'txt_entrega_inmediata', 'txt_entrega_programa', 'txt_cancelar_pedido', 'txt_carrito_compra', 'txt_pedido_inmediato', 'txt_pedido_programado', 'txt_continuar_comprando', 'txt_telefonos', 'txt_lenguajes', 'txt_enviar', 'txt_aceptar', 'txt_order', 'txt_orders', 'txt_estado', 'txt_pass', 'txt_date', 'txt_time', 'txt_si', 'txt_no', 'txt_promociones', 'txt_fecha_entrega', 'txt_programmed', 'txt_just_now', 'txt_ready', 'txt_delivered', 'txt_message_pedido_ok', 'txt_message_no_datos', 'txt_message_selec_horario', 'txt_message_ingresar_contrasena', 'txt_message_eliminar_pedido', 'txt_no_vailable', 'txt_finalized', 'txt_domingo', 'txt_lunes', 'txt_martes', 'txt_miercoles', 'txt_jueves', 'txt_viernes', 'txt_sabado', 'txt_horario_disponible', 'txt_message_no_horario', 'txt_username','txt_datos_invalidos','txt_token_invalido');
       $lang = Language::find($id);
       return View::make('admin.languages.edit')->with('lang',$lang)->with('txts',$txts);
    }

    public function update($id)
    {
    	$txts = array('txt_hotel', 'txt_direccion', 'txt_catalogo', 'txt_delayed', 'txt_categoria', 'txt_habitacion', 'txt_descripcion', 'txt_total', 'txt_tiempo', 'txt_inicio', 'txt_enviar_pedido', 'txt_horario_de_entrega', 'txt_entrega_inmediata', 'txt_entrega_programa', 'txt_cancelar_pedido', 'txt_carrito_compra', 'txt_pedido_inmediato', 'txt_pedido_programado', 'txt_continuar_comprando', 'txt_telefonos', 'txt_lenguajes', 'txt_enviar', 'txt_aceptar', 'txt_order', 'txt_orders', 'txt_estado', 'txt_pass', 'txt_date', 'txt_time', 'txt_si', 'txt_no', 'txt_promociones', 'txt_fecha_entrega', 'txt_programmed', 'txt_just_now', 'txt_ready', 'txt_delivered', 'txt_message_pedido_ok', 'txt_message_no_datos', 'txt_message_selec_horario', 'txt_message_ingresar_contrasena', 'txt_message_eliminar_pedido', 'txt_no_vailable', 'txt_finalized', 'txt_domingo', 'txt_lunes', 'txt_martes', 'txt_miercoles', 'txt_jueves', 'txt_viernes', 'txt_sabado', 'txt_horario_disponible', 'txt_message_no_horario', 'txt_username','txt_datos_invalidos','txt_token_invalido');

        $data = array(
            //data person
            "sufijo" =>  Input::get("sufijo"), 
            "language" =>  Input::get("language"),            
            "flag"     =>  Input::file("flag"),
        );

        foreach ($txts as $txt) {
           $data[$txt] = Input::get($txt);
        }


    
        $rules = array(
            "sufijo" => "required",
            "language" => "required",
            "flag" =>  'mimes:jpeg,gif,png'
        );
        foreach ($txts as $txt) {
           $rules[$txt] = "required";
        }
        
        $messages = array();
         
         $validation = Validator::make(Input::all(), $rules, $messages);
            //si la validación falla redirigimos al formulario de registro con los errores
            //y con los campos que nos habia llenado el usuario
        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }else{
            $lang = Language::find($id);
            $lang->sufijo = Input::get("sufijo");
            $lang->language = Input::get("language");
            if(Input::get("state")==1)
                $lang->state   = 1;
            else
                $lang->state   = 0;

            if(Input::file('flag')!=NULL)
            {
                //agrega imagen de flag
                $file_flag=Input::file('flag');
                $ext = Input::file('flag')->getClientOriginalExtension();
                $nameIMG=date('YmdHis');
                $flag=$nameIMG.'.'.$ext;
                $flag= url().'/assets/img/flags/PIC'.$flag;
                $lang->flag = $flag;
            }

            $lang->txt_hotel = Input::get('txt_hotel');
            $lang->txt_direccion = Input::get('txt_direccion');
            $lang->txt_catalogo = Input::get('txt_catalogo');
            $lang->txt_delayed = Input::get('txt_delayed');
            $lang->txt_categoria = Input::get('txt_categoria');
            $lang->txt_habitacion = Input::get('txt_habitacion');
            $lang->txt_descripcion = Input::get('txt_descripcion');
            $lang->txt_total = Input::get('txt_total');
            $lang->txt_tiempo = Input::get('txt_tiempo');
            $lang->txt_inicio = Input::get('txt_inicio');
            $lang->txt_enviar_pedido = Input::get('txt_enviar_pedido');
            $lang->txt_horario_de_entrega = Input::get('txt_horario_de_entrega');
            $lang->txt_entrega_inmediata = Input::get('txt_entrega_inmediata');
            $lang->txt_entrega_programa = Input::get('txt_entrega_programa');
            $lang->txt_cancelar_pedido = Input::get('txt_cancelar_pedido');
            $lang->txt_carrito_compra = Input::get('txt_carrito_compra');
            $lang->txt_pedido_inmediato = Input::get('txt_pedido_inmediato');
            $lang->txt_pedido_programado = Input::get('txt_pedido_programado');
            $lang->txt_continuar_comprando = Input::get('txt_continuar_comprando');
            $lang->txt_telefonos = Input::get('txt_telefonos');
            $lang->txt_lenguajes = Input::get('txt_lenguajes');
            $lang->txt_enviar = Input::get('txt_enviar');
            $lang->txt_aceptar = Input::get('txt_aceptar');
            $lang->txt_order = Input::get('txt_order');
            $lang->txt_orders = Input::get('txt_orders');
            $lang->txt_estado = Input::get('txt_estado');
            $lang->txt_pass = Input::get('txt_pass');
            $lang->txt_date = Input::get('txt_date');
            $lang->txt_time = Input::get('txt_time');
            $lang->txt_si = Input::get('txt_si');
            $lang->txt_no = Input::get('txt_no');
            $lang->txt_promociones = Input::get('txt_promociones');
            $lang->txt_fecha_entrega = Input::get('txt_fecha_entrega');
            $lang->txt_programmed = Input::get('txt_programmed');
            $lang->txt_just_now = Input::get('txt_just_now');
            $lang->txt_ready = Input::get('txt_ready');
            $lang->txt_delivered = Input::get('txt_delivered');
            $lang->txt_message_pedido_ok = Input::get('txt_message_pedido_ok');
            $lang->txt_message_no_datos = Input::get('txt_message_no_datos');
            $lang->txt_message_selec_horario = Input::get('txt_message_selec_horario');
            $lang->txt_message_ingresar_contrasena = Input::get('txt_message_ingresar_contrasena');
            $lang->txt_message_eliminar_pedido = Input::get('txt_message_eliminar_pedido');
            $lang->txt_no_vailable = Input::get('txt_no_vailable');
            $lang->txt_finalized = Input::get('txt_finalized');
            $lang->txt_domingo = Input::get('txt_domingo');
            $lang->txt_lunes = Input::get('txt_lunes');
            $lang->txt_martes = Input::get('txt_martes');
            $lang->txt_miercoles = Input::get('txt_miercoles');
            $lang->txt_jueves = Input::get('txt_jueves');
            $lang->txt_viernes = Input::get('txt_viernes');
            $lang->txt_sabado = Input::get('txt_sabado');
            $lang->txt_horario_disponible = Input::get('txt_horario_disponible');
            $lang->txt_message_no_horario = Input::get('txt_message_no_horario');
            $lang->txt_username = Input::get('txt_username');
            $lang->txt_datos_invalidos = Input::get('txt_datos_invalidos');
            $lang->txt_token_invalido = Input::get('txt_token_invalido');

            if($lang->save()){

                if(Input::file('flag')!=NULL)
                {
                    $file_flag->move("assets/img/flags/",$flag); 
                }

               return Redirect::to('admin/languages')->with('flash_message', 'Agregado con exito'); 
           }else{
               return Redirect::back()->withError("Error");
           }
        }

    }

    public function destroy($id)
    {
      $plan = Language::find($id);
      if($plan){
      	$plan->delete();
        return Redirect::back()->withConfirm("Eliminado Exitosamente");
      }else{
        return Redirect::back()->withErrors("Error");
      }
    }
}