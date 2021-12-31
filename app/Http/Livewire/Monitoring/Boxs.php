<?php

namespace App\Http\Livewire\Monitoring;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Boxs extends Component
{
    protected $boxs;

    public $search;
 
    protected $queryString = ['search'];

    public function render()
    {

        $boxs_names = $this->getBoxsNames();

        if($this->search)
        {
            $this->boxs = $this->getBoxs()
                ->where('nagios_hosts.display_name','like', '%'.$this->search.'%')
                ->paginate(10);

        } else {

            $this->boxs = $this->getBoxs()->paginate(10);

        }


        return view('livewire.monitoring.boxs')
        ->with(['boxs'=>$this->boxs,'boxs_names'=>$boxs_names])
        ->extends('layouts.app')
        ->section('content');
    }

    public function getBoxs()
    {
        return DB::table('nagios_hosts')
        ->where('alias','box')
        ->join('nagios_hoststatus','nagios_hosts.host_object_id','=','nagios_hoststatus.host_object_id')
        ->orderBy('display_name');
    }

    public function getBoxsNames()
    {
        return DB::table('nagios_hosts')
        ->where('alias','box')
        ->join('nagios_hoststatus','nagios_hosts.host_object_id','=','nagios_hoststatus.host_object_id')
        ->orderBy('display_name')
        ->get();
    }
}
