<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Products;

class PageController extends Controller
{

	public function showShoppingCart()
	{
		$products = Products::all();
		$types = Products::select('type')->orderBy('type','asc')->distinct()->get();

		return view('Customer/ShoppingCart', ['products' => $products, 'types' => $types]);
	}

	public function showProductManager()
	{
		$products = Products::all();
		$types = Products::select('type')->orderBy('type','asc')->distinct()->get();

		return view('Admin/ProductManager', ['products' => $products, 'types' => $types]);
	}
}
