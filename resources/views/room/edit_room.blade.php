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
                <div class="card-header">{{ __('Room編集') }}</div>

                <div class="card-body row justify-content-center">
                    <form class="col-md-8" method="POST" action="{{ url('edit_exec') }}">
                        @csrf
                        <input type="hidden" name="selected_room_id" value="{{$selected_room_info->id}}">
                        <div class="mt-3">
                            <label for="room_name" class="col-md-5 col-form-label text-start">{{ __('Room名') }}</label>

                            <div class="col-md-12">
                                <input id="room_name" type="text" class="form-control @error('room_name') is-invalid @enderror" name="room_name" value="{{ $selected_room_info->room_name }}" required autocomplete="room_name" autofocus>

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
                                <input id="{{ $user->id }}" type="checkbox" class="checkbox-control" name="selected_user_ids[]" value="{{ $user->id }}" 
                                    @if (in_array($user->id,$selected_room_member)){{'checked '}}@endif
                                    @if (Auth::user()->id == $user->id){{'disabled '}}@endif 
                                    >
                                @if(Auth::user()->id == $user->id)
                                <input type="hidden" name="selected_user_ids[]" value="{{$user->id}}">
                                @endif
                                
                                <label class="form-check-label mx-3" for="{{$user->id}}">
                                  <img src="img/person_icon.png" class="img-responsive me-2" width="30px">
                                  {{$user->name}}
                                </label>
                              </div>
                              @endforeach
                            </div>
                          </div>

                          <div class="col">
                            <label for="section_num" class="col-md-5 col-form-label text-start">{{ __('章数') }}</label>
                            <div class="col-md-12">
                                <input id="section_num" type="text" class="form-control @error('section_num') is-invalid @enderror" name="section_num" value="{{ $selected_room_info->section_num }}" required >

                                @error('section_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="my-3">
                                <label for="page_num" class="col-md-5 col-form-label text-start">{{ __('ページ数') }}</label>

                                <div class="col-md-12">
                                    <input id="page_num" type="text" class="form-control @error('page_num') is-invalid @enderror" name="page_num" value="{{ $selected_room_info->page_num }}" required >

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
                            <div class="col-md-6">
                                <button type="submit" class="col-md-12 me-3 btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a class="col-md-12 ms-3 btn btn-danger" data-toggle="modal" data-target="#delete_confirm_modal">
                                    {{ __('削除') }}
                                </a>
                            </div>
                    
                        </div>

                    <!-- 削除確認モーダル -->
                    <div class="modal fade" id="delete_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">削除確認画面</h4>
                                </div>
                                <div class="modal-body">
                                    <label>このRoomを削除しますか？</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger" formaction="{{ url('delete_exec') }}">削除</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

@endsection