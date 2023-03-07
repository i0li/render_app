<?php

namespace App\Http\Controllers\InRoom\Word;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Word;

class DeleteWordController extends Controller
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
            
            Word::where('id', $request->delete_word_id)->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/in_room_home');
    }
}
