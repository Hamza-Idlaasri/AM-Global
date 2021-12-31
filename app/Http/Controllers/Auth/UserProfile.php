<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserProfile extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function indexPass()
    {
        $user = auth()->user();
        
        return view('auth.user.changepass', compact('user'));
    }

    public function userProfile()
    {
        $userProfile = auth()->user();

        return view('auth.user.userProfile', compact('userProfile'));
    }

    // public function deleteMyAccount($id)
    // {
    
    //     $user = User::find($id);
    //     $user->delete();

    //     $remove_role = DB::connection('mysql2')->table('role_user')
    //         ->where('user_id',$user->id)
    //         ->delete();

    //     auth()->logout();

    //     return redirect()->route('login');
    // }

    public function changePassword(Request $request)
    {
        
        if (Hash::check($request->oldPassword, auth()->user()->password)) {

            // validation
            $this->validate($request,[

                'password' => 'required|string|confirmed|min:5|max:12|regex:/^[a-zA-Z0-9-_().@$=%&#+{}*ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/|unique:users.users',

            ]);

            // Update user 
            auth()->user()->update([

                'password' => Hash::make($request->password),

            ]);
            

        } else {
            return back()->with('status','Invalid Old Password');
        }

        return redirect()->route('userProfile')->with('status','Password changed');
    }

    public function indexInfo()
    {
        $user = auth()->user();
        
        return view('auth.user.editInfo', compact('user'));
    }

    public function changeNameEmail(Request $request)
    {
        // validation
        $this->validate($request,[

            'username' => 'required|min:3|max:15|regex:/^[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|regex:/[0-9]{9}/',
            
        ]);

        // Update user 
        auth()->user()->update([

            'name' => $request->username,
            'email' => $request->email,
            'phone_number' => '212'.$request->phone_number,
        ]);
        
        if ($request->notified) {
            auth()->user()->update([
                'notified' => 1
            ]);
        } 
        else {
            auth()->user()->update([
                'notified' => 0
            ]);
        }

        return redirect()->route('userProfile')->with('status','Your info are changed');

    }
}
