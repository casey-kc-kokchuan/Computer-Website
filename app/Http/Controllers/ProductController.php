<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Products::all()->toArray(); 
        return view('Admin.AdminInventory', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.AdminCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name'  => 'required',
            'product_type'  => 'required',
            'product_price' => 'required'
        ]);  
        $product = new products([
            'product_name'  => $request->get('product_name'),
            'product_type'  => $request->get('product_type'),
            'product_price'  => $request->get('product_price')
        ]);  
        $product->save(); 
        return redirect()->route('Admin.index')->with('success', 'Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('hi');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function shoppingCart()
    {

        return view('Customer/ShoppingCart');
    }

    public function search(Request $request)
    {
        
        //default value to empty string if no value is passed in

        $type = empty($request->type)? "": $request->type;
        $name = empty($request->name)? "": $request->name;


        //Example 1

        // $object1 = [];
        // $object1["id"] = 1;
        // $object1["name"] = "Logitech G502";
        // $object1["img"] = "/img/g502.jpg";
        // $object1["price"] = "500";

        // $object2 = [];
        // $object2["id"] = 2;
        // $object2["name"] = "Corsair Scimitar";
        // $object2["img"] = "/img/scimitar.jpg";
        // $object2["price"] = "420";


        //Example 2
        $object1= [
            "id"=>1,
            "name"=> "Logitech G502",
            "img"=> "/img/g502.jpg",
            "price"=>"500"
        ];

        $object2= [
            "id"=>1,
            "name"=> "Corsair Scimitar",
            "img"=> "/img/scimitar.jpg",
            "price"=> "420"
        ];

        $data = [$object1, $object2];


        return response()->json($data);
    }
}
