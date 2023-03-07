<?php

namespace App\Http\Controllers\InRoom\Word;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;
use App\Models\Word;

class CreateWordController extends Controller
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
            'create_word_title'   => ['required',  'string', 'max:25'],
            'create_page_num'     => ['required', 'integer']
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
                
            $insert_room = Word::create([
                'room_id'       => $selected_room_id,
                'user_id'       => Auth::id(),
                'section_index' => $request['create_section_index'],
                'title'         => $request['create_word_title'],
                'detail'        => $request['create_word_detail'],
                'page'          => $request['create_page_num'],
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/in_room_home');
    }
}
