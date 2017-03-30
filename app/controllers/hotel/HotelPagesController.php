<?php

class HotelPagesController extends \BaseController {


	public function getIndex()
	{
		$user = User::find(Sentry::getUser()->id);
		return View::make('hotel.pages.index')->withUser($user);
	}

	public function getAltaAdmin(){
		return View::make('hotel.pages.alta_admin');
	}

	public function getEditAdmin(){
		return View::make('hotel.pages.edit_admin');
	}

	public function getEditHotel(){
		return View::make('hotel.pages.edit_hotel');
	}

	public function getSelectLang(){
		return View::make('hotel.pages.select_language');
	}

	public function getPhones(){
		return View::make('hotel.pages.phones');
	}

	public function getAltaPhone(){
		return View::make('hotel.pages.alta_phone');
	}

	public function getCategorias(){
		return View::make('hotel.pages.categorias');
	}

	public function getAltaCategoria(){
		return View::make('hotel.pages.alta_categoria');
	}

	public function getEditCategoria(){
		return View::make('hotel.pages.edit_categoria');
	}

	public function getElementos(){
		return View::make('hotel.pages.elementos_menu');
	}

	public function getAltaMenu(){
		return View::make('hotel.pages.alta_menu');
	}

	public function getEditMenu(){
		return View::make('hotel.pages.edit_menu');
	}

	public function getPromociones()
	{
		return View::make('hotel.pages.promociones');
	}

	public function getNuevaPromocion()
	{
		return View::make('hotel.pages.nueva_promocion');
	}

	public function getRankingProductos()
	{
		return View::make('hotel.pages.ranking_productos');
	}

	public function getUsuarios()
	{
		return View::make('hotel.pages.usuarios');
	}

	public function getAltaUsuario()
	{
		return View::make('hotel.pages.alta_usuario');
	}

	public function getEditUsuario()
	{
		return View::make('hotel.pages.edit_usuario');
	}

}
?>