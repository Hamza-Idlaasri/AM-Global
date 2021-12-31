<?php

namespace App\Http\Livewire\Historic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Equips extends Component
{
    public function render()
    {
        $status = request()->query('status');
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        if($status || $name || $dateFrom || $dateTo)
        {
            $equips_history = $this->getEquipsHistory();

            // Filter by Name
            if($name)
            {
                $equips_history = $equips_history->where('nagios_services.display_name', $name);
            }
            
            // Filter by Date
            if($dateFrom || $dateTo)
            {
                if(!$dateFrom) 
                {
                    $dateFrom = json_encode(DB::table('nagios_statehistory')->select('state_time')->first(),true);
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $equips_history = $equips_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);

               
            }


            // Filter by State
            if($status)
            {
                switch ($status) {
                    case 'ok':
                        $equips_history = $equips_history->where('state','0');
                        break;
                 
                    case 'warning':
                        $equips_history = $equips_history->where('state','1');
                            break;
                 
                    case 'critical':
                        $equips_history = $equips_history->where('state','2');
                                break;
                 
                    case 'unreachable':
                        $equips_history = $equips_history->where('state','3');
                                break;
                 
                }
            }

            $equips_history = $equips_history->paginate(10);

        } else{

            $equips_history = $this->getEquipsHistory()->paginate(10);
            
        }

        $equips_name = DB::table('nagios_hosts')
            ->where('alias','box')
            ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->select('nagios_services.display_name','nagios_services.service_object_id')
            ->get();

        return view('livewire.historic.equips', compact('equips_history','equips_name'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getEquipsHistory()
    {
        return DB::table('nagios_hosts')
        ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
        ->join('nagios_statehistory','nagios_services.service_object_id','=','nagios_statehistory.object_id')
        ->select('nagios_hosts.display_name as box_name','nagios_hosts.*','nagios_services.display_name as equip_name','nagios_services.*','nagios_statehistory.*')
        ->where('alias','box')
        ->orderByDesc('state_time');
    }
}
