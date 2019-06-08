<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Products;
use App\User;
use App\Types;
use App\Brands;
use App\Mail\OrderPlaced;

class PageController extends Controller
{

	public function testGet()
	{
		Mail::to("chuanfrost98@gmail.com")->send(new OrderPlaced);
		return response()->json("sent");
	}

	public function testPost(Request $request)
	{

		return response()->json(['Status' => 'Success', 'Data' => [['brand' => 'hi'], ['brand' => 'lol']]]);
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
		$types = Types::all();
		$brands = Brands::all();

		return view('Admin/ProductManager', ['products' => $products, 'types' => $types, 'brands' => $brands]);
	}

	public function showAccount()
	{
		return view('Admin/AccountPage', [ 'Data' => User::all()]);
	}

	public function showLogin()
	{

		if(Auth::check())
		{
			return view('Admin/HomePage');
		}
		else
		{
			return view('Admin/LoginPage');
		}
	}

	public function showOrderManager()
	{
		return view('Admin/OrderManager');
	}

	public function showHome()
	{
		return view ('Admin/HomePage');
	}
}
