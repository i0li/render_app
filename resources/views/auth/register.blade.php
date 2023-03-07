@extends('layouts.app')

@section('header-title', config('app.name', 'Laravel'))

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('新規登録') }}</div>

                <div class="card-body row justify-content-center">
                    <form class="col-md-7" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mt-3">
                            <label for="name" class="col-md-5 col-form-label text-start">{{ __('氏名') }}</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required >

                                @error('login_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-3">
                            <label for="password" class="col-md-5 col-form-label text-start">{{ __('パスワード') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-3">
                            <label for="password-confirm" class="col-md-5 col-form-label text-start">{{ __('確認用パスワード') }}</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="my-3">
                            <label class="col-md-5 form-check-label text-start">{{ __('権限') }}</label>

                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role_id" id="role_id_1" value=1>
                                    <label class="form-check-label" for="role_id_1">
                                        {{'管理者'}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role_id" id="role_id_2" value=2 checked>
                                    <label class="form-check-label" for="role_id_2">
                                        {{'一般'}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 mb-3 row justify-content-center">
                            <div class="">
                                <button type="submit" class="col-md-12 btn btn-primary">
                                    {{ __('登録') }}
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
