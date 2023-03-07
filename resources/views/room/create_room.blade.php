@extends('layouts.app')

@section('back-button')
<a class="link-secondary" href="{{ url('/home') }}">
  <li class="list-group-item border-0 ms-5"><img src="img/back_icon.png" class="rounded-circle img-responsive hover-expand" width="40px"></li>
</a>
@endsection

@section('header-title', config('app.name', 'Laravel'))

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Room作成') }}</div>

                <div class="card-body row justify-content-center">
                    <form class="col-md-8" method="POST" action="{{ url('create_room') }}">
                        @csrf

                        <div class="mt-3">
                            <label for="room_name" class="col-md-5 col-form-label text-start">{{ __('Room名') }}</label>

                            <div class="col-md-12">
                                <input id="room_name" type="text" class="form-control @error('room_name') is-invalid @enderror" name="room_name" value="{{ old('room_name') }}" required autocomplete="room_name" autofocus>

                                @error('room_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-3 row align-items-start">
                          <div class="col">
                            <label for="selected_user_ids[]" class="col-md-5 col-form-label text-start">{{ __('メンバー') }}</label>
                            <div class="overflow-auto form-control" style="height:300px">
                              @foreach($users as $user)
                              <div class=" d-flex align-items-center my-3">
                                <input id="{{ $user->id }}" type="checkbox" class="checkbox-control" name="selected_user_ids[]" value="{{ $user->id }}" @if (Auth::user()->id == $user->id){{'checked disabled'}}@endif >
                                @if(Auth::user()->id == $user->id)
                                <input type="hidden" name="selected_user_ids[]" value="{{$user->id}}">
                                @endif
                                
                                <label class="form-check-label mx-3" for="{{$user->id}}">
                                  <img src="{{ $user->icon_path }}" class="border rounded-circle img-responsive me-2" width="30px">
                                  {{$user->name}}
                                </label>
                              </div>
                              @endforeach
                            </div>
                          </div>

                          <div class="col">
                            <label for="section_num" class="col-md-5 col-form-label text-start">{{ __('章数') }}</label>
                            <div class="col-md-12">
                                <input id="section_num" type="text" class="form-control @error('section_num') is-invalid @enderror" name="section_num" value="{{ old('section_num') }}" required >

                                @error('section_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="my-3">
                                <label for="page_num" class="col-md-5 col-form-label text-start">{{ __('ページ数') }}</label>

                                <div class="col-md-12">
                                    <input id="page_num" type="text" class="form-control @error('page_num') is-invalid @enderror" name="page_num" value="{{ old('page_num') }}" required >

                                    @error('page_num')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                          </div>
                        </div>


                        <div class="mt-5 mb-3 row justify-content-center">
                            <div class="">
                                <button type="submit" class="col-md-12 btn btn-primary">
                                    {{ __('作成') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection