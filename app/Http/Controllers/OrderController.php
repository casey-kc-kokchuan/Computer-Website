<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Products;
use App\Types;
use App\Brands;
use App\Orders;
use App\OrderList;
use App\Mail\OrderPlaced;
use App\Mail\OrderConfirmed;



class OrderController extends Controller
{
    public function PlaceOrder(Request $request)
    {   

        $searchType = empty($request->searchType)? "": $request->searchType;
        $searchName = empty($request->searchName)? "": $request->searchName;
        $searchBrand = empty($request->searchBrand)? "": $request->searchBrand;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email',
            'contact' => 'required|regex:/(01)[0-9]{8,9}/',
            'address' => 'required',

        ]);

        if($validator->fails())
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        }

        $document = $request->cart;
        $all_exceed = [] ;
        foreach($document as $check){

            $purchase_id = $check['id'];
            $purchase_qty = $check['qty'];

            $stock_qty = DB::table('products')
                        ->select('qty')
                        ->where('id', $purchase_id)
                        ->get();

            foreach($stock_qty as $stock_qty1){
                $qty = $stock_qty1->qty;
            }

            if ($qty == 0 || $qty < $purchase_qty){

                $exceed = [
                    'id' => $purchase_id,
                    'qty' => $qty,
                ];

                array_push($all_exceed, $exceed); 
            }         
        }


        $token = md5(rand(1, 10).microtime());
        if ($all_exceed != null)
        {   
            $searchProduct = Products::where('name', 'LIKE', '%'.$searchName.'%')
                                ->where('type', 'LIKE', '%'.$searchType.'%')
                                ->where('brand', 'LIKE', '%'.$searchBrand.'%')
                                ->get();
            return response()->json(['Status' => "Quantity Error", "Message" => $all_exceed, "Data" => $searchProduct]);
        }
        else
        {

            //insert into orders database
            try
            {
                $order = new Orders();
                $order->name = $request->name;
                $order->email = $request->email;
                $order->contact = $request->contact;
                $order->address = $request->address;
                $order->total_price = $request->total_price;
                $order->email_token = $token;
                $order->status = "Pending Confirmation";
                $order->save();
                $id = $order->id;
            }
            catch (QueryException $e) 
            {
                return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
            }


            //insert into order_list database
            try 
            {
                foreach($document as $data){ 
                    $orderlist = new OrderList();
                    $orderlist->orders_id = $id;
                    $orderlist->product_id = $data['id'];
                    $orderlist->name = $data['name'];
                    $orderlist->type = $data['type'];
                    $orderlist->brand = $data['brand'];
                    $orderlist->price = $data['price'];
                    $orderlist->qty = $data['qty'];
                    $orderlist->save();
                    $product_id = $data['id'];
                    $order_qty = $data['qty'];
                    $products = Products::find($product_id);
                    $product_qty = $products->qty;
                    $new_qty = $product_qty - $order_qty;
                    $products->qty = $new_qty;
                    $products->save();
                }
                
            } catch (QueryException $e) {
                
                return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]); 
            }

        }


        Mail::to($request->email)->send(new OrderPlaced($token, $id, $request->name));
        return response()->json(['Status' => "Success", 'Link' => url("/VerifyOrderEmail?id=$id")]);

    }

    public function ConfirmOrder(Request $request)
    { 


        $order = Orders::findOrFail($request->id);

        if($order->status != "Pending Confirmation")
        {
            abort(401); 
        }

        if($order->email_token != $request->email_token)
        {
            abort(403);
        }

        $orderlist = Orders::find($order->id)->orderlist;
        $array_list = [];
        foreach ($orderlist as $orderlists)
        {

            $name = $orderlists->name;

             $list = [
                'name' => $orderlists->name,
                'price' => $orderlists->price,
                'qty' => $orderlists->qty,
                ];

            array_push($array_list, $list);
        }

        $order->status = "Order Confirmed";
        $order->save() ;

        Mail::to($order->email)->send(new OrderConfirmed($order,$orderlist));

        return view('Customer/OrderConfirmed');
        
    }  

    public function UpdateOrderStatus(Request $request)
    {
        $list = $request->orderlist;
        $status = $request->status;
        try
        {
            $order = Orders::find($request->id);
            if($status == "Cancelled")
            {
                foreach($list as $item)
                {
                    $product = Products::find($item['product_id']);
                    $product->qty = $product->qty + $item['qty'];
                    $product->save();
                }
            }
            $order->status = $status;
            $order->save();

        }
        catch(QueryException $e)
        {
            return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
        }

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

        return response()->json(['Status' => 'Success', 'Data' =>$array_list1]);
    }

    public function ShowOrder()
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
                    'email' => $orderlists->email,
                    'contact' => $orderlists->contact,
                    'address' => $orderlists->address,
                    'total_price' => $orderlists->total_price,
                    'user' => $orderlists->user,
                    'status' => $orderlists->status,
                    'orderlist' => $array_list2,
                    ];

            $array_list2 = [];

            array_push($array_list1, $list1);
        }

        return $array_list1; 
    }



}
