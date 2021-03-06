<?php
class CategoryInfo extends Eloquent {
	protected $table = 'categoryinfoplace';
	public $timestamps = true;
	public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$category = CategoryInfo::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = CategoryInfoLang::where('language_id', $lang->language_id)->where('category_id', $category->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }
        return true;
    }
}