<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform', function (Blueprint $table) {
            //表字段
            $table->bigIncrements('id');
            $table->string("name")->default(0)->comment("平台名称");
            $table->integer("site_url")->default(0)->comment("站点URL");
            $table->timestamps();

            //表索引
            $table->unique("name", "name");
        });

        //表名注释
        app('db')->statement("alter table `platform` comment '资源平台表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform');
    }
}
