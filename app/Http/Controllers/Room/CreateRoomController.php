<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;

class CreateRoomController extends Controller
{
    /**
     * show all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get() ;
        return view('room.create_room', compact('users'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'room_name'   => ['required',  'string', 'max:25'],
            'section_num' => ['required', 'integer'],
            'page_num'    => ['required', 'integer']
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
  
        try {
            DB::beginTransaction();
            $insert_room = Room::create([
                'room_name' => $request['room_name'],
                'section_num' => $request['section_num'],
                'page_num' => $request['page_num'],
            ]);
            
            $insert_room_id = $insert_room->id;

            foreach($request['selected_user_ids'] as $user_id){
                Member::create([
                    'room_id' => $insert_room_id,
                    'user_id' => $user_id
                ]);
            };
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }
        return redirect('/home');
    }

}
