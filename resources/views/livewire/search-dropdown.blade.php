<div>
    <input type="text" wire:model="search" class="form-control">
    @if(strlen($search) >= 2 && $show)
        <div class="position-absolute w-100 " style="z-index: 99;">
            {{-- <div class="card-body"> --}}
                @if($results->count() > 0)
                    <ul class="list-group">
                        @foreach ($results as $res)
                            <li class="list-group-item show">
                                <a wire:click.prevent="setVar({{ $res->id }})" href="#">{{ $res->$field }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center">No hay resultados</p>
                @endif
            </div>
        {{-- </div> --}}
    @endif
</div>

@section('adminlte_css')
    <style>
        .show a {
            text-decoration: none;
            color: #000;
        }
        li.show:hover {
            background: #1b4ac0;
            cursor: pointer;
        }
        li.show:hover a {
            color: #FFF !important;
        }
    </style>
@endsection