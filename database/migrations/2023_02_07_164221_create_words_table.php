<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->foreignId('section_index')->comment('章番号');
            $table->string('title', 40)->comment('単語タイトル');
            $table->text('detail')->comment('単語詳細');
            $table->integer('page')->comment('ページ数');

            //外部キー制約
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('user_id')->references('id')->on('users');
        });

        //テストデータ
        for($i=0;$i<=10;$i++){
            \DB::table('words')->insert([
                'room_id' => 1,
                'user_id' => rand(1,8),
                'section_index' => 1,
                'title' => '単語1-'.$i,
                'detail' => '単語1-'.$i.'詳細',
                'page' => rand(0,100),
            ]);
        }
        for($i=0;$i<=8;$i++){
            \DB::table('words')->insert([
                'room_id' => 1,
                'user_id' => rand(1,8),
                'section_index' => 2,
                'title' => '単語2-'.$i,
                'detail' => '単語2-'.$i.'詳細',
                'page' => rand(101,200),
            ]);
        }
        for($i=0;$i<=3;$i++){
            \DB::table('words')->insert([
                'room_id' => 1,
                'user_id' => rand(1,8),
                'section_index' => 3,
                'title' => '単語3-'.$i,
                'detail' => '単語3-'.$i.'詳細',
                'page' => rand(201,300),
            ]);
        }
        for($i=0;$i<=9;$i++){
            \DB::table('words')->insert([
                'room_id' => 1,
                'user_id' => rand(1,8),
                'section_index' => 4,
                'title' => '単語4-'.$i,
                'detail' => '単語4-'.$i.'詳細',
                'page' => rand(301,400),
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
        Schema::dropIfExists('words');
    }
}
