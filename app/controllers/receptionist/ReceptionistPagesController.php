<?php

class ReceptionistPagesController extends \BaseController {


	public function getIndex()
	{
		return View::make('receptionists.pages.index');
	}

	public function getAcceso()
	{
		return View::make('receptionists.pages.acceso'); 
	}

	public function getDetalle()
	{
		return View::make('receptionists.pages.detalle');
	}

	public function getCarrito()
	{
		return View::make('receptionists.pages.carrito');
	}

	public function getMenuTelefono()
	{
		return View::make('receptionists.pages.menu_telefono');
	}

	public function getEstadoPedido()
	{
		return View::make('receptionists.pages.estado_pedido');
	}

	public function getDetallePedido()
	{
		return View::make('receptionists.pages.detalle_pedido');
	}

	public function getMenu()
	{
		return View::make('receptionists.pages.menu');
	}

	public function getVisualizarPromocion()
	{
		return View::make('receptionists.pages.visualizar_promocion');
	}
}


?>