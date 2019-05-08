<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_tag', function (Blueprint $table) {
            //表字段
            $table->bigIncrements('id');
            $table->integer("tag_id")->default(0)->comment("标签ID");
            $table->integer("source_id")->default(0)->comment("资源ID");

            //表索引
            $table->index("tag_id", "tag_id");
            $table->index("source_id", "source_id");
        });

        //表名注释
        app('db')->statement("alter table `source_tag` comment '资源标签表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_tag');
    }
}
