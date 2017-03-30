<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| El following language lines contain El default error messages used by
	| El validator class. Some of Else rules have multiple versions such
	| such as El size rules. Feel free to tweak each of Else messages.
	|
	*/

	"accepted"         => "El :attribute debe ser aceptado.",
	"active_url"       => "El :attribute no es una URL valida.",
	"after"            => "El :attribute debe ser después de :date.",
	"alpha"            => "El :attribute solo puede contener letras.",
	"alpha_dash"       => "El :attribute solo puede contener letras, números o -.",
	"alpha_num"        => "El :attribute solo puede contener letras y números.",
	"array"            => "El :attribute debe ser un arreglo.",
	"before"           => "El :attribute debe ser antes de :date.",
	"between"          => array(
		"numeric" => "El :attribute debe ser entre :min - :max.",
		"file"    => "El :attribute debe ser entre :min - :max kilobytes.",
		"string"  => "El :attribute debe ser entre :min - :max caracteres.",
		"array"   => "El :attribute must have entre :min - :max elementos.",
	),
	"confirmed"        => "El :attribute confirmación no es igual.",
	"date"             => "El :attribute no es una fecha validad.",
	"date_format"      => "El :attribute no es igual al formato :format.",
	"different"        => "El :attribute y :oElr debe ser diferente.",
	"digits"           => "El :attribute debe ser :digits digitos.",
	"digits_between"   => "El :attribute debe ser entre :min y :max digitos.",
	"email"            => "El :attribute tiene un formato invalido.",
	"exists"           => "El selected :attribute es invalido.",
	"image"            => "El :attribute debe ser una imagen.",
	"in"               => "El selected :attribute es invalido.",
	"integer"          => "El :attribute debe ser un entero.",
	"ip"               => "El :attribute debe ser a valid IP address.",
	"max"              => array(
		"numeric" => "El :attribute no debe ser mayor que :max.",
		"file"    => "El :attribute no debe ser mayor que :max kilobytes.",
		"string"  => "El :attribute no debe ser mayor que :max caracteres.",
		"array"   => "El :attribute no puede tener más de :max elementos.",
	),
	"mimes"            => "El :attribute debe ser un archivo type: :values.",
	"min"              => array(
		"numeric" => "El :attribute debe ser al menos :min.",
		"file"    => "El :attribute debe ser al menos :min kilobytes.",
		"string"  => "El :attribute debe ser al menos :min caracteres.",
		"array"   => "El :attribute debe tener al menos :min elementos.",
	),
	"not_in"           => "El selected :attribute es invalido.",
	"numeric"          => "El :attribute debe ser un número.",
	"regex"            => "El :attribute tiene un formato invalido.",
	"required"         => "El :attribute es requerido.",
	"required_if"      => "El :attribute es requerido cuando :oElr es :value.",
	"required_with"    => "El :attribute es requerido cuando :values está presente.",
	"required_without" => "El :attribute es requerido cuando :values no está presente.",
	"same"             => "El :attribute y :oElr deben ser iguales.",
	"size"             => array(
		"numeric" => "El :attribute debe ser :size.",
		"file"    => "El :attribute debe ser :size kilobytes.",
		"string"  => "El :attribute debe ser :size caracteres.",
		"array"   => "El :attribute debe contener :size elementos.",
	),
	"unique"           => "El :attribute esta actualmente tomado.",
	"url"              => "El :attribute tiene un formato invalido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using El
	| convention "attribute.rule" to name El lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/
    'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'item'          => 'producto',
		'quantity'      => 'cantida',
		'category'      => 'categoria',
		'state'         => 'estado',
		'picture'       => 'imagen',
		"name"          => 'nombre',
		"country_id"    => 'pais',
		"city"          => 'ciudad',
		"address"       => 'dirección',
		"web"           => 'sitio web',
		"theme"         => 'tema',
		"language_id"   => 'idioma',
		"exchange_id"   => 'divisa',
		"list_times_as" => 'lista de horarios segun',
		"limit_time"    => 'hora limite',
		"logo"          => 'logo',
		"first_name"    => 'nombre',
		"last_name"     => 'apellido',
		"email"         => 'correo electronico',
		"phone"         => 'telefono',
		'lang'          => 'idioma',
		'category_id'   => 'categoria',
		'price'         => 'precio',
		'delivery_time' => 'tiempo de envio',
		'number'        => 'numero',
		'sector_id'     => 'sector',
		'desde'         => 'desde',
		'hasta'         => 'hasta',
		'type'          => 'tipo',
		'type_user'     => 'tipo de usuario',
		'nombre'        => 'nombre',				
		'contrasena'    => 'contraseña',
		'habitacion'    => 'habitacion',
		'entrada_dia'   => 'dia de entrada',
		'entrada_hora'  => 'hora de entrada',
		'salida_dia'    => 'dia de salida',
		'salida_hora'   => 'hora de salida',					
		'idioma'        => 'idioma',
		'telefono'      => 'telefono',
		'token'         => 'token',
		'room_id'       => 'room',
		'opening_date'  => 'fecha de inicio',
		'start'         => 'inicio',
		'closing_date'  => 'fecha de cierre',
		'end'           => 'fin',
		'report_email'  => 'informar check in por email',
		'report_sms'    => 'informar check in por sms',
		'habitacion'    => 'habitacion',
               'infoemail'     => 'correo electronico publico',
		''              => '',
		''              => '',
		''              => '',
		''              => '',
		''              => '',
		),

);