<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function FilterProvince()
    {   $country_id = Input::get("code");
        $provinces =  Province::where('country_id', $country_id)->get();
        foreach($provinces as $province)
        {
            echo "<option value='".$province->id."'>".$province->name."</option>";
        }
    }

    public function FilterCity()
    {   $province_id = Input::get("code");
        $citys =  City::where('province_id', $province_id)->get();
        foreach($citys as $city)
        {
            echo "<option value='".$city->id."'>".$city->name."</option>";
        }
    }

    public function getChangePass()
    {
        $id = Input::get('pk');
        $pass = Input::get('value');
        $user = User::find($id);
        $user->password = $pass;
        if($user->save())
        {
            return "ok";
        }else{
            return "no";
        }
    }
}
