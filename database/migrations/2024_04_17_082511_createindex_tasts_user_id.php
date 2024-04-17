<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateindexTastsUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tasks',function(Blueprint $table){
           $table->index('user_id'); //user_idにindexを付与
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tasks',function(Blueprint $table){
            $table->dropindex('user_id'); //付与したindexを削除
        });
    }
}
