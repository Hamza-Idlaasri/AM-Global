<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Notifications extends Component
{
    public $hosts;
    public $boxs;
    public $services;
    public $equips;
    
    public $total_hosts = 0;
    public $total_boxs = 0;
    public $total_services = 0;
    public $total_equips = 0;

    public $total = 0;

    public function getNotifs()
    {
        $this->hosts = DB::table('nagios_notifications')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_notifications.object_id')
            ->where('nagios_hosts.alias','host')
            ->select('nagios_hosts.display_name as host_name','nagios_notifications.*')
            ->orderByDesc('start_time')
            ->get();

        $this->services = DB::table('nagios_notifications')
            ->join('nagios_services','nagios_services.service_object_id','=','nagios_notifications.object_id')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->where('nagios_hosts.alias','host')
            ->select('nagios_services.display_name as service_name','nagios_hosts.display_name as host_name','nagios_notifications.*')
            ->orderByDesc('start_time')
            ->get();

        $this->boxs = DB::table('nagios_notifications')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_notifications.object_id')
            ->where('nagios_hosts.alias','box')
            ->select('nagios_hosts.display_name as box_name','nagios_notifications.*')
            ->orderByDesc('start_time')
            ->get();
    
        $this->equips = DB::table('nagios_notifications')
            ->join('nagios_services','nagios_services.service_object_id','=','nagios_notifications.object_id')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->where('nagios_hosts.alias','box')
            ->select('nagios_services.display_name as equip_name','nagios_hosts.display_name as box_name','nagios_notifications.*')
            ->orderByDesc('start_time')
            ->get();
    }

    public function counter()
    {
        $this->getNotifs();
        
        foreach ($this->hosts as $host) {
            $this->total_hosts++;
        }

        foreach ($this->boxs as $box) {
            $this->total_boxs++;
        }

        foreach ($this->services as $service) {
            $this->total_services++;
        }

        foreach ($this->equips as $equip) {
            $this->total_equips++;
        }

        $this->total = $this->total_hosts + $this->total_boxs + $this->total_services + $this->total_equips;
    }

    public function checked($type)
    {
        // dd($type);
    }

    public function render()
    {
        // $this->getNotifs();

        $this->counter();

        return view('livewire.notifications')
        ->with(['hosts'=>$this->hosts,'boxs'=>$this->boxs,'services'=>$this->services,'equips'=>$this->equips,'total_hosts'=>$this->total_hosts,'total_boxs'=>$this->total_boxs,'total_services'=>$this->total_services,'total_equips'=>$this->total_equips])
        ->extends('layouts.app')
        ->section('content');
    }
}
