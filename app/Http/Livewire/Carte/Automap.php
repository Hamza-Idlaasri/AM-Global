<?php

namespace App\Http\Livewire\Carte;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Automap extends Component
{
    
    public function render()
    {
        $hosts = DB::table('nagios_hosts')
            ->join('nagios_hoststatus','nagios_hosts.host_object_id','=','nagios_hoststatus.host_object_id')
            ->get();

        $parent_hosts = DB::table('nagios_hosts')
            ->join('nagios_host_parenthosts','nagios_hosts.host_id','=','nagios_host_parenthosts.host_id')
            ->get();

        return view('livewire.carte.automap', compact('hosts','parent_hosts'))
        ->extends('layouts.app')
        ->section('content');
    }
}
