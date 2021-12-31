
<div class="container">

    @include('inc.searchbar',['route' => 'problems.boxs','list' => 'boxs'])

    <div wire:poll.5000ms>

    <table class="table table-striped table-bordered text-center table-hover">

        <thead class="bg-primary text-white">
            <tr>
                <th>Boxes</th>
                <th>Adresse IP</th>
                <th>Status</th>
                <th>Dernier verification</th>
                <th>Description</th>
            </tr>
        </thead>

        @forelse ($boxs as $box)

            <tr>
                <td>
                    {{-- <a href="/monitoring/boxs/{{ $box->box_id }}">{{ $box->display_name }}</a> --}}
                    {{ $box->display_name}}
                    
                    @if ($box->is_flapping)
                        <span class="float-right text-danger" title="This box is flapping" style="cursor: pointer">
                            <i class="fas fa-retweet"></i>
                        </span>
                    @endif

                </td>
                
                <td>{{ $box->address }}</td>

                @switch($box->current_state)

                    @case(1)
                        <td><span class="badge badge-danger">Down</span></td>
                    @break

                    @case(2)
                        <td><span class="badge badge-unknown">Ureachable</span></td>
                    @break

                    @default

                @endswitch

                <td>{{ $box->last_check }}</td>
                <td class="description">{{ $box->output }}</td>
            </tr>


            @empty

                <tr>
                    <td colspan="5">No result found <strong>{{ request()->query('search') }}</strong></td>
                </tr>

            @endforelse

        </table>
    </div>

        {{ $boxs->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-4') }}
    
        <datalist id="boxs">
            @foreach ($boxs_names as $box)
                <option value="{{$box->display_name}}">{{$box->display_name}}</option>        
            @endforeach
        </datalist>

</div>

