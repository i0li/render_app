@extends('layouts.app')

@section('header-title', config('app.name', 'Laravel'))

@section('back-button')
<a class="link-secondary" href="{{ url('/home') }}">
  <li class="list-group-item border-0 ms-5"><img src="img/back_icon.png" class="rounded-circle img-responsive hover-expand" width="40px"></li>
</a>
@endsection

@section('custom-script')
<script src="{{ asset('js/profile_edit.js') }}" defer></script>
@endsection

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('プロフィール編集') }}</div>

                <div class="card-body row justify-content-center">
                    <form class="col-md-7" method="POST" action="{{ route('edit_profile_exec') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- アイコン用フォーム -->
                        <div class="mt-3">
                              <div class='d-flex justify-content-center'>
                                <img id="icon-preview" src="{{ asset($target_user_info->icon_path)}}" class="border rounded-circle img-responsive my-3" width="120px">
                              </div>
                              <input id="icon" type="file" class="form-control col-3" name="icon" accept='.jpg, .jpeg, .png'>
                        <div>

                        <div class="mt-3">
                            <label for="name" class="col-md-5 col-form-label text-start">{{ __('氏名') }}</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $target_user_info->name }}" required>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-3">
                            <label for="login_id" class="col-md-5 col-form-label text-start">{{ __('ログインID') }}</label>

                            <div class="col-md-12">
                                @if(! $errors->has('login_id'))
                                <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ $target_user_info->login_id }}" required >
                                @endif
                                @error('login_id')
                                  <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required >
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 mb-3 row justify-content-center">
                            <div class="">
                                <button type="submit" class="col-md-12 btn btn-primary">
                                    {{ __('更新') }}
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
