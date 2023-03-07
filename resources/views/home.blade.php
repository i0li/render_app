@extends('layouts.app')

@section('header-title', config('app.name', 'Laravel'))

@section('custom-script')
<script src="{{ asset('js/ajax.js') }}" defer></script>
@endsection

@section('content')
<main class="py-4">

<div class="container">

    <div class="row">
        <div class="col-2"></div>
        <h1 class="col-8 display-4 text-center mt-4 mb-5">Rooms</h1>
        @if (Auth::user()->role_id == 1)
        <div class="col-2 d-flex align-items-center justify-content-center">
            <a class="link-secondary hover-expand" href="{{ url('/create_room') }}"><img src="img/plus_icon.png" class="rounded-circle img-responsive" width="30px"></a>
        </div>
        @endif
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex justify-content-evenly mb-5">
            @for ($index= 0  ; $index < count($my_rooms_info) ; $index++)
                <form class="col-3" method="POST" action="{{ url('/in_room_home') }}">
                @csrf
                    <div class=" mx-3">
                        <input type="hidden" name="selected_room_id" value="{{ $my_rooms_info[$index]->id }}">
                        <button class="col-12 border-0 rounded bg-body p-0 hover-shadow" type="submit">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="text-start col-11 my-2">{{ $my_rooms_info[$index]->room_name }}</h5>
                                    @if (Auth::user()->role_id == 1)
                                        <input formaction="{{ url('/edit_room') }}" class="hover-expand" type="image" src="img/edit_icon.png" alt="編集" width="25px" height="25px">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 row d-flex">
                                            <h6 class="col-6">{{ __('参加人数') }}</h6>
                                            <h6 class="col-6">{{ $my_room_member_num_info[$index] }}</h6>
                                        </li>
                                        <li class="list-group-item border-0 row d-flex">
                                            <h6 class="col-6">{{ __('章数') }}</h6>
                                            <h6 class="col-6">{{ $my_rooms_info[$index]->section_num }}</h6>
                                        </li>
                                        <li class="list-group-item border-0 row d-flex">
                                            <h6 class="col-6">{{ __('登録単語数') }}</h6>
                                            <h6 class="col-6">{{ $my_room_word_num_info[$index] }}</h6>
                                        </li>
                                        <li class="list-group-item border-0 row d-flex">
                                            <h6 class="col-6">{{ __('ページ数') }}</h6>
                                            <h6 class="col-6">{{ $my_rooms_info[$index]->page_num }}</h6>
                                        </h6></li>
                                    </ul>
                                </div> 
                            </div>
                        </button>
                    </div>
                </form>
        @if(($index+1)%4 === 0 and $index != 0)
                </div>
        <div class="col-md-12 d-flex justify-content-evenly mb-5">
        @endif
            @endfor
        @for ($i=0 ; $i < (4-(count($my_rooms_info))%4) ; $i++)
        <div class="col-3"></div>
        @endfor
        </div>
    </div>
</div>
</main>
@endsection
