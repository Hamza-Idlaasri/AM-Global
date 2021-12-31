<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportCSVHosts;
use Excel;
use PDF;

class Hosts extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function download($name,$status,$dateFrom,$dateTo)
    {

        if($status || $name || $dateFrom || $dateTo)
        {
            $hosts_history = $this->getHostsHistory();

            if($name != 'All')
            {
                $hosts_history = $hosts_history->where('nagios_hosts.display_name', $name);
            }

            if($dateFrom != 'All' || $dateTo != 'All')
            {
                if(!$dateFrom)
                {
                    $dateFrom = '2000-01-01';
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $hosts_history = $hosts_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);
            }

            if($status != 'All')
            {
                switch ($status) {
                    case 'ok':
                        $hosts_history = $hosts_history->where('state','0');
                        break;
                    
                    case 'warning':
                        $hosts_history = $hosts_history->where('state','1');
                        break;
                    
                    case 'critical':
                        $hosts_history = $hosts_history->where('state','2');
                        break;
                    
                    case 'unreachable':
                        $hosts_history = $hosts_history->where('state','3');
                        break;
                    
                }
            }

            $hosts_history = $hosts_history->get();

        } else{

            $hosts_history = $this->getHostsHistory()->get();

        }
        
        $pdf = PDF::loadView('download.hosts', compact('hosts_history'))->setPaper('a4', 'landscape');

        return $pdf->stream('hosts_history '.now().'.pdf');
        
    }

    public function csv()
    {
        return Excel::download(new ExportCSVHosts, 'hosts '.now().'.csv');
    }

    public function getHostsHistory()
    {
        return DB::table('nagios_hosts')
            ->where('alias','host')
            ->join('nagios_statehistory','nagios_hosts.host_object_id','=','nagios_statehistory.object_id')
            ->orderByDesc('state_time');
    }
}
