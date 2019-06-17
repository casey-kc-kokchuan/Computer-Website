<?php

namespace App\Http\Controllers;


use Validator;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail;
use \Illuminate\Database\QueryException;
use Laratrust\Models\LaratrustRoleTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mail\ChangePasswordEmail;

class AccountController extends Controller
{
    
    public function ShowAllData()
    {
    	return response()->json(User::all());
    }

    public function AddAccount(Request $request)
    {
    	 $validator = Validator::make($request->all(), [
    	    'username' => 'required|unique:accounts|between:8,255',
    	    'password' => 'required|between:8,255',
            'full_name' => 'required|max:255',
            'email' => 'required|unique:accounts|max:255|email',
            'role' => 'required',
            'contact' => 'max:25'
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

    public function EditAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'role' => 'required',
            'contact' => 'max:25'
        ]);

        if($validator->fails()) 
        {
            return response()->json(['Status' => "Validation Error", "Message" => $validator->errors()]);
        } 

        try
        {
            $account = User::find($request->id);
            $account->full_name = $request->full_name;
            $account->gender = $request->gender;
            $account->contact = $request->contact;
            $account->email = $request->email;
            $account->role = $request->role;
            $account->save();
            $account->syncRoles([$request->role]);
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
        } catch (QueryException $e) {
            return response()->json(['Status' => "Database Error"]);
        }
        return response()->json(['Status' => "Success", 'Data' => User::all()]);
    }


   public function ChangePassword(Request $request)
   {
        $request->validate([
            'password' => 'required|confirmed|between:8,255',
        ]);

     
        $id = $request->id;
        $account = User::findOrFail($id);
        $account->password = Hash::make($request->password);
        $account->email_token = md5(rand(1, 10).microtime());
        $account->save();
        
        return view("Admin/PasswordChanged");

   }

    public function ChangePasswordRequest(Request $request)
    {
        $request->validate([
            'username' => 'required'
        ]);

        try
        {
            $account = User::where('username', $request->username)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            return back()->with(['err' => 'Username does not exist.'])->withInput();
        }

        $token = md5(rand(1, 10).microtime());
        $account->email_token = $token;
        $account->save();
        $id = $account->id * 153;

        Mail::to($account->email)->send(new ChangePasswordEmail($token, $id, $account->full_name));

        return view("/Admin/PasswordRequestSent");
    }

    public function VerifyChangePasswordRequest(Request $request)
    {
        $id = $request->mint/153;

        $account = User::findOrFail($id);

        if($account->email_token != $request->email_token)
        {
            abort(403);
        }

        return view("/Admin/ChangePassword",["id" => $id]);
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
            return redirect('Admin/OrderManager');
        }

        return back()->with(['err' => 'Invalid username or password. Please try again.'])->withInput();
        
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        return redirect('Admin');
    }

}
