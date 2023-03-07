<?php

namespace App\Http\Controllers\InRoom\Word;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Word;

class EditWordController extends Controller
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
            'edit_word_title'   => ['required',  'string', 'max:25'],
            'edit_page_num'     => ['required', 'integer']
        ]);
    }

    /**
     * Create a new room instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function update(Request $request)
    {
        $this->validator($request->all())->validate();
        $selected_room_id = $request->session()->get('selected_room_id');

        try {
            DB::beginTransaction();

            Word::where('id', $request->selected_word_id)->update([
                'section_index' => $request['edit_section_index'],
                'title'         => $request['edit_word_title'],
                'detail'        => $request['edit_word_detail'],
                'page'          => $request['edit_page_num']
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/in_room_home');
    }
}
