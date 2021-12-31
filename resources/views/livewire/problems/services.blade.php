
<div class="container">

    @include('inc.searchbar',['route' => 'problems.services','list'=> 'hosts'])

    <div wire:poll.5000ms>

    <table class="table table-striped table-bordered table-hover">

        <thead class="bg-primary text-white text-center">
            <tr>
                <th>Host</th>
                <th>Service</th>
                <th>Status</th>
                <th>Dernier verification</th>
                <th>Description</th>
            </tr>
        </thead>

        <?php $check = 0 ?>

        
        @forelse ($services as $service)        
        
        <tr>

            @if ($check == 0 || $service->host_object_id != $check)       
                
                    <td>
                        {{-- <a href="/monitoring/hosts/{{$service->host_id}}">{{$service->host_name}}</a> --}}
                        {{ $service->host_name }}
                    </td> 

                    <?php $check = $service->host_object_id ?>
                
            @else
                <td></td>
            @endif
            

            <td>
                {{-- <a href="/monitoring/services/{{$service->service_id}}">{{$service->service_name}}</a> --}}
                
                {{ $service->service_name }}

                @if ($service->is_flapping)
                    <span class="float-right text-danger" title="This Service is flapping" style="cursor: pointer">
                        <i class="fas fa-retweet"></i>
                    </span>
                @endif
            </td>
            
            @switch($service->current_state)
            
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
            
            <td>{{$service->last_check}}</td>
            <td class="description">{{$service->output}}</td>
        </tr>
            

        @empty

            <tr>
                <td colspan="5">No result found <strong>{{ request()->query('search') }}</strong></td>
            </tr>

        @endforelse

    </table>

</div>
    

    {{$services->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-4')}}

    <datalist id="hosts">
        @foreach ($hosts_names as $host)
            <option value="{{$host->display_name}}">{{$host->display_name}}</option>        
        @endforeach
    </datalist>

</div>

