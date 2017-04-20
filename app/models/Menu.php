<?php
class Menu extends Eloquent {

	protected $table = 'menus';
	public $timestamps = true;

	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$menu = Menu::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$menuLang = MenuLang::where('language_id', $lang->language_id)->where('menu_id', $menu->id)->first();
        	if(!$menuLang)
        		return false;
        	if($menuLang->name=="")
        		return false;
        }
        return true;
    }
}