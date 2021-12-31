<?php

namespace App\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Hosts extends Component
{
    public function render()
    {
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        $hosts_name = $this->getHostsName();

        if($name)
        {
            $hosts_name = $hosts_name->where('display_name',$name);
        }

        $hosts_name = $hosts_name->get();

        $all_hosts_names = DB::table('nagios_hosts')
            ->where('alias','host')
            ->select('nagios_hosts.display_name','nagios_hosts.host_object_id')
            ->orderBy('display_name')
            ->get();

        $hosts_up = 0;
        $hosts_down = 0;
        $hosts_unreachable = 0;

        $cas = [];
        $hosts_status = [];
        $range = [];

        foreach ($hosts_name as $host) {

            $hosts_checks = $this->getHostsChecks()
                ->where('nagios_hostchecks.host_object_id','=',$host->host_object_id);

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = "2000-01-01";
                }

                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $hosts_checks = $hosts_checks
                    ->where('nagios_hostchecks.start_time','>=',$dateFrom)
                    ->where('nagios_hostchecks.end_time','<=',$dateTo);

            }

            $hosts_checks = $hosts_checks->get();

            foreach ($hosts_checks as $host_checks) {
                array_push($cas,$host_checks->state);
                array_push($range,$host_checks->end_time);
            }


            if(sizeof($cas) == 0)
            {
                // $case = 'No data found';
                return view('livewire.statistic.hosts', compact('all_hosts_names','cas'));

            } else
                array_push($hosts_status,$this->getStatus($cas, $host->display_name));

        }

        foreach ($hosts_status as $status) {

            $hosts_up += $status->up;
            $hosts_down += $status->down;
            $hosts_unreachable += $status->unreachable;
        }

        return view('livewire.statistic.hosts', compact('all_hosts_names','cas','range','hosts_up','hosts_down','hosts_unreachable'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function getHostsName()
    {
        return DB::table('nagios_hosts')
            ->where('alias','host')
            ->select('nagios_hosts.display_name','nagios_hosts.host_object_id')
            ->orderBy('display_name');
    }

    public function getHostsChecks()
    {
        return DB::table('nagios_hostchecks')
            ->select('nagios_hosts.display_name','nagios_hosts.alias','nagios_hosts.host_object_id','nagios_hostchecks.*')
            ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_hostchecks.host_object_id')
            ->where('alias','host')
            ->where('is_raw_check','=',0);
    }

    public function getStatus($cas, $name)
    {
        $hosts_up = 0;
        $hosts_down = 0;
        $hosts_unreachable = 0;

        for ($i=0; $i < sizeof($cas) ; $i++) {

            if (sizeof($cas) != $i+1) {

                if($cas[$i] == $cas[$i+1])
                {
                    continue;

                } else {

                    switch ($cas[$i]) {

                        case 0:
                            $hosts_up++;
                            break;

                        case 1:
                            $hosts_down++;
                            break;

                        case 2:
                            $hosts_unreachable++;
                            break;

                    }
                }
            }
        }

        switch ($cas[sizeof($cas)-1]) {

            case 0:
                $hosts_up++;
                break;

            case 1:
                $hosts_down++;
                break;

            case 2:
                $hosts_unreachable++;
                break;

        }


        return (object)['host'=>$name,'up'=>$hosts_up,'down'=>$hosts_down,'unreachable'=>$hosts_unreachable];

    }
}
