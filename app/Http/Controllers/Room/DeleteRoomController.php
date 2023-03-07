<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Room;

class DeleteRoomController extends Controller
{
    /**
     * delete room info
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            
            Member::where('room_id', $request->selected_room_id)->delete();
            Room::where('id', $request->selected_room_id)->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/home');
    }
}
