<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileEditController extends Controller
{
    //プロフィール編集画面を表示
    public function index(Request $request)
    {
        $target_user_info = User::select('name','login_id','icon_path')
                                  ->where('id', Auth::id())->first();

        return view('profile.profile_edit', compact('target_user_info'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:10'],
            'login_id' => ['required', 'string', 'max:10', Rule::unique('users')->ignore(Auth::id())] ,
        ]);
    }

    //プロフィールの変更処理
    public function update(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            //iconの値が何も送信されていない場合は元々の前に保存していた値を使用
            $icon_path = null;
            if($request['icon'] == null){
                $icon_path_info = User::select('icon_path')
                                    ->where('id', Auth::id(),)->first();
                $icon_path = $icon_path_info->icon_path;
            }else{
                $dir = 'icon_storage';
                $file_name = $request->file('icon')->getClientOriginalName();
                $request->file('icon')->storeAs('public/' . $dir, $file_name);
                $icon_path = 'storage/' . $dir . '/' . $file_name;
            }

            User::where('id', Auth::id())->update([
                'name' => $request['name'],
                'icon_path' => $icon_path,
                'login_id' => $request['login_id']
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect('/home');
    }
}
