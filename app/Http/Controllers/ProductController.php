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


        return response()->json(['status' => "Success", "Data" => "Some data"]);
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


    public function search(Request $request)
    {
        
        //default value to empty string if no value is passed in

        $type = empty($request->type)? "": $request->type;
        $name = empty($request->name)? "": $request->name;
    

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