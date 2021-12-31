<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class AddNewSite extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function sites()
    {
        $sites = Site::all();
        
        return view('site.sites', compact('sites'));
    }

    public function newSite()
    {
        return view('site.addnewsite');
    }

    public function addSite(Request $request)
    {
        // validation
        $this->validate($request,[

            // 'db_connection' => 'required|max:255|unique:users.sites|regex:/^[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'db_host' => 'required|max:255|regex:/^[a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'db_port' => 'required|max:255|regex:/^[a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'db_database' => 'required|max:255|regex:/^[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'db_username' => 'required|max:255|regex:/^[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]/',
            'db_password' => 'nullable|max:100',

        ]);


        // Store Site
        Site::create([

            // 'db_connection' => $request->db_connection,
            'db_host' => $request->db_host,
            'db_port' => $request->db_port,
            'db_database' => $request->db_database,
            'db_username' => $request->db_username,
            'db_password' => $request->db_password,
            
        ]);
        
        return redirect()->route('overview');
    }
}
