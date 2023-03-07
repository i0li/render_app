<?php

namespace App\Http\Controllers\InRoom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;
use App\Models\Word;
use App\Models\Chat;

class InRoomHomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      
      if(session()->has('selected_room_id')){
        $selected_room_id = session('selected_room_id');
      }else{
        $selected_room_id = $request->selected_room_id;
        session(['selected_room_id' => $selected_room_id]);
      }

      $words = [];
      $selected_room_info = Room::where('id', $selected_room_id)->first() ;
      for($section_index=1; $section_index<=($selected_room_info->section_num);$section_index++){
        $words_in_section = Word::join('users','users.id','=','words.user_id')
                                ->where([
                                  ['room_id', $selected_room_info->id],
                                  ['section_index',$section_index]
                                ])
                                ->select(
                                        'words.id as word_id', 
                                        'words.section_index as section_index', 
                                        'words.title as title',
                                        'words.detail as detail',
                                        'words.page as page',
                                        'users.id as create_user_id',
                                        'users.name as create_user_name')
                                ->orderBy('words.section_index')
                                ->orderBy('words.page')
                                ->get();
        array_push($words, $words_in_section);
      }
      $chats = Chat::join('users', 'users.id','=','chats.user_id')
                    ->where('room_id', $selected_room_info->id)
                    ->select('chats.user_id as user_id',
                             'chats.text as text',
                             'chats.send_at as send_at',
                             'users.name as user_name',
                             'users.icon_path as icon_path')
                    ->orderBy('send_at')
                    ->get();
      return view('in_room.in_room_home', compact('selected_room_info', 'words', 'chats'));
    }
}
