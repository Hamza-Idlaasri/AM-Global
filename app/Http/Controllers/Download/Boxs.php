<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportCSVBoxs;
use Excel;
use PDF;

class Boxs extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function download($name,$status,$dateFrom,$dateTo)
    {

        if($status || $name || $dateFrom || $dateTo)
        {
            $boxs_history = $this->getBoxsHistory();

            if($name != 'All')
            {
                $boxs_history = $boxs_history->where('nagios_hosts.display_name', $name);
            }

            if($dateFrom != 'All' || $dateTo != 'All')
            {
                if(!$dateFrom)
                {
                    $dateFrom = '2000-01-01';
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $boxs_history = $boxs_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);
            }

            if($status != 'All')
            {
                switch ($status) {
                    case 'ok':
                        $boxs_history = $boxs_history->where('state','0');
                        break;
                    
                    case 'warning':
                        $boxs_history = $boxs_history->where('state','1');
                        break;
                    
                    case 'critical':
                        $boxs_history = $boxs_history->where('state','2');
                        break;
                    
                    case 'unreachable':
                        $boxs_history = $boxs_history->where('state','3');
                        break;
                    
                }
            }

            $boxs_history = $boxs_history->get();

        } else{

            $boxs_history = $this->getBoxsHistory()->get();

        }
        
        $pdf = PDF::loadView('download.boxs', compact('boxs_history'))->setPaper('a4', 'landscape');

        return $pdf->stream('boxs_history '.now().'.pdf');
        
    }

    public function csv()
    {
        return Excel::download(new ExportCSVBoxs, 'boxs '.now().'.csv');
    }

    public function getBoxsHistory()
    {
        return DB::table('nagios_hosts')
            ->where('alias','box')
            ->join('nagios_statehistory','nagios_hosts.host_object_id','=','nagios_statehistory.object_id')
            ->orderByDesc('state_time');
    }
}
