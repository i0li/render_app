<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $default_icon_path = 'img/person_icon.png';
            
            $table->id()->comment('ユーザID');
            $table->string('name', 20)->comment('氏名');
            $table->string('icon_path')->default($default_icon_path)->comment('画像パス');
            $table->string('login_id', 10)->unique()->comment('ログインID');
            $table->string('password',  60)->comment('パスワード');
            $table->unsignedBigInteger('role_id')->comment('権限ID');
            $table->rememberToken();
            $table->timestamps();
            //外部キー制約
            $table->foreign('role_id')->references('id')->on('roles');
        });

        //テストデータ入力
        $test_user_name = ['﨑野', '久田松', '酒井', '田中', '渡部', '佐藤', '加藤'];
        $test_user_password = ['sakino', 'kudamatu', 'sakai', 'tanaka', 'watanabe', 'satou', 'katou'];
        for($i=0;$i<count($test_user_name);$i++){
            \DB::table('users')->insert([
                'name' => $test_user_name[$i],
                'login_id' => $test_user_password[$i],
                'password' => Hash::make($test_user_password[$i]),
                'role_id' => 2
            ]);
        }
        \DB::table('users')->insert([
            'name' => 'admin',
            'login_id' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
