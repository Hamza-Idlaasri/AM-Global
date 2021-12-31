<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportCSVServices;
use Excel;
use PDF;

class Services extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function download($name,$status,$dateFrom,$dateTo)
    {

        if($status || $name || $dateFrom || $dateTo)
        {
            $services_history = $this->getServicesHistory();

            if($name != 'All')
            {
                $services_history = $services_history->where('nagios_services.display_name', $name);
            }

            if($dateFrom != 'All' || $dateTo != 'All')
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

            if($status != 'All')
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

            $services_history = $services_history->get();

        } else{

            $services_history = $this->getServicesHistory()->get();

        }
        
        $pdf = PDF::loadView('download.services', compact('services_history'))->setPaper('a4', 'landscape');

        return $pdf->stream('services_history '.now().'.pdf');
        
    }

    public function csv()
    {
        return Excel::download(new ExportCSVServices, 'services '.now().'.csv');

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
