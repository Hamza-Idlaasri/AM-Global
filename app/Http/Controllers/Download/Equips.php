<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportCSVEquips;
use Excel;
use PDF;

class Equips extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function download($name,$status,$dateFrom,$dateTo)
    {

        if($status || $name || $dateFrom || $dateTo)
        {
            $equipements_history = $this->getEquipHistory();

            if($name != 'All')
            {
                $equipements_history = $equipements_history->where('nagios_services.display_name', $name);
            }

            if($dateFrom != 'All' || $dateTo != 'All')
            {
                if(!$dateFrom)
                {
                    $dateFrom = '2000-01-01';
                }


                if(!$dateTo)
                    $dateTo = date('Y-m-d');

                $equipements_history = $equipements_history
                    ->where('nagios_statehistory.state_time','>=', $dateFrom)
                    ->where('nagios_statehistory.state_time','<=', $dateTo);
            }

            if($status != 'All')
            {
                switch ($status) {
                    case 'ok':
                        $equipements_history = $equipements_history->where('state','0');
                        break;
                    
                    case 'warning':
                        $equipements_history = $equipements_history->where('state','1');
                        break;
                    
                    case 'critical':
                        $equipements_history = $equipements_history->where('state','2');
                        break;
                    
                    case 'unreachable':
                        $equipements_history = $equipements_history->where('state','3');
                        break;
                    
                }
            }

            $equipements_history = $equipements_history->get();

        } else{

            $equipements_history = $this->getEquipHistory()->get();

        }
        
        $pdf = PDF::loadView('download.equips', compact('equipements_history'))->setPaper('a4', 'landscape');

        return $pdf->stream('equip_history '.now().'.pdf');
        
    }

    public function csv()
    {
        return Excel::download(new ExportCSVEquips, 'equipements '.now().'.csv');

    }

    public function getEquipHistory()
    {
        return DB::table('nagios_hosts')
                ->where('alias','box')
                ->join('nagios_services','nagios_hosts.host_object_id','=','nagios_services.host_object_id')
                ->join('nagios_statehistory','nagios_services.service_object_id','=','nagios_statehistory.object_id')
                ->select('nagios_hosts.display_name as host_name','nagios_hosts.*','nagios_services.display_name as service_name','nagios_services.*','nagios_statehistory.*')
                ->orderByDesc('state_time');
    }
}
