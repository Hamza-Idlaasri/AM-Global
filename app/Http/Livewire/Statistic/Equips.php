<?php

namespace App\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Equips extends Component
{
    public function render()
    {
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        $all_equips_names = $this->getServicesName()->get();

        $equips_ok = 0;
        $equips_warning = 0;
        $equips_critical = 0;
        $equips_unknown = 0;

        $equips_name = $this->getServicesName();

        if($name)
        {
            $equips_name = $equips_name->where('nagios_services.display_name',$name);
        }


        $equips_name = $equips_name->get();
       
        $cas = [];
        $equips_status = [];
        $range = [];

        foreach ($equips_name as $equip) {

            $equips_checks = $this->getServicesChecks()
                ->where('nagios_servicechecks.service_object_id','=',$equip->service_object_id);

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = "2000-01-01";
                }

                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $equips_checks = $equips_checks
                    ->where('nagios_servicechecks.start_time','>=',$dateFrom)
                    ->where('nagios_servicechecks.end_time','<=',$dateTo);

            }

            $equips_checks = $equips_checks->get();

            foreach ($equips_checks as $equip_checks) {
                array_push($cas,$equip_checks->state);
                array_push($range,$equip_checks->end_time);
            }

            
            if(sizeof($cas) == 0)
            {
                return view('livewire.statistic.equips', compact('all_equips_names','cas'));

            } else
                array_push($equips_status,$this->getStatus($cas, $equip->display_name));
           
        }

        foreach ($equips_status as $status) {
            
            $equips_ok += $status->ok;
            $equips_warning += $status->warning;
            $equips_critical += $status->critical;
            $equips_unknown += $status->unknown;
        }
        
        return view('livewire.statistic.equips', compact('all_equips_names','cas','range','equips_ok','equips_warning','equips_critical','equips_unknown'))
        ->extends('layouts.app')
        ->section('content');
    
    }

    public function getServicesName()
    {
        return DB::table('nagios_hosts')
            ->where('alias','box')
            ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->select('nagios_services.display_name','nagios_services.service_object_id');
    }

    public function getServicesChecks()
    {
        return DB::table('nagios_servicechecks')
        ->select('nagios_hosts.alias','nagios_hosts.host_object_id','nagios_services.display_name','nagios_services.service_object_id','nagios_servicechecks.*')
        ->join('nagios_services','nagios_services.service_object_id','=','nagios_servicechecks.service_object_id')
        ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
        ->where('alias','box')
        ->orderBy('nagios_hosts.display_name');
    }

    public function getStatus($cas, $name)
    {
        $equips_ok = 0;
        $equips_warning = 0;
        $equips_critical = 0;
        $equips_unknown = 0;
        
        for ($i=0; $i < sizeof($cas) ; $i++) { 

            if (sizeof($cas) != $i+1) {
            
                if($cas[$i] == $cas[$i+1])
                {
                    continue;

                } else {

                    switch ($cas[$i]) {
                        
                        case 0:
                            $equips_ok++;
                            break;

                        case 1:
                            $equips_warning++;
                            break;

                        case 2:
                            $equips_critical++;
                            break;
                        case 3:
                            $equips_unknown++;
                            break;
                        
                    }
                }
            }
        }

        switch ($cas[sizeof($cas)-1]) {
                        
            case 0:
                $equips_ok++;
                break;

            case 1:
                $equips_warning++;
                break;

            case 2:
                $equips_critical++;
                break;
            case 3:
                $equips_unknown++;
                break;
            
        }


        return (object)['service' => $name,'ok' => $equips_ok,'warning' => $equips_warning,'critical'=> $equips_critical, 'unknown' => $equips_unknown];
        
    }
}
