<?php
class Category_menu extends Eloquent {

	protected $table = 'category_menu';
	public $timestamps = true;

	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$category = Category_menu::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = Name_category_menu::where('language_id', $lang->language_id)->where('category_menu_id', $category->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }
}