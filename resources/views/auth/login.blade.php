@extends('layouts.app')

@section('header-title', config('app.name', 'Laravel'))

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('ログイン') }}</div>

                <div class="card-body row justify-content-center">
                    <form class="col-md-7" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mt-3">
                            <label for="login_id" class="col-md-4 col-form-label text-start">{{ __('ログインID') }}</label>

                            <div class="col-md-12">
                                <input id="login_id" type="login_id" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required autocomplete="login_id" autofocus>

                                @error('login_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-3">
                            <label for="password" class="col-md-4 col-form-label text-start">{{ __('パスワード') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('ログイン情報を保存する') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        -->

                        <div class="mt-5 mb-3 row justify-content-center">
                            <div class="">
                                <button type="submit" class="col-md-12 btn btn-primary mb-3">
                                    {{ __('ログイン') }}
                                </button>
                                <div class="text-center">
                                    <a class="link-primary"href="{{ route('register') }}">{{ __('登録がまだの方はこちら') }}</a>
                                </div>

                                <!--
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                -->
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
