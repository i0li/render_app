<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id()->comment('メンバーID');
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            //外部キー制約　
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('user_id')->references('id')->on('users');
        });

        //テストデータ入力
        $test_room_id = [1, 2, 3, 4, 5, 6];
        for($i=0;$i<count($test_room_id);$i++){
            \DB::table('members')->insert([
                'room_id'   => $test_room_id[$i],
                'user_id' => 8
            ]);
            $test_user_id = [1, 2, 3, 4, 5, 6, 7];
            for($j=1;$j<=3;$j++){
                $index = array_rand($test_user_id);
                \DB::table('members')->insert([
                    'room_id'   => $test_room_id[$i],
                    'user_id' => $test_user_id[$index]
                ]);
                unset($test_user_id[$index]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
