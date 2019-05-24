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

        $type = empty($request->type)? "": $request->type;
        $name = empty($request->name)? "": $request->name;
    
       // return $product->where('type', 'CPU');

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

        if ( $name=='' && $type=='' || $name!=null && $type==''){
            $product = Products::where('name', 'LIKE', '%'.$name.'%')
                                ->orWhere('type', $type)
                                ->get();
        }elseif( $name!=null && $type!=null || $name=='' && $type!=null ){
            $product = Products::where('name', 'LIKE', '%'.$name.'%')
                                ->where('type', $type)
                                ->get();
                           
        }else{
            $product = Products::all();
        }

        return response()->json($product);
        //return response()->json($data);
    }

    public function check(Request $request)
    {
        //$type = empty($request->type)? "": $request->type;
        //$product = Products::all();
        //$product = collect($product);
        //return $product->where('name', 'LIKE', "%Intel%");
        $name='';
        $type='';

        if ( $name=='' && $type=='' || $name!=null && $type==''){
            $product = Products::where('name', 'LIKE', '%'.$name.'%')
                                ->orWhere('type', $type)
                                ->get();
        }elseif( $name!=null && $type!=null || $name=='' && $type!=null ){
            $product = Products::where('name', 'LIKE', '%'.$name.'%')
                                ->where('type', $type)
                                ->get();
                           
        }else{
            $product = Products::all();
        }
        
        return response()->json($product);             

        //return response()->json($product->where('name', 'like', '%'.'Intel I5'.'%'));
    }
}
