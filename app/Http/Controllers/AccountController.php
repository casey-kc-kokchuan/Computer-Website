<?php

namespace App\Http\Controllers;


use Validator;
use Illuminate\Http\Request;
use App\Accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Database\QueryException;


class AccountController extends Controller
{
    
    public function ShowAllData()
    {
    	return response()->json(Accounts::all());
    }

    public function AddAccount(Request $request)
    {
    	 $validator = Validator::make($request->all(), [
    	    'username' => 'required',
    	    'password' => 'required',
    	]);

    	if($validator->fails()) 
    	{
    	    return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
    	} 

    	try
    	{
    		$account = new Accounts();
    		$account->username = $request->username;
    		$account->password = Hash::make($request->password);
    		$account->save();
    	}
    	catch(QueryException $e)
    	{
    		return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
    	}

    	return response()->json(['status' => "Success"]);
    }

    public function Login(Request $request)
    {
    	$request->validate([
    	    'username' => 'required',
    	    'password' => 'required',
    	]);

    	$credentials = $request->only('username','password');

    	if(Auth::attempt($credentials))
    	{
    		return redirect()->intended('Admin/Account');
    	}


        return back()->with(['err' => 'Invalid username or password. Please try again.'])->withInput();

    	
    }

    public function Logout(Request $request)
    {
    	Auth::logout();
    	return redirect('Admin');
    }


}
