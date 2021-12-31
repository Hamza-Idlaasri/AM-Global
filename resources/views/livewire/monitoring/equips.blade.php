

<div class="container">

    @include('inc.searchbar',['route' => 'monitoring.equips','list' => 'boxs'])

    <div wire:poll.5000ms>

    <table class="table table-striped table-bordered table-hover">

        <thead class="bg-primary text-white text-center">
            <tr>
                <th>Boxes</th>
                <th>Equips</th>
                <th>Status</th>
                <th>Dernier verification</th>
                <th>Description</th>
            </tr>
        </thead>

        <?php $check = 0 ?>

        
        @forelse ($equips as $equip)        
        
        <tr>

            @if ($check == 0 || $equip->host_object_id != $check)       
                
                    <td>
                        {{-- <a href="/monitoring/hosts/{{$equip->host_id}}">{{$equip->host_name}}</a> --}}
                        {{ $equip->box_name }}
                    </td> 

                    <?php $check = $equip->host_object_id ?>
                
            @else
                <td></td>
            @endif
            

            <td>
                {{-- <a href="/monitoring/equips/{{$equip->equip_id}}">{{$equip->equip_name}}</a> --}}
                
                {{ $equip->equip_name }}

                @if ($equip->is_flapping)
                    <span class="float-right text-danger" title="This equip is flapping" style="cursor: pointer">
                        <i class="fas fa-retweet"></i>
                    </span>
                @endif
            </td>
            
            @switch($equip->current_state)
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
            
            <td>{{$equip->last_check}}</td>
            <td class="description">{{$equip->output}}</td>
        </tr>
            

        @empty

            <tr>
                <td colspan="5">No result found <strong>{{ request()->query('search') }}</strong></td>
            </tr>

        @endforelse

        
    </table>

</div>

    
    {{$equips->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-4')}}

    <datalist id="boxs">
        @foreach ($boxs_names as $box)
            <option value="{{$box->display_name}}">{{$box->display_name}}</option>        
        @endforeach
    </datalist>

</div>

