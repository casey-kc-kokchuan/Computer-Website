<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Products;

class PageController extends Controller
{

	public function testGet()
	{
		return view("Shared/Test");
	}

	public function testPost(Request $request)
	{
		return response()->json($request->all());
	}

	public function showShoppingCart()
	{
		$products = Products::all();
		$types = Products::select('type')->orderBy('type','asc')->distinct()->get();
		$brands = Products::select('brand')->orderBy('brand','asc')->distinct()->get();

		return view('Customer/ShoppingCart', ['products' => $products, 'types' => $types, 'brands' => $brands]);
	}

	public function showProductManager()
	{
		$products = Products::all();
		$types = Products::select('type')->orderBy('type','asc')->distinct()->get();
		$brands = Products::select('brand')->orderBy('brand','asc')->distinct()->get();

		return view('Admin/ProductManager', ['products' => $products, 'types' => $types, 'brands' => $brands]);
	}

	public function showAccount()
	{
		return view('Admin/AccountPage');
	}

	public function showLogin()
	{
		return view('Admin/LoginPage');
	}
}
