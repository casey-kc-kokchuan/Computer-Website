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
use App\Orders;


class PageController extends Controller
{

	public function testGet()
	{
		$order = Orders::all();
		$array_list1 = [];
		$array_list2 = [];

		foreach ($order as $orders)
		{

		    $orderlist = Orders::find($orders->id)->orderlist;

		    foreach ($orderlist as $orderlists)
		    {

		        $name = $orderlists->name;

		         $list2 = [
		            'orders_id' => $orderlists->orders_id,
		            'name' => $orderlists->name,
		            'type' => $orderlists->type,
		            'brand' => $orderlists->brand,
		            'price' => $orderlists->price,
		            'qty' => $orderlists->qty,
		            ];

		        array_push($array_list2, $list2);

		    }
		    
		    $list1 = [
		            'id' => $orders->id,
		            'name' => $orders->name,
		            'email' => $orders->email,
		            'contact' => $orders->contact,
		            'address' => $orders->address,
		            'total_price' => $orders->total_price,
		            'user' => $orders->user,
		            'status' => $orders->status,
		            'orderlist' => $array_list2,
		            ];

		    $array_list2 = [];

		    array_push($array_list1, $list1);
		}
		return response()->json($array_list1);
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
			return redirect('Admin/OrderManager');
		}
		else
		{
			return view('Admin/LoginPage');
		}
	}

    public function showChangePasswordRequest()
    {
        if(Auth::check())
        {
        	return view('Admin/OrderManager');
        }
        else
        {
        	return view('Admin/ChangePasswordRequest');
        }
    }

	public function showOrderManager()
	{
		$order = Orders::all();
		$array_list1 = [];
		$array_list2 = [];

		foreach ($order as $orders)
		{

		    $orderlist = Orders::find($orders->id)->orderlist;

		    foreach ($orderlist as $orderlists)
		    {

		        $name = $orderlists->name;

		         $list2 = [
		            'orders_id' => $orderlists->orders_id,
		            'product_id' => $orderlists->product_id,
		            'name' => $orderlists->name,
		            'type' => $orderlists->type,
		            'brand' => $orderlists->brand,
		            'price' => $orderlists->price,
		            'qty' => $orderlists->qty
		            ];

		        array_push($array_list2, $list2);

		    }
		    
		    $list1 = [
		            'id' => $orders->id,
		            'name' => $orders->name,
		            'email' => $orders->email,
		            'contact' => $orders->contact,
		            'address' => $orders->address,
		            'total_price' => $orders->total_price,
		            'user' => $orders->user,
		            'status' => $orders->status,
		            'orderlist' => $array_list2,
		            ];

		    $array_list2 = [];

		    array_push($array_list1, $list1);
		}
		return view('Admin/OrderManager', ['Data' => $array_list1]);
	}

	public function showHome()
	{
		return view ('Admin/HomePage');
	}

	public function showVerifyOrderEmail()
	{
		return view('Customer/VerifyOrderEmail');
	}


}
