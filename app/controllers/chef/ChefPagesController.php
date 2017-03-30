<?php

class ChefPagesController extends \BaseController {

	public function getIndex()
	{
		return View::make('chef.pages.index');
	}

	public function getPedidos()
	{
		return View::make('chef.pages.pedidos');
	}

	public function getEditarPedido()
	{
		return View::make('chef.pages.editar_pedido');
	}

	public function getEstadias()
	{
		return View::make('chef.pages.estadias_actuales');
	}


}

?>