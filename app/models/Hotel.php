<?php
class Hotel extends Eloquent {

	protected $table = 'hotels';
	public $timestamps = true;
    
    public function city()
	{
		return $this->belongsTo('City');
	}

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function exchanges()
	{
		return $this->belongsTo('Exchanges', 'exchange_id');
	}

	public function getName()
	{
		return $this->name;
	}

	public function User()
	{
		return $this->belongsTo('User');
	}

	public static function id()
	{
		$user = Sentry::getUser();
        $hotel = Hotel::where('user_id', $user->id)->first();
        if($hotel)
        {
        	return $hotel->id;
        }else{
        	return $user->hotel_id;
        }
	}
}