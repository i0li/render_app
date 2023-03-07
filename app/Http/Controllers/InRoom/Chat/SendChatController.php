<?php

namespace App\Http\Controllers\InRoom\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Chat;
use App\Models\User;
use App\Events\SendChatEvent;

class SendChatController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'chat_contants'   => ['required',  'string']
        ]);
    }

    /**
     * Create a new room instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $selected_room_id = $request->session()->get('selected_room_id');

        try {
            DB::beginTransaction();
                
            $insert_chat = Chat::create([
                'room_id' => $selected_room_id,
                'user_id' => Auth::id(),
                'text'    => $request['chat_contants']
            ]);

            DB::commit();

            $send_user_name = User::select('name')->where('id', $insert_chat->user_id)->first();
            $send_at = Chat::select('send_at')->where('id', $insert_chat->id)->first();
            $user_icon_info = User::select('id','icon_path')->get();

            $user_icon = User::select('icon_path')
                                ->where('id', $insert_chat->user_id)
                                ->first();
            $chat_contants = [
                'user_id'   => $insert_chat->user_id,
                'room_id'   => $selected_room_id,
                'user_name' => $send_user_name->name,
                'text'      => $request['chat_contants'],
                'send_at'   => $send_at->send_at,
                'user_icon' => asset($user_icon['icon_path'])
            ];
            event(new SendChatEvent($chat_contants, $user_icon_info));
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/in_room_home');
    }
}
