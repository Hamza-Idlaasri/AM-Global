<?php

namespace App\Http\Livewire\Historic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Hosts extends Component
{
    public function render()
    {
        $status = request()->query('status');
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        if($status || $name || $dateFrom || $dateTo)
        {

            $hosts_history = $this->getHostsHistory();

            if($name)
            {
                $hosts_history = $hosts_history->where('nagios_hosts.display_name', $name);
            }

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = json_encode(DB::table('nagios_statehistory')->select('state_time')->first(),true);

                }

                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $hosts_history = $hosts_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);

            }
            
            if($status)
            {
                switch ($status) {
                    case 'up':
                        $hosts_history = $hosts_history->where('state','0');
                        break;
                    
                    case 'down':
                        $hosts_history = $hosts_history->where('state','1');
                        break;
                    
                    case 'unknown':
                        $hosts_history = $hosts_history->where('state','2');
                        break;
                    
                }
            }

            $hosts_history = $hosts_history->paginate(10);
            
        } else{

            $hosts_history = $this->getHostsHistory()->paginate(10);
            
        }

        $hosts_name = DB::table('nagios_hosts')
            ->where('alias','host')
            ->select('nagios_hosts.display_name')
            ->get();

        return view('livewire.historic.hosts', compact('hosts_history','hosts_name'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getHostsHistory()
    {
        return DB::table('nagios_hosts')
            ->where('alias','host')
            ->join('nagios_statehistory','nagios_hosts.host_object_id','=','nagios_statehistory.object_id')
            ->orderByDesc('state_time');
    }
}
