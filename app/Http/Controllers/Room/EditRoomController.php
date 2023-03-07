<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;

class EditRoomController extends Controller
{
    /**
     * show selected room info
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(session()->has('edit_selected_room_id')){
            $selected_room_id = session('edit_selected_room_id');
          }else{
            $selected_room_id = $request->selected_room_id;
            session(['edit_selected_room_id' => $selected_room_id]);
          }
        $users = User::orderBy('name')->get() ;
        $selected_room_info = Room::where('id', $selected_room_id)->first() ;
        $selected_room_member_result = Member::select('user_id')->where('room_id', $request->selected_room_id)->orderBy('user_id')->get();
        $selected_room_member = array();
        foreach($selected_room_member_result as $user_id){
            array_push($selected_room_member, $user_id->user_id);
        }
        return view('room.edit_room', compact('users', 'selected_room_info', 'selected_room_member'));
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
     *  update room info
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            Room::where('id', $request->selected_room_id)->update([
                'room_name' => $request['room_name'],
                'section_num' => $request['section_num'],
                'page_num' => $request['page_num'],
            ]);

            Member::where('room_id', $request->selected_room_id)->delete();
            foreach($request['selected_user_ids'] as $user_id){
                Member::create([
                    'room_id' => $request->selected_room_id,
                    'user_id' => $user_id
                ]);;
            }

            DB::commit();
            session()->forget('edit_selected_room_id');
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/home');
    }
}
