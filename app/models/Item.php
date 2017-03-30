<?php
class Item extends Eloquent {

	protected $table = 'items_name';
	public $timestamps = true;

    public static function state($id)
    {
    	$hotel = Hotel::where('user_id', Sentry::getUser()->id)->first();
    	$item = Item::find($id);
        $langs = LanguageHotel::where('state', 1)->where('hotel_id', $hotel->id)->get();
        foreach($langs as $lang){
        	$name = NameItem::where('language_id', $lang->language_id)->where('item_id', $item->id)->first();
        	if(!$name)
        		return false;
        	if($name->name=="")
        		return false;
        }

        return true;
    }

    public function category()
    {
        return $this->belongsTo('Category_menu');
    }
}