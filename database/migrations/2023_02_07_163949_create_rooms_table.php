<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id()->comment('部屋ID');
            $table->string('room_name', 50)->comment('部屋名');
            $table->integer('section_num')->comment('章数');
            $table->integer('page_num')->comment('ページ数');
        });

        //テストデータ入力
        $test_room_name = ['php入門', 'python入門', 'java入門', 'swift入門', 'golang応用', 'ruby入門'];
        $test_section_num = [12, 9, 10, 13, 7, 6];
        $test_page_num = [312, 423, 123, 213, 124, 127];
        for($i=0;$i<count($test_page_num);$i++){
            \DB::table('rooms')->insert([
                'room_name'   => $test_room_name[$i],
                'section_num' => $test_section_num[$i],
                'page_num'    => $test_page_num[$i]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
