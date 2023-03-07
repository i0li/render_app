<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id()->comment('チャットID');
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->text('text')->comment('テキスト');
            $table->timestamp('send_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('送信日時');
            //外部キー制約
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('user_id')->references('id')->on('users');
        });

        //テストデータ
        $dummy_messages = ['こんにちは', 'おはようございます', 'こんばんは', '今日の天気は晴れです', 'ブラボー！', 'え？4時間！？', '電車で行く？', '高速道路で行けば2時間', '熱海いきたい', '電車だと2時間で2200円', '海鮮丼食べたい' ,'明日天気になーれ'];
        for($i=0;$i<=30;$i++){
            \DB::table('chats')->insert([
                'room_id' => 1,
                'user_id' => rand(1,8),
                'text' => $dummy_messages[rand(0,7)],
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
        Schema::dropIfExists('chats');
    }
}
