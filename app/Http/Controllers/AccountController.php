<?php

namespace App\Http\Controllers;


use Validator;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Database\QueryException;
use Laratrust\Models\LaratrustRoleTrait;

class AccountController extends Controller
{
    
    public function ShowAllData()
    {
    	return response()->json(User::all());
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
    		$account = new User();
    		$account->username = $request->username;
    		$account->password = Hash::make($request->password);
    		$account->save();
            $account->attachRole($request->role);
    	}
    	catch(QueryException $e)
    	{
    		return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
    	}

    	return response()->json(['Status' => "Success"]);
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
