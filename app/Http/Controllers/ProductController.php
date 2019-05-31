<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Products;


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
        // $this->validate($request, [
        //     'name'  => 'required',
        //     'type'  => 'required',
        //     'price' => 'required'
        // ]);

        $max_id = Products::max('id'); 
        $new_id = $max_id + 1; 

        //$img = $request->img;//find for rename, filetype
        $image = $request->img;
        $imgDetail = $request->imgDetail;
        $new_name_1 = $new_id.'_product'.'.'.$image->getClientOriginalExtension();
        $new_name_2 = $new_id.'_detail'.'.'.$imgDetail->getClientOriginalExtension();
        $image->move(public_path('img'), $new_name_1);
        $imgDetail->move(public_path('img'), $new_name_2);

        $db_name_1 = '/img/'.$new_name_1;
        $db_name_2 = '/img/'.$new_name_2;
        // return back()->with('success','Image Uploaded Successfully')->with('path', $new_name_1);

        $product = new Products();
        $product->name = $request->name;
        $product->type = $request->type;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->img = $db_name_1;
        $product->imgDetail = $db_name_2;
        $product->qty = $request->qty;
        $product->save();

        $result->status = "Success";
        $result->data = "something";


        //To store image
        // $file =  $request->img;
        // $file->move(public_path('/img'),'test.jpg');


        return response()->json(['status' => "Success", "Data" => $name]);
    }

    public function check(Request $request)
    {
        //$type = empty($request->type)? "": $request->type;
        //$product = Products::all();
        //$product = collect($product);
        //return $product->where('name', 'LIKE', "%Intel%");

        // $name='';
        // $type='';
        // $brand='';
        
        // $product = Products::where('name', 'LIKE', '%'.$name.'%')
        //                     ->where('type', 'LIKE', '%'.$type.'%')
        //                     ->where('brand', 'LIKE', '%'.$brand.'%')
        //                     ->get();
                           
     
      
        
        // return response()->json($product);      

        //return response()->json($product->where('name', 'like', '%'.'Intel I5'.'%'));
    }


}