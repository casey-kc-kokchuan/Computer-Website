<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Products;
use \Illuminate\Database\QueryException;
use App\Types;
use App\Brands;
use App\Orders;
use App\OrderList;

class OrderController extends Controller
{
    public function PlaceOrder(Request $request)
    {   

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'email' => 'email',
        //     'contact' => 'required|regex:/(01)[0-9]{8,9}/',
        //     'address' => 'required',

        // ]);

        // if($validator->fails())
        // {
        //     return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        // }

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

        if ($all_exceed != null)
        {
            return response()->json(['Status' => "Quantity Error", "Message" => $all_exceed]);
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
                
            } catch (Exception $e) {
                
                return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]); 
            }

        }
        

        return response()->json(['Status' => "Success"]);

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
