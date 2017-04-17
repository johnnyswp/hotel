<?php
use Carbon\Carbon;

$lang_c=Cookie::get('language');       
$l = (is_null($lang_c)) ? Config::get('app.locale') : Cookie::get('language');
App::setLocale($l);

Route::get('hidd', function(){
$path = app_path();
 // Abrir el archivo
$archivo = $path.'/config/app.php';
$abrir = fopen($archivo,'r+');
$contenido = fread($abrir,filesize($archivo));
fclose($abrir);
// Separar linea por linea
$contenido = explode("\n",$contenido);
// Modificar linea deseada ( 2 ) 
$contenido[6] = "    'languages' => array('es','en','pt','jh','arroz'),";
// Unir archivo
$contenido = implode("\n",$contenido);
// Guardar Archivo
$abrir = fopen($archivo,'w');
fwrite($abrir,$contenido);
fclose($abrir);
});

Route::get('text', function()
{
    $lang_new = Language::find(2)->sufijo;
    $lang_now = Config::get('app.locale');    
    App::setLocale($lang_new); 
    echo trans('main.dear')."<br>";
    
    App::setLocale($lang_now); 
    echo trans('main.dear')."<br>";


    /*
    return   hash('sha256','3DE4SS');  
    

        0 = recep y cocina
        1 = recep
        2 = cocina
        3 = admin Hotel

        $user = Sentry::getUser();

        #Verficiar si la fecha y hora que eligio esta la habitacion ocupada o no.
        $opening_date = Input::get('date');
        $stay_exs = Stay::where('hotel_id',$user->hotel_id)->get();
        foreach ($stay_exs as $s) {
            $date_star = Carbon::parse($s->opening_date);
            $date_end = Carbon::parse($s->closing_date);
            if(Carbon::parse($opening_date)->between($date_star, $date_end)){
                return "true";
            }
        }*/
});

Route::get('lang', function ()
{   
    $lang = Input::get('lang');
    Cookie::forever('language',$lang); 
    App::setLocale($lang); 
    Session::put('language', $lang);
    return Redirect::back();
});

Route::get('/truncate',function()
{   
    DB::table('users')->truncate();
    DB::table('users_groups')->truncate();
    DB::table('user_payment')->truncate();
    DB::table('payment')->truncate();
    DB::table('payment_sms')->truncate();
    DB::table('user_payment_sms')->truncate();
    DB::table('available')->truncate();
    DB::table('category_menu')->truncate();
    DB::table('hotels')->truncate();
    DB::table('items_name')->truncate();
    DB::table('items_order')->truncate();
    DB::table('languages_hotel')->truncate();
    DB::table('names_category_menu')->truncate();
    DB::table('name_items_menu')->truncate();
    DB::table('name_phones')->truncate();
    DB::table('orders')->truncate();
    DB::table('payment')->truncate();
    DB::table('payment_sms')->truncate();
    DB::table('phones')->truncate();
    DB::table('rooms')->truncate();
    DB::table('rooms_sectors')->truncate();
    DB::table('schedules')->truncate();
    DB::table('stays')->truncate();
    DB::table('users')->truncate();
    DB::table('users_groups')->truncate();
    DB::table('user_payment')->truncate();
    DB::table('user_payment_sms')->truncate();
    DB::table('user_payment_sms')->truncate();

    $user = Sentry::register(array(
        'email'    => 'admin@skywebplus.com',
        'password' => '123456',
        'first_name' => 'Admin',
        'last_name' => 'Admin',
        'username'  => 'admin',
        'activated'       =>1
    ));
    $usersGroup = Sentry::findGroupByName('Admins');
    $user->addGroup($usersGroup);
    
    return Redirect::to('/');
});
# CSRF Protection
Route::when('admin/*', 'csrf', ['POST', 'PUT', 'PATCH', 'DELETE']);
/*
    Route::group(['domain' => 'cocina.hotel.dev'], function() {Route::get('/', function() {return "Coinada Idnex"; }); });
    Route::group(['domain' => 'recepcion.hotel.dev'], function() {Route::get('/', function() {return "Recepcion Idnex"; }); });
    Route::group(['domain' => 'huesped.hotel.dev'], function() {Route::get('/', function() {return "Huesped Idnex"; }); });
*/

Route::any('change-pass', 'BaseController@getChangePass');
Route::get('/filter-provinces', ['as' => 'province', 'uses' => 'BaseController@FilterProvince']);
Route::get('/filter-citys', ['as' => 'city', 'uses' => 'BaseController@FilterCity']);



Route::group(['prefix'=>'/','before' => 'guest'], function()
{
    Route::get('register/{code}', 'RegistrationController@create');
    Route::get('register-finish', 'RegistrationController@finish');
    Route::get('activate/{id}/{token}', 'RegistrationController@activate');

    Route::post('forgot_password','RemindersController@postRemind');    
    Route::post('register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
    Route::post('reset_password/{token}', 'RemindersController@postReset');

    Route::get('forgot_password', 'RemindersController@getRemind');
    Route::get('reset_password/{token}', 'RemindersController@getReset');
        
    Route::resource('sessions', 'SessionsController' , ['only' => ['create','store','destroy']]);


        Route::get('/', ['as' => 'home', 'uses' => 'SessionsController@create']);


    

    #Logout Route
});

# Standard User Routes
Route::group(['prefix'=>'hotel','before' => 'auth|hotels'], function(){
    /*-----------------------------------Payment----------------------------------------*/
    Route::get('payment/history', 'PaymentsController@getHotelHistory');
    Route::get('payment/change', 'PaymentsController@getChange');

    Route::post('payment-chance', array('as' => 'payment','uses' => 'PaymentsController@postChancePayment'));
    Route::post('payment', array('as' => 'payment','uses' => 'PaymentsController@postPayment'));
    Route::get('payment/plans', 'PaymentsController@getPlans');

    // this is after make the payment, PayPal redirect back to your site
    Route::get('payment/status', array('as' => 'payment.status', 'uses' => 'PaymentsController@getPaymentStatus'));
    /////////////////////////////payment sms //////////////////////////////////////
    Route::get('payment/sms/history', 'PaymentsSmsController@getHistory');
    Route::get('payment/sms/plans', 'PaymentsSmsController@getPlans');
    Route::post('payment/sms', array('as' => 'payment','uses' => 'PaymentsSmsController@postPayment'));
    Route::get('payment/sms/status', array('as' => 'hotel.sms.payment.status', 'uses' => 'PaymentsSmsController@getPaymentStatus'));

    Route::resource('menu','HotelMenuController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('category','HotelCategoryController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('services','HotelServicesController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('business','HotelBusinessController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('activity','HotelActivityController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('business/menu','HotelBusinessMenusController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('users','HotelUsersController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('sectors','HotelSectorsController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('rooms','HotelRoomsController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('phones','HotelPhonesController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::resource('promotions','HotelPromoController', ['only' => ['index','create','store','edit','update','destroy']]);
    Route::controller('/', 'HotelController');
    Route::controller('page', 'HotelPagesController');

});

# Company Routes
Route::group(['prefix'=>'chef','before' => 'auth|chefs'], function()
{
    Route::controller('/', 'ChefController');
    #Route::controller('page', 'ChefPagesController');
});

Route::group(['prefix'=>'receptionist','before' => 'auth|receptionists'], function()
{
    #Route::controller('/',  'ReceptionistController');
    Route::get('/', 'ReceptionistController@getIndex');
    Route::controller('/', 'ReceptionistController');
});

Route::controller('save', 'ReceptionistSaveController');

# Standard User Routes
# Route::group(['prefix'=>'roomers','before' => 'auth|roomers'], function() {});

Route::controller('roomer', 'RoomerController');

# Solo Admin
Route::group(['prefix' => '/admin','before' => 'auth|admin'], function()
{
    Route::get('/', ['as' => 'admin_dashboard', 'uses' => 'AdminController@getHome']);
    Route::resource('/hotels', 'AdminHotelController', ['only' => ['index', 'show','create','store']]);
    Route::resource('planes', 'AdminPlanController', ['only' => ['index', 'show','create','store','edit','update','destroy']]);
    Route::resource('paquetes-sms', 'AdminPaketSmsController');
    Route::resource('languages', 'AdminLanguagesController');
    Route::resource('exchanges', 'AdminPrasesController');
    Route::resource('phrases-languages', 'AdminPhrasesLanguagesController');

    Route::get('hotel-sms/save', 'AdminPlansController@getSms');
    Route::get('hotel-plan/save', 'AdminPlansController@getPlan');
    Route::get('hotel/{id}/history-payment-sms', 'AdminPlansController@getHistory');
    Route::get('hotel/{id}/history-payment-plan', 'AdminPlansController@getHistoryPlan');
    Route::get('configuration', 'AdminController@getConfig');
    Route::get('configuration/{id}/edit', 'AdminController@getConfigEdit');
    Route::post('configuration/{id}/update', 'AdminController@postConfigUpdate');
    
    Route::get('confirmation-payment', 'AdminController@getComfirmationPayment');
    Route::get('refills-confirmation-payment/{id}/save', 'AdminController@getComfirmationPaymentSave');

    Route::get('refills-confirmation-sms', 'AdminController@getComfirmationSms');
    Route::get('refills-confirmation-sms/{id}/save', 'AdminController@getComfirmationSmsSave');
    Route::get('refills-confirmation-sms/all-save', 'AdminController@getComfirmationSmsAllSave');
    Route::resource('profiles', 'AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('/send', ['as' => 'admin_send', 'uses' => 'GcmController@send']);
});

Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
