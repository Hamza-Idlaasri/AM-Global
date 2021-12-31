<?php

namespace App\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Boxs extends Component
{
    public function render()
    {
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        $boxs_name = $this->getBoxsName();

        if($name)
        {
            $boxs_name = $boxs_name->where('display_name',$name);
        }

        $boxs_name = $boxs_name->get();

        $all_boxs_names = DB::table('nagios_hosts')
            ->where('alias','box')
            ->select('nagios_hosts.display_name','nagios_hosts.host_object_id')
            ->orderBy('display_name')
            ->get();

        $boxs_up = 0;
        $boxs_down = 0;
        $boxs_unreachable = 0;

        $cas = [];
        $boxs_status = [];
        $range = [];

        foreach ($boxs_name as $box) {

            $boxs_checks = $this->getBoxsChecks()
                ->where('nagios_hostchecks.host_object_id','=',$box->host_object_id);

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = "2000-01-01";
                }

                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $boxs_checks = $boxs_checks
                    ->where('nagios_hostchecks.start_time','>=',$dateFrom)
                    ->where('nagios_hostchecks.end_time','<=',$dateTo);

            }

            $boxs_checks = $boxs_checks->get();

            foreach ($boxs_checks as $box_checks) {
                array_push($cas,$box_checks->state);
                array_push($range,$box_checks->end_time);
            }


            if(sizeof($cas) == 0)
            {
                // $case = 'No data found';
                return view('livewire.statistic.boxs', compact('all_boxs_names','cas'));

            } else
                array_push($boxs_status,$this->getStatus($cas, $box->display_name));

        }

        foreach ($boxs_status as $status) {

            $boxs_up += $status->up;
            $boxs_down += $status->down;
            $boxs_unreachable += $status->unreachable;
        }

        return view('livewire.statistic.boxs', compact('all_boxs_names','cas','range','boxs_up','boxs_down','boxs_unreachable'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getBoxsName()
    {
        return DB::table('nagios_hosts')
            ->where('alias','box')
            ->select('nagios_hosts.display_name','nagios_hosts.host_object_id')
            ->orderBy('display_name');
    }

    public function getBoxsChecks()
    {
        return DB::table('nagios_hostchecks')
            ->select('nagios_hosts.display_name','nagios_hosts.alias','nagios_hosts.host_object_id','nagios_hostchecks.*')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_hostchecks.host_object_id')
            ->where('alias','box')
            ->where('is_raw_check','=',0);
    }

    public function getStatus($cas, $name)
    {
        $boxs_up = 0;
        $boxs_down = 0;
        $boxs_unreachable = 0;

        for ($i=0; $i < sizeof($cas) ; $i++) {

            if (sizeof($cas) != $i+1) {

                if($cas[$i] == $cas[$i+1])
                {
                    continue;

                } else {

                    switch ($cas[$i]) {

                        case 0:
                            $boxs_up++;
                            break;

                        case 1:
                            $boxs_down++;
                            break;

                        case 2:
                            $boxs_unreachable++;
                            break;

                    }
                }
            }
        }

        switch ($cas[sizeof($cas)-1]) {

            case 0:
                $boxs_up++;
                break;

            case 1:
                $boxs_down++;
                break;

            case 2:
                $boxs_unreachable++;
                break;

        }


        return (object)['host'=>$name,'up'=>$boxs_up,'down'=>$boxs_down,'unreachable'=>$boxs_unreachable];

    }
}
