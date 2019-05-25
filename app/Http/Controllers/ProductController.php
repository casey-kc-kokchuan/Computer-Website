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
        //return view('Customer.ShoppingCart', compact('product'));
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
            'name'  => 'required',
            'type'  => 'required',
            'price' => 'required'
        ]);  
        $product = new products([
            'name'  => $request->get('name'),
            'type'  => $request->get('type'),
            'price'  => $request->get('price')
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
        $product = Products::find($id);
        return view('Admin.AdminEdit', compact('product','id'));
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
        $this->validate($request, [
            'name'  => 'required',
            'type'  => 'required',
            'price' => 'required'
        ]);
        $product = Products::find($id);
        $product->name = $request->get('name');
        $product->type = $request->get('type');
        $product->price = $request->get('price');
        $product->save();
        return redirect()->route('Admin.index')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        return redirect()->route('Admin.index')->with('success', 'Data Deleted');
    }


    public function shoppingCart()
    {

        return view('Customer/ShoppingCart');
    }

    public function search(Request $request)
    {
        
        //default value to empty string if no value is passed in

        $name = empty($request->name)? "": $request->name;
        $type = empty($request->type)? "": $request->type;
        $brand = empty($request->name)? "": $request->brand;
        $product = Products::all();
        // $product = collect($product);
       // return $product->where('type', 'CPU');


  

        return response()->json($product);
        //return response()->json($data);
    }

    public function check(Request $request)
    {
        $variable = 'Intel I5';
        $type = empty($request->type)? "": $request->type;
        $product = Products::all();
        // $product = collect($product);
        // return $product->where('name', 'LIKE', "%Intel%");

        //return response()->json($product->where('name', 'like', '%'.'Intel I5'.'%'));
    }
}
