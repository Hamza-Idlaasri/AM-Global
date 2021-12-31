<?php

namespace App\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Services extends Component
{
    public function render()
    {
        $name = request()->query('name');
        $dateFrom = request()->query('from');
        $dateTo = request()->query('to');

        $all_services_names = $this->getServicesName()->get();

        $services_ok = 0;
        $services_warning = 0;
        $services_critical = 0;
        $services_unknown = 0;

        $services_name = $this->getServicesName();

        if($name)
        {
            $services_name = $services_name->where('nagios_services.display_name',$name);
        }


        $services_name = $services_name->get();
       
        $cas = [];
        $services_status = [];
        $range = [];

        foreach ($services_name as $service) {

            $services_checks = $this->getServicesChecks()
                ->where('nagios_servicechecks.service_object_id','=',$service->service_object_id);

            if($dateFrom || $dateTo)
            {
                if(!$dateFrom)
                {
                    $dateFrom = "2000-01-01";
                }

                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $services_checks = $services_checks
                    ->where('nagios_servicechecks.start_time','>=',$dateFrom)
                    ->where('nagios_servicechecks.end_time','<=',$dateTo);

            }

            $services_checks = $services_checks->get();

            foreach ($services_checks as $service_checks) {
                array_push($cas,$service_checks->state);
                array_push($range,$service_checks->end_time);
            }

            
            if(sizeof($cas) == 0)
            {
                return view('livewire.statistic.services', compact('all_services_names','cas'));

            } else
                array_push($services_status,$this->getStatus($cas, $service->display_name));
           
        }

        foreach ($services_status as $status) {
            
            $services_ok += $status->ok;
            $services_warning += $status->warning;
            $services_critical += $status->critical;
            $services_unknown += $status->unknown;
        }
        
        return view('livewire.statistic.services', compact('all_services_names','cas','range','services_ok','services_warning','services_critical','services_unknown'))
        ->extends('layouts.app')
        ->section('content');
    
    }

    public function getServicesName()
    {
        return DB::table('nagios_hosts')
            ->where('alias','host')
            ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->select('nagios_services.display_name','nagios_services.service_object_id');
    }

    public function getServicesChecks()
    {
        return DB::table('nagios_servicechecks')
        ->select('nagios_hosts.alias','nagios_hosts.host_object_id','nagios_services.display_name','nagios_services.service_object_id','nagios_servicechecks.*')
        ->join('nagios_services','nagios_services.service_object_id','=','nagios_servicechecks.service_object_id')
        ->join('nagios_hosts','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
        ->where('alias','host')
        ->orderBy('nagios_hosts.display_name');
    }

    public function getStatus($cas, $name)
    {
        $services_ok = 0;
        $services_warning = 0;
        $services_critical = 0;
        $services_unknown = 0;
        
        for ($i=0; $i < sizeof($cas) ; $i++) { 

            if (sizeof($cas) != $i+1) {
            
                if($cas[$i] == $cas[$i+1])
                {
                    continue;

                } else {

                    switch ($cas[$i]) {
                        
                        case 0:
                            $services_ok++;
                            break;

                        case 1:
                            $services_warning++;
                            break;

                        case 2:
                            $services_critical++;
                            break;
                        case 3:
                            $services_unknown++;
                            break;
                        
                    }
                }
            }
        }

        switch ($cas[sizeof($cas)-1]) {
                        
            case 0:
                $services_ok++;
                break;

            case 1:
                $services_warning++;
                break;

            case 2:
                $services_critical++;
                break;
            case 3:
                $services_unknown++;
                break;
            
        }


        return (object)['service'=>$name,'ok'=>$services_ok,'warning'=>$services_warning,'critical'=>$services_critical, 'unknown' => $services_unknown];
        
    }
}
