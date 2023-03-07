<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;
use App\Models\Word;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(session()->has('selected_room_id')){
            session()->forget('selected_room_id');
            session()->forget('edit_selected_room_id');
        }
        $my_room_ids = Member::select('room_id')->where('user_id', Auth::id())->orderBy('room_id')->get() ;
        $my_rooms_info = Room::whereIn('id', $my_room_ids)->orderBy('id')->get();
        $my_room_member_num_info = array();
        $my_room_word_num_info = array();
        foreach($my_room_ids as $my_room_id){
            $member_num = Member::where('room_id', $my_room_id['room_id'])->count();
            array_push($my_room_member_num_info, $member_num);
            
            $word_num = Word::where('room_id', $my_room_id['room_id'])->count();
            array_push($my_room_word_num_info, $word_num);
        }
        return view('home', compact('my_rooms_info', 'my_room_member_num_info', 'my_room_word_num_info'));
    }
}
