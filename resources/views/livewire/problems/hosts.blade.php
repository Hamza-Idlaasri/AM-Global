
<div class="container">

    @include('inc.searchbar',['route' => 'problems.hosts','list'=> 'hosts'])

    <div wire:poll.5000ms>

    <table class="table table-striped table-bordered text-center table-hover">

        <thead class="bg-primary text-white">
            <tr>
                <th>Host</th>
                <th>Adresse IP</th>
                <th>Status</th>
                <th>Dernier verification</th>
                <th>Description</th>
            </tr>
        </thead>

        @forelse ($hosts as $host)

            <tr>
                <td>
                    {{-- <a href="/monitoring/hosts/{{ $host->host_id }}">{{ $host->display_name }}</a> --}}
                    {{ $host->display_name}}
                    
                    @if ($host->is_flapping)
                        <span class="float-right text-danger" title="This Host is flapping" style="cursor: pointer">
                            <i class="fas fa-retweet"></i>
                        </span>
                    @endif

                </td>
                
                <td>{{ $host->address }}</td>

                @switch($host->current_state)

                    @case(1)
                        <td><span class="badge badge-danger">Down</span></td>
                    @break

                    @case(2)
                        <td><span class="badge badge-unknown">Ureachable</span></td>
                    @break

                    @default

                @endswitch

                <td>{{ $host->last_check }}</td>
                <td class="description">{{ $host->output }}</td>
            </tr>


            @empty

                <tr>
                    <td colspan="5">No result found <strong>{{ request()->query('search') }}</strong></td>
                </tr>

            @endforelse

        </table>
    </div>
    
        {{ $hosts->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-4') }}

        <datalist id="hosts">
            @foreach ($hosts_names as $host)
                <option value="{{$host->display_name}}">{{$host->display_name}}</option>        
            @endforeach
        </datalist>
    
</div>

