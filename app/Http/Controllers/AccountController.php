<?php

namespace App\Http\Controllers;


use Validator;
use App\User;
use App\Role;
use App\Permission;
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
    	    'username' => 'required|unique:accounts|max:255',
    	    'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|unique:accounts|max:255|email',
            'role' => 'required',
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
            $account->full_name = $request->full_name;
            $account->gender = $request->gender;
            $account->contact = $request->contact;
            $account->email = $request->email;
            $account->role = $request->role;
    		$account->save();
            $account->attachRole($request->role);
    	}
    	catch(QueryException $e)
    	{
    		return response()->json(['Status' => "Database Error", "Message" => $e->getMessage()]);
    	}

    	return response()->json(['Status' => "Success", 'Data' => User::all()]);

    }

    public function RemoveAccount(Request $request)
    {
        try {
            $id = $request->id;
            $account = User::find($id);
            $account->delete();
        } catch (Exception $e) {
            return response()->json(['Status' => "Database Error"]);
        }
        return response()->json(['Status' => "Success", 'Data' => User::all()]);
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
