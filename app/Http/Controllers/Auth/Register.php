<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Register extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // validation
        $this->validate($request,[

            'name' => 'required|min:3|max:15|unique:users.users|regex:/^[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'email' => 'required|email|max:100|unique:users.users',
            'phone_number' => 'required|regex:/[0-9]{9}/',
            'password' => 'required|string|confirmed|min:5|max:12|regex:/^[a-zA-Z0-9-_().@$=%&#+{}*ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/|unique:users.users',

        ]);

        // Store User 
        User::create([

            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => '212'.$request->phone_number,
            'notified' => 0,
            'password' => Hash::make($request->password),

        ]);


        return redirect()->route('overview');
    }
}
