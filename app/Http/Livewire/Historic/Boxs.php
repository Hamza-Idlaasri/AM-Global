<?php

namespace App\Http\Livewire\Historic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Boxs extends Component
{
    public function render()
    {
        $status = request()->query('status');
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        if($status || $name || $dateFrom || $dateTo)
        {

            $boxs_history = $this->getBoxsHistory();

            if($name)
            {
                $boxs_history = $boxs_history->where('nagios_hosts.display_name', $name);
            }

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = json_encode(DB::table('nagios_statehistory')->select('state_time')->first(),true);
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');
                
                $boxs_history = $boxs_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);
            }

            if($status)
            {
                switch ($status) {
                    case 'up':
                        $boxs_history = $boxs_history->where('state','0');
                        break;
                    
                    case 'down':
                        $boxs_history = $boxs_history->where('state','1');
                        break;
                    
                    case 'unknown':
                        $boxs_history = $boxs_history->where('state','2');
                        break;
                    
                }
            }

            $boxs_history = $boxs_history->paginate(10);
            
        } else {

            $boxs_history = $this->getBoxsHistory()->paginate(10);

        }

        $boxs_name = DB::table('nagios_hosts')
            ->where('alias','box')
            ->select('nagios_hosts.display_name')
            ->get();

        return view('livewire.historic.boxs', compact('boxs_history','boxs_name'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getBoxsHistory()
    {
        return  DB::table('nagios_hosts')
            ->where('alias','box')
            ->join('nagios_statehistory','nagios_hosts.host_object_id','=','nagios_statehistory.object_id')
            ->orderByDesc('state_time');
    }
}
