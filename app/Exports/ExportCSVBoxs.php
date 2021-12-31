<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportCSVBoxs implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $boxs =  DB::table('nagios_hosts')
                    ->where('alias','box')
                    ->join('nagios_statehistory','nagios_hosts.host_object_id','=','nagios_statehistory.object_id')
                    ->select('nagios_hosts.display_name','nagios_hosts.address','nagios_statehistory.state','nagios_statehistory.state_time','nagios_statehistory.long_output')
                    ->orderByDesc('state_time')
                    ->get();

        
        foreach ($boxs as $box) {

            switch ($box->state) {
                
                case 0:
                    $box->state = 'Up';
                    break;
                case 1:
                    $box->state = 'Down';
                    break;
                case 2:
                    $box->state = 'Unreachable';
                    break;

            }

        }

        return $boxs;
    }

    public function headings(): array
    {
        return [
            'Boxs',
            'Address IP',
            'State',
            'Dernier verification',
            'Description',
        ];
    }
}
