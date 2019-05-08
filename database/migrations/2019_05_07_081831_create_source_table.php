<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source', function (Blueprint $table) {
            //表字段
            $table->bigIncrements('id')->comment("主键ID");
            $table->string("title")->default("")->comment("标题");
            $table->string("cover_image_url")->default("")->comment("封面图地址");
            $table->string("url")->default("")->comment("资源链接地址");
            $table->integer("category_id")->default(0)->comment("分类ID");
            $table->integer("platform_id")->default(0)->comment("平台ID");
            $table->string("platform_sid")->default("")->comment("平台资源ID");
            $table->enum("status", ["normal", "hidden"])->default("hidden")->comment("显示状态");
            $table->integer("view_count")->default(0)->comment("观看次数");
            $table->timestamps();

            //表索引
            $table->unique(["platform_id", "platform_sid"], "u_platform_sid");
            $table->unique("url", "url");
            $table->index("category_id", "category_id");
            $table->index("platform_id", "platform_id");
            $table->index("platform_sid", "platform_sid");
        });

        //表名注释
        app('db')->statement("alter table `source` comment '资源表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source');
    }
}
