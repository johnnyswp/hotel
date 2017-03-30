<?php

class PagesController extends \BaseController {


	public function getHome()
	{
		return View::make('frontend.pages.home');
	}

	public function getAbout()
	{
		return View::make('frontend.pages.about');
	}

	public function getContact()
	{
		return View::make('frontend.pages.contact');
	}


}