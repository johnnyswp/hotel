<?php
class LanguageHotel extends Eloquent {

	protected $table = 'languages_hotel';
	public $timestamps = true;

	public function language()
	{
		return $this->belongsTo('Language');
	}

	public static function langstate($id)
	{
		$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
        $lang = LanguageHotel::where('id', $id)->where('hotel_id', $hotel->id)->first();

		$categories = Category_menu::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach ($categories as $category){
             $name = Name_category_menu::where('category_menu_id', $category->id)->where('language_id', $lang->language_id)->first();
             if(!$name)
                 return  false;
             if($name->name=="")
                 return  false;
        }

        $menus = Item::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach ($menus as $menu){
             $name = NameItem::where('item_id', $menu->id)->where('language_id', $lang->language_id)->first();
             if(!$name)
                 return  false;
             if($name->name=="")
                 return  false;
        }

        $phones = Phone::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach ($phones as $phone){
             $name = NamePhone::where('phone_id', $phone->id)->where('language_id', $lang->language_id)->first();
             if(!$name)
                 return  false;
             if($name->name=="")
                 return  false;
        }

        return  true;
	}

}