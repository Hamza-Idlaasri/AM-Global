<?php

namespace App\Http\Livewire\Problems;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Hosts extends Component
{
    protected $hosts;

    public $search;
 
    protected $queryString = ['search'];

    public function render()
    {
        $hosts_names = $this->getHostsName();
             
        if($this->search)
        {
            $this->hosts =$this->getHosts()
                ->where('current_state','<>','0')
                ->where('nagios_hosts.display_name','like', '%'.$this->search.'%')
                ->paginate(10);

        } else {

            $this->hosts = $this->getHosts()->where('current_state','<>','0')->paginate(10);

        }

        return view('livewire.problems.hosts')
        ->with(['hosts'=>$this->hosts,'hosts_names'=>$hosts_names])
        ->extends('layouts.app')
        ->section('content');
    }

    public function getHosts()
    {
        return DB::table('nagios_hosts')
        ->where('alias','host')
        ->join('nagios_hoststatus','nagios_hosts.host_object_id','=','nagios_hoststatus.host_object_id')
        ->orderBy('display_name');
    }

    public function getHostsName()
    {
        return DB::table('nagios_hosts')
            ->where('alias','host')
            ->select('nagios_hosts.display_name','nagios_hosts.host_object_id')
            ->orderBy('display_name')
            ->get();
    }

}
