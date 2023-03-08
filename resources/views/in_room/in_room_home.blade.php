@extends('layouts.app')

@section('custom-script')
<script src="{{ asset('js/myscript.js') }}"></script>
<script>
  let words = @json($words);
  let login_user_id = @json(Auth::user()->id);
  let current_room_id = @json($selected_room_info->id);
</script>
@endsection

@section('back-button')
<a class="link-secondary" href="{{ url('/home') }}">
  <li class="list-group-item border-0 ms-5"><img src="img/back_icon.png" class="rounded-circle img-responsive hover-expand" width="40px"></li>
</a>
@endsection

@section('header-title', $selected_room_info->room_name)

@section('content')
<main class="py-0 overflow-hidden">
<div id='in_room_area' class="container mx-0">
  <div class="row h-100 vw-100">
    <!---------------------------------------- 
                     単語帳エリア
    ----------------------------------------->
    <div id='word_area' class="col-6 m-0 p-0 border-end border-secondary border-2">
      <!-------------------- 単語詳細モーダル -------------------->
      <div id="word-info-modal-content" class='py-3 px-5'>
        <div class='text-end'>
          <img src="img/close_icon.png" class="rounded-circle img-responsive hover-expand word-modal-close" width="30px">
        </div>
        <div id='word-info-contant' class='pt-3'>
          <div class='row'>
            <div id='word-info-user-name' class="col-6 "><h5>user_name</h5></div>
            <div id='word-info-page-num' class="col-6 text-end"><h5>p.create_page_num</h5></div>
          </div>
          <div class='row border-bottom border-1 border-dark pt-5'>
            <div id='word-info-title' class='col-6'><h3>word-title</h3></div>
            <div id='search-google-link' class='col-6 text-end pe-3'>
              <a target="_blank" rel="noopener noreferrer"><img src="img/google_icon.png" class='hover-expand' width="30px"></a>
            </div>
          </div>
          <div id='word-info_detail' class='pt-5' style="overflow:auto;"></div>
        </div>
      </div>
      
      <!-------------------- 単語登録モーダル -------------------->
      @if($errors->has('create_word_title') || $errors->has('create_page_num') || $errors->has('create_word_detail'))
      <div id="create-word-modal-content" class='py-3 px-5' style="display : block;">
      @else
      <div id="create-word-modal-content" class='py-3 px-5' style="display : none;">
      @endif
        <div class='text-end'>
          <img src="img/close_icon.png" class="rounded-circle img-responsive hover-expand word-modal-close" width="30px">
        </div>

        <div id='create-word-contant' class=''>
          <form class="justify-content-center" method="POST" action="{{ url('create_word') }}">
          @csrf
            <div class='text-center w-100'><h3 class='mb-0'>{{ '単語登録' }}</h3></div>
            <!--単語名　入力フォーム-->
            <div class="pt-3 row align-items-center">
              <label for="create_word_title" class="col-md-5 col-form-label text-start">{{ '単語' }}</label>
              <div class="col-md-12">
                  <input id="create_word_title" type="text" class="form-control @error('create_word_title') is-invalid @enderror" name="create_word_title" value="{{ old('create_word_title') }}" required autocomplete="word_ttile">
                  @error('create_word_title')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>
            <!-- 章　ページ　入力フォーム -->
            <div class="pt-3 row align-items-cente">
              <div class='col-6 px-3'>
                <label for="create_section_index" class="col-md-5 col-form-label text-start">{{ '章' }}</label>
                <select id="create_section_index" class="form-select" name="create_section_index">
                  @for($section_index=1;$section_index<=(count($words));$section_index++)
                    @if($section_index == old('create_section_index'))
                      <option value={{$section_index}} selected>{{$section_index}}章</option>
                    @else
                      <option value={{$section_index}}>{{$section_index}}章</option>
                    @endif
                  @endfor
                </select>
              </div>
              <div class='col-6 px-3'>
                <label for="create_page_num" class="col-md-5 col-form-label text-start">{{ 'ページ数' }}</label>
                <div class="col-md-12">
                    <input id="create_page_num" type="text" class="form-control @error('create_page_num') is-invalid @enderror" name="create_page_num" value="{{ old('create_page_num') }}" required autocomplete="create_page_num">
                    @error('create_page_num')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
            </div>
            <!-- 単語詳細説明　入力フォーム -->
            <div class="pt-3 row align-items-center">
              <label for="create_word_detail" class="col-md-5 col-form-label text-start">{{ '説明' }}</label>
              <div class="col-md-12">
                <textarea id="create_word_detail" class="form-control @error('create_word_detail') is-invalid @enderror h-30 word_detail" name="create_word_detail" required autocomplete="create_word_detail">{{ old('create_word_detail') }}</textarea>
                @error('create_word_detail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <!-- 登録ボタン -->
            <div class="pt-5 row align-items-center">
              <div class="col-md-12">
                <button type="submit" class="w-100 btn btn-primary">
                    {{ __('登録') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-------------------- 単語編集モーダル -------------------->
      @if($errors->has('edit_word_title') || $errors->has('edit_page_num') || $errors->has('edit_word_detail'))
      <div id="edit-word-modal-content" class='py-3 px-5' style="display : block;">
      @else
      <div id="edit-word-modal-content" class='py-3 px-5' style="display : none;">
      @endif
        <div class='text-end'>
          <img src="img/close_icon.png" class="rounded-circle img-responsive hover-expand word-modal-close" width="30px">
        </div>

        <div id='edit-word-contant' class=''>
          <form class="justify-content-center" method="POST" action="{{ url('edit_word') }}">
          @csrf
            <input id='selected_word_id' type="hidden" name="selected_word_id">
            <div class='text-center w-100'><h3 class='mb-0'>{{ '単語編集' }}</h3></div>
            <!--単語名　入力フォーム-->
            <div class="pt-3 row align-items-center">
              <label for="edit_word_title" class="col-md-5 col-form-label text-start">{{ '単語' }}</label>
              <div class="col-md-12">
                  <input id="edit_word_title" type="text" class="form-control @error('edit_word_title') is-invalid @enderror" name="edit_word_title" value="{{ old('edit_word_title') }}" required autocomplete="word_ttile" autofocus>
                  @error('edit_word_title')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>
            <!-- 章　ページ　入力フォーム -->
            <div class="pt-3 row align-items-cente">
              <div class='col-6 px-3'>
                <label for="edit_section_index" class="col-md-5 col-form-label text-start">{{ '章' }}</label>
                <select id="edit_section_index" class="form-select" name="edit_section_index">
                  @for($section_index=1;$section_index<=(count($words));$section_index++)
                    @if($section_index == old('edit_section_index'))
                      <option value={{$section_index}} selected>{{$section_index}}章</option>
                    @else
                      <option value={{$section_index}}>{{$section_index}}章</option>
                    @endif
                  @endfor
                </select>
              </div>
              <div class='col-6 px-3'>
                <label for="edit_page_num" class="col-md-5 col-form-label text-start">{{ 'ページ数' }}</label>
                <div class="col-md-12">
                    <input id="edit_page_num" type="text" class="form-control @error('edit_page_num') is-invalid @enderror" name="edit_page_num" value="{{ old('edit_page_num') }}" required autocomplete="edit_page_num">
                    @error('edit_page_num')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
            </div>
            <!-- 単語詳細説明　入力フォーム -->
            <div class="pt-3 row align-items-center">
              <label for="edit_word_detail" class="col-md-5 col-form-label text-start">{{ '説明' }}</label>
              <div class="col-md-12">
                <textarea id="edit_word_detail" class="form-control @error('edit_word_detail') is-invalid @enderror h-30 word_detail" name="edit_word_detail" required autocomplete="edit_word_detail">{{ old('edit_word_detail') }}</textarea>
                @error('edit_word_detail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <!-- 登録ボタン -->
            <div class="pt-5 row align-items-center">
              <div class="col-md-6">
                <button type="submit" class="col-md-12 btn btn-primary">
                    {{ __('更新') }}
                </button>
              </div>
              <div class="col-md-6">
                <div id='delete-word-confirm-modal-open' class="col-md-12 btn btn-danger">
                    {{ __('削除') }}
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-------------------- 単語削除確認モーダル -------------------->
      <div id="delete-word-confirm-modal-content" class='py-3 px-5'>
        <div id='delete-word-info-contant' class='pt-3'>
          <input id='selected_word_index' type="hidden">
          <div class='text-center w-100'><h3 class='pt-5'>{{ 'この単語を削除しますか？' }}</h3></div>
          <div class='row border-bottom border-1 border-dark pt-5'>
            <div id='delete-word-info-title' class='col-12'><h3>word-title</h3></div>
          </div>
          <div id='delete-word-info-detail' class='pt-5 word_detail' style="overflow:auto;"></div>
        </div>
        <form class="justify-content-center pt-5" method="POST" action="{{ url('/delete_word') }}">
          <input id='delete_word_id' type="hidden" name='delete_word_id' >
          <div class="pt-5 row align-items-center">
            @csrf
            <div class="col-md-6">
              <div class="col-md-12 btn btn-secondary word-modal-close">
                  {{ __('閉じる') }}
              </div>
            </div>
            <div class="col-md-6">
              <button type="submit" class="col-md-12 btn btn-danger">
                {{ __('削除') }}
              </button>
            </div>  
          </div>
        </form>
      </div>
      <!------------------------------------------------------>

      <div id='word_area_header' class="row bg-gray my-sticky-top w-100 mx-0 px-3 py-3 border-bottom border-gray border-2 d-flex align-items-center">

      <!-- 検索フォーム -->
        <div class="col-6">
          <input id='search-word' type='text' class='form-control' placeholder="キーワード検索">
        </div>
        <!-- 章による絞り込み検索 -->
        <div class="col-4">
          <select id="search-section" class="form-select">
            <option value="default" selected>{{ '全章' }}</option>
            @for($section_index=1;$section_index<=(count($words));$section_index++)
              <option value={{$section_index}}>{{$section_index}}章</option>
            @endfor
          </select>
        </div>
        <!-- 単語追加ボタン -->
        <div class="col-2 text-end">
          <div id="create-word-modal-open"><img src="img/plus_icon.png" class="rounded-circle img-responsive hover-expand" width="30px"></div>
        </div>
      </div>

      <!--単語表示エリア-->
      <div id='word_area_contents' style="overflow:auto;">
        @for($section_index=0;$section_index<(count($words));$section_index++)
          <div class='section-area'>
            <h3 class='px-3 pt-4 pb-2 my-0 border-bottom section_title bg-white'>{{$section_index + 1}}章</h3>
            @if(count($words[$section_index])!=0)
              @for($word_index=0;$word_index<(count($words[$section_index]));$word_index++)
                <div class='row w-100 mx-0 px-2 py-2 border-bottom border-gray border-1 align-items-center hover-white word-info word-info-modal-open' style="height:50px">
                  <input type='hidden' class='selected_word' value="{{ $section_index.','.$word_index }}">
                  <div class="col-8 text-start word-title">{{ $words[$section_index][$word_index]->title }}</div>
                  <div class="col-2 text-end word-page">p.{{ $words[$section_index][$word_index]->page }}</div>
                  <div class="col-2 text-end word-user_name d-flex flex-row-reverse align-items-center">
                    @if(Auth::user()->id == $words[$section_index][$word_index]->create_user_id)
                      <input class="hover-expand edit_selected_word edit-word-modal-open" type="image" src="img/edit_icon.png" value="{{ $section_index.','.$word_index }}" alt="編集" width="25px" height="25px">
                    @else
                      {{ $words[$section_index][$word_index]->create_user_name }}
                    @endif
                  </div>
                </div>
              @endfor
            @endif
          </div>
        @endfor
      </div>
    </div>

    <!----------------------------------------
                   チャットエリア
    ----------------------------------------->
    <div id='chat_area' class="col-6 m-0 p-0">
      <div id="chat_area_contants" class="px-0" style="overflow:auto;">
        @foreach($chats as $chat)
          @if(Auth::user()->id == $chat->user_id)
            <div class="message_box w-100 text-end">
              <div class='d-flex flex-row-reverse ms-3 mt-3 text-secondary'>
                <div class='pe-3'>{{$chat->send_at}}</div>
              </div>
              <div class="bg-white me-3 px-3 py-2 alert alert-secondary message-box">
                {!! nl2br(e($chat->text)) !!}
              </div>
            </div>
          @else
            <div class="message_box w-100">
              <div class='d-flex flex-row ms-3 mt-3 text-secondary align-items-center pb-1'>
                <img src="{{ asset($chat->icon_path) }}" class="border rounded-circle img-responsive me-2" width="30px">
                <div class='pe-2'>{{$chat->user_name}}</div>
                <div class='pe-2'>{{$chat->send_at}}</div>
              </div>
              <div class="bg-white ms-3 px-3 py-2 alert alert-secondary message-box">
                {!! nl2br(e($chat->text)) !!}
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div id="chat_send_form_area" class="border-top bg-white border-gray border-2 px-3 py-2">
        <form name='chat_form' action="{{ url('send_chat') }}" method="POST" class='d-flex message-form align-items-end'>
        @csrf
          @if($errors->has('chat_contants'))
            <textarea id="chat_contants" name="chat_contants" class="form-control me-3" id="exampleFormControlTextarea1" rows="1" autofocus ></textarea>
          @else
            <textarea id="chat_contants" name="chat_contants" class="form-control me-3" id="exampleFormControlTextarea1" rows="1"></textarea>
          @endif
          <div class="">
            <input id="chat_send_button" class="hover-expand" type="image" src="img/send_icon.png" alt="送信" width="30px" height="30px" >
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</main>
@endsection

@section('modal-overlay')
  @if($errors->any() &&  !$errors->has('chat_contants'))
  <div id="modal-overlay" style='display:block;'></div>
  @endif
@endsection
