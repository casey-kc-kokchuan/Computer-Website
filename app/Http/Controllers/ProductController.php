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

class ProductController extends Controller
{
    public function search(Request $request)
    {

        //default value to empty string if no value is passed in

        $type = empty($request->type)? "": $request->type;
        $name = empty($request->name)? "": $request->name;
        $brand = empty($request->brand)? "": $request->brand;

        $product = Products::where('name', 'LIKE', '%'.$name.'%')
                            ->where('type', 'LIKE', '%'.$type.'%')
                            ->where('brand', 'LIKE', '%'.$brand.'%')
                            ->get();

        return response()->json($product);
        //return response()->json($data);
    }

    public function AddProduct(Request $request)
    {

        $searchType = empty($request->searchType)? "": $request->searchType;
        $searchName = empty($request->searchName)? "": $request->searchName;
        $searchBrand = empty($request->searchBrand)? "": $request->searchBrand;

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'type' => 'required',
            'brand' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'qty' => 'required|integer|min:0',
            'img' => 'required|image',
            'imgDetail' => 'required|image',

        ]);

        if($validator->fails())
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        }

        try
        {
            $product = new Products();
            $product->name = $request->name;
            $product->type = $request->type;
            $product->brand = $request->brand;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->user = Auth::user()->username;
            $product->save();
            $id = $product->id;

        }catch (QueryException $e) 
        {
            return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
        }

        $db_name_1 = '/img/placeholder.png';
        $db_name_2 = '/img/placeholder.png';

        if($request->hasFile('img'))
        {
            $image = $request->img;
            $new_name_1 = $id.'_product'.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $new_name_1);
            $db_name_1 = '/img/'.$new_name_1;
        }
        if($request->hasFile('imgDetail'))
        {
            $imgDetail = $request->imgDetail;
            $new_name_2 = $id.'_detail'.'.'.$imgDetail->getClientOriginalExtension();
            $imgDetail->move(public_path('img'), $new_name_2);
            $db_name_2 = '/img/'.$new_name_2;
        }

        DB::table('products')
            ->where('id', $id)
            ->update(['img' => $db_name_1, 'imgDetail' => $db_name_2]);


        $searchProduct = Products::where('name', 'LIKE', '%'.$searchName.'%')
                            ->where('type', 'LIKE', '%'.$searchType.'%')
                            ->where('brand', 'LIKE', '%'.$searchBrand.'%')
                            ->get();


        return response()->json(['Status' => "Success","Data" => $searchProduct]);

    }

    public function EditProduct(Request $request)
    {
        $searchType = empty($request->searchType)? "": $request->searchType;
        $searchName = empty($request->searchName)? "": $request->searchName;
        $searchBrand = empty($request->searchBrand)? "": $request->searchBrand;
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'type' => 'required',
            'brand' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qty' => 'required|integer|min:0',

        ]);

        if($validator->fails())
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        }

        try
        {
            $product = Products::find($id);
            $product->name = $request->name;
            $product->type = $request->type;
            $product->brand = $request->brand;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->user = Auth::user()->username;
            $product->save();

        } catch (QueryException $e) {

            return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
        }

        if($request->hasFile('img'))
        {
            $image = $request->img;
            $new_name_1 = $id.'_product'.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $new_name_1);
            $db_name_1 = '/img/'.$new_name_1;

            DB::table('products')
                ->where('id', $id)
                ->update(['img' => $db_name_1]);
        }
        if($request->hasFile('imgDetail'))
        {
            $imgDetail = $request->imgDetail;
            $new_name_2 = $id.'_detail'.'.'.$imgDetail->getClientOriginalExtension();
            $imgDetail->move(public_path('img'), $new_name_2);
            $db_name_2 = '/img/'.$new_name_2;

            DB::table('products')
                ->where('id', $id)
                ->update(['imgDetail' => $db_name_2]);
        }

        $searchProduct = Products::where('name', 'LIKE', '%'.$searchName.'%')
                            ->where('type', 'LIKE', '%'.$searchType.'%')
                            ->where('brand', 'LIKE', '%'.$searchBrand.'%')
                            ->get();


        return response()->json(['Status' => "Success","Data" => $searchProduct]);

    }


    public function RemoveProduct(Request $request)
    {

        $searchType = empty($request->searchType)? "": $request->searchType;
        $searchName = empty($request->searchName)? "": $request->searchName;
        $searchBrand = empty($request->searchBrand)? "": $request->searchBrand;

        try {
            $id = $request->id;
            $product = Products::find($id);
            $product->delete();
        } catch (Exception $e) {
            return response()->json(['Status' => "Database Error"]);
        }


        $searchProduct = Products::where('name', 'LIKE', '%'.$searchName.'%')
                            ->where('type', 'LIKE', '%'.$searchType.'%')
                            ->where('brand', 'LIKE', '%'.$searchBrand.'%')
                            ->get();

        return response()->json(['Status' => "Success", "Data" => $searchProduct]);
        
    }


    public function AddType(Request $request)
    {

        $validator = Validator::make($request->all(), [
        'type' => 'required|unique:types|max:255',

        ]);


        if($validator->fails())
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        }

        try
        {

            $types = new Types();
            $types->type = $request->type;
            $types->save();


        } catch (QueryException $e) {

            return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
        }

        return response()->json(['Status' => "Success","Data" => Types::all()]);
    }

    public function AddBrand(Request $request)
    {

        $validator = Validator::make($request->all(), [
        'brand' => 'required|unique:brands|max:255',

        ]);

        if($validator->fails())
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        }

        try
        {

            $brands = new Brands();
            $brands->brand = $request->brand;
            $brands->save();


        } catch (QueryException $e) {


            return response()->json(['Status' => "Database Error", "Message" =>  $e->getMessage()]);
        }


        return response()->json(['Status' => "Success","Data" => Brands::all()]);

    }

    public function DeleteType(Request $request)
    {
          try {
              $id = $request->id;
              $types = Types::find($id);
              $types->delete();

         } catch (QueryException $e) {
              return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
         }


         return response()->json(['Status' => "Success","Data" => Types::all()]);

    }


    public function DeleteBrand(Request $request)
    {
           try {
               $id = $request->id;
               $brands = Brands::find($id);
               $brands->delete();

          } catch (QueryException $e) {
               return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
          }

          return response()->json(['Status' => "Success","Data" => Brands::all()]);

    }

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

            if ($qty <= $purchase_qty){

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
                    $orderlist->order_id = $id;
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
        
    }





}