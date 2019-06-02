<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Products;
use \Illuminate\Database\QueryException;



class ProductController extends Controller
{
    public function index()
    {
        // $product = Products::all()->toArray(); 
        // return view('Admin.AdminInventory', compact('product'));
        //return view('Customer.ShoppingCart', compact('product'));
    }

    public function create()
    {
        return view('Admin.AdminCreate');
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name'  => 'required',
        //     'type'  => 'required',
        //     'price' => 'required'
        // ]);  
        // $product = new products([
        //     'name'  => $request->get('name'),
        //     'type'  => $request->get('type'),
        //     'price'  => $request->get('price')
        // ]);  
        // $product->save(); 
        // return redirect()->route('Admin.index')->with('success', 'Data Added');



        //To store image
        // $file =  $request->img;
        // $file->move(public_path('/img'),'test.jpg');

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        // ]);

        // if($validator->fails())
        // {
        //     return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);

        // }

        return response()->json(['Status' => "Success", "Data" => [['type' => 'A'],['type' => 'B']]]);
    }

    public function edit($id)
    {
        $product = Products::find($id);
        return view('Admin.AdminEdit', compact('product','id'));
    }

    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'name'  => 'required',
    //         'type'  => 'required',
    //         'price' => 'required'
    //     ]);
    //     $product = Products::find($id);
    //     $product->name = $request->get('name');
    //     $product->type = $request->get('type');
    //     $product->price = $request->get('price');
    //     $product->save();
    //     return redirect()->route('Admin.index')->with('success', 'Data Updated');
    // }

    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        return redirect()->route('Admin.index')->with('success', 'Data Deleted');
    }


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
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'qty' => 'required',

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
            //$product->img = $db_name_1;
            //$product->imgDetail = $db_name_2;
            $product->qty = $request->qty;
            $product->save();
            $id = $product->id;

        } catch (QueryException $e) {


            return response()->json(['Status' => "Database Error", "Message" => '']);
        }

        $db_name_1 = '/img/default.jpg';
        $db_name_2 = '/img/default.jpg';

        if($request->hasFile('img')){
            $image = $request->img;
            $new_name_1 = $id.'_product'.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $new_name_1);
            $db_name_1 = '/img/'.$new_name_1;
        }if($request->hasFile('imgDetail')){
            $imgDetail = $request->imgDetail;
            $new_name_2 = $id.'_detail'.'.'.$imgDetail->getClientOriginalExtension();
            $imgDetail->move(public_path('img'), $new_name_2);
            $db_name_2 = '/img/'.$new_name_2;
        }

        // $image = $request->img;
        // $imgDetail = $request->imgDetail;
        // $new_name_1 = $id.'_product'.'.'.$image->getClientOriginalExtension();
        // $new_name_2 = $id.'_detail'.'.'.$imgDetail->getClientOriginalExtension();
        // $image->move(public_path('img'), $new_name_1);
        // $imgDetail->move(public_path('img'), $new_name_2);

        // $db_name_1 = '/img/'.$new_name_1;
        // $db_name_2 = '/img/'.$new_name_2;

        DB::table('products')
            ->where('id', $id)
            ->update(['img' => $db_name_1, 'imgDetail' => $db_name_2]);

        return response()->json(['status' => "Success","Data" => Products::all()]);
    }

    public function check(Request $request)
    {
        // $product = new Products();
        // $product->name = $request->name;
        // $product->save();
        // $id = $product->id;
        // DB::table('products')
        //     ->where('id', $id)
        //     ->update(['img' => 'something', 'imgDetail' => 'somethingelse']);

    }


}