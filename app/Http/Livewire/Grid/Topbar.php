<?php

namespace App\Http\Livewire\Grid;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Topbar extends Component
{
    public function render()
    {
        $hosts_summary = DB::table('nagios_hoststatus')
            ->join('nagios_hosts','nagios_hoststatus.host_object_id','=','nagios_hosts.host_object_id')
            ->get();

        $services_summary = DB::table('nagios_hosts')
            ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
            ->join('nagios_servicestatus','nagios_services.service_object_id','=','nagios_servicestatus.service_object_id')
            ->get();

                    
            // Hosts summary

            $total_hosts = 0;
            $hosts_up = 0;
            $hosts_down = 0;
            $hosts_unreachable = 0;
            
            // Boxes summary

            $total_boxs = 0;
            $boxs_up = 0;
            $boxs_down = 0;
            $boxs_unreachable = 0;
            
            foreach ($hosts_summary as $host) {        

                if($host->alias == "host")
                {
                
                    switch ($host->current_state) {
                        case 0:
                            $hosts_up++;
                            break;
                        
                        case 1:
                            $hosts_down++;
                            break;
                        
                        case 2:
                            $hosts_unreachable++;
                            break;
                        default:
                            
                            break;
                    }

                    $total_hosts++;
                }
                
                if($host->alias == "box")
                {
                
                    switch ($host->current_state) {
                        case 0:
                            $boxs_up++;
                            break;
                        
                        case 1:
                            $boxs_down++;
                            break;
                        
                        case 2:
                            $boxs_unreachable++;
                            break;
                        default:
                            
                            break;
                    }

                    $total_boxs++;
                }

            }

            // Services summary

            $total_services = 0;
            $services_ok = 0;
            $services_warning = 0;
            $services_critical = 0;
            $services_unknown = 0;
            
            // Equipements summary

            $total_equipements = 0;
            $equipements_ok = 0;
            $equipements_warning = 0;
            $equipements_critical = 0;
            $equipements_unknown = 0;
            
            foreach ($services_summary as $service) {
                
                // Services :

                if($service->alias == "host")
                {
                
                    switch ($service->current_state) {
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

                        default:
                            
                            break;
                    }

                    $total_services++;
                }

                // Equipement :

                if($service->alias == "box")
                {
                
                    switch ($service->current_state) {
                        case 0:
                            $equipements_ok++;
                            break;
                        
                        case 1:
                            $equipements_warning++;
                            break;
                        
                        case 2:
                            $equipements_critical++;
                            break;
                            
                        case 3:
                            $equipements_unknown++;
                            break;

                        default:
                            
                            break;
                    }

                    $total_equipements++;
                }

            }

        return view('livewire.grid.topbar', compact('total_hosts','total_boxs','total_services','total_equipements','hosts_up','hosts_down','hosts_unreachable','boxs_up','boxs_down','boxs_unreachable','services_ok','services_warning','services_critical','services_unknown','equipements_ok','equipements_warning','equipements_critical','equipements_unknown'));

    }
}
