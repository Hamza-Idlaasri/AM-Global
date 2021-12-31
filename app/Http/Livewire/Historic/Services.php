<?php

namespace App\Http\Livewire\Historic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Services extends Component
{
    public function render()
    {
        $status = request()->query('status');
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        if($status || $name || $dateFrom || $dateTo)
        {
            $services_history = $this->getServicesHistory();

            if($name)
            {
                $services_history = $services_history->where('nagios_services.display_name', $name);
            }

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = '2000-01-01';
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $services_history = $services_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);
            }

            if($status)
            {
                switch ($status) {
                    case 'ok':
                        $services_history = $services_history->where('state','0');
                        break;
                    
                    case 'warning':
                        $services_history = $services_history->where('state','1');
                        break;
                    
                    case 'critical':
                        $services_history = $services_history->where('state','2');
                        break;
                    
                    case 'unreachable':
                        $services_history = $services_history->where('state','3');
                        break;
                    
                }
            }

            $services_history = $services_history->paginate(10);

        } else{

            $services_history = $this->getServicesHistory()->paginate(10);

        }

        $services_name = DB::table('nagios_hosts')
            ->where('alias','host')
            ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->select('nagios_services.display_name','nagios_services.service_object_id')
            ->get();

        return view('livewire.historic.services', compact('services_history','services_name'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getServicesHistory()
    {
        return DB::table('nagios_hosts')
        ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
        ->join('nagios_statehistory','nagios_services.service_object_id','=','nagios_statehistory.object_id')
        ->select('nagios_hosts.display_name as host_name','nagios_hosts.*','nagios_services.display_name as service_name','nagios_services.*','nagios_statehistory.*')
        ->where('alias','host')
        ->orderByDesc('state_time');
    }
}
