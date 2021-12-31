<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />

<style>

body{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
}

@page{
    margin: 10px 50px;
    padding: 0;
}

</style>

    <h4 class="text-center">Hosts History</h4>
    <br>
    <table class="table table-striped table-bordered text-center">
        <tr class="bg-primary text-light text-center">
            <th>Box</th>
            <th>Adresse IP</th>
            <th>Status</th>
            <th>Dernier verification</th>
            <th>Description</th>
        </tr>

        @forelse ($boxs_history as $box_history)
            <tr>
                <td>{{$box_history->display_name}}</td>
                <td>{{$box_history->address}}</td>
                
                @switch($box_history->state)
                
                    @case(0)
                        <td><span class="badge badge-success">Up</span></td>
                        @break

                    @case(1)
                        <td><span class="badge badge-danger">Down</span></td>
                        @break
                        
                    @case(2)
                        <td><span class="badge badge-unknown">Ureachable</span></td>
                        @break
                    
                    @default
                        
                @endswitch
                
                <td>{{$box_history->state_time}}</td>
                <td class="description">{{$box_history->output}}</td>
            </tr>

        @empty

            <tr>
                <td colspan="5">No result found {{-- <strong>{{ request()->query('search') }}</strong> --}}</td>
            </tr>

        @endforelse
    </table>


