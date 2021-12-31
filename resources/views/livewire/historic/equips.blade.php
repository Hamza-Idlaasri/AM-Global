

<div class="container">
    <!-- Search bar -->
    {{-- <div class="float-right">
        @include('inc.searchbar',['route' => 'historic.equips'])
    </div> --}}
   
    <!-- Filter -->
    <div class="float-right text-primary">
        @include('inc.filter',['names' => $equips_name ,'route' => 'historic.equips','type' => 'equip','from' => 'historic'])
    </div>

    <!-- Download button -->
    <div class="float-left">
        @include('inc.download', ['route' => 'equips.pdf','csv' => 'equips.csv','name' => request()->query('name'), 'status' => request()->query('status'), 'dateFrom' => request()->query('from'), 'dateTo' => request()->query('to')])
    </div>

</div>

<div class="container back">    

    <table class="table table-striped table-bordered table-hover">

        <tr  class="bg-primary text-light text-center">
            <th>Boxs</th>
            <th>Equips</th>
            <th>Status</th>
            <th>Dernier verification</th>
            <th>Description</th>
        </tr>
    

        @forelse ($equips_history as $equip_history)

        
        <tr>        
               
            <td>{{$equip_history->box_name}}</td> 

            <td>{{$equip_history->equip_name}}</td>
            
            @switch($equip_history->state)
                
                @case(0)
                    <td><span class="badge badge-success">Ok</span></td>
                    @break
                @case(1)
                    <td><span class="badge badge-warning">Warning</span></td>
                    @break
                @case(2)
                    <td><span class="badge badge-danger">Critical</span></td>
                    @break
                @case(3)
                    <td><span class="badge badge-unknown">Ureachable</span></td>
                    @break
                @default
                    
            @endswitch
            
            <td>{{$equip_history->state_time}}</td>
            <td class="description">{{$equip_history->output}}</td>
        </tr>
 
        @empty

            <tr>
                <td colspan="5">No result found</td>
            </tr>

        @endforelse
        
    </table>

    {{$equips_history->appends(['status' => request()->query('status'),'from' => request()->query('from'),'to' => request()->query('to'),'name' => request()->query('name')])->links('vendor.pagination.bootstrap-4')}}

</div>

<script>

const back = document.querySelector('.back');

// const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

// const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
//     v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
//     )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

// // do the work...
// document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
//     const table = th.closest('table');
//     Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
//         .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
//         .forEach(tr => table.appendChild(tr) );
// })));
</script>
