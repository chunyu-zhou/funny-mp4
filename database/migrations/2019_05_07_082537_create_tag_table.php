<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {
            //表字段
            $table->bigIncrements('id');
            $table->string("name")->default("")->comment("分类名称");
            $table->enum("status", ["normal", "hidden"])->default("hidden")->comment("显示状态");
            $table->timestamps();

            //表索引
            $table->unique("name", "name");
        });

        //表名注释
        app('db')->statement("alter table `tag` comment '标签表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag');
    }
}
