<?php

namespace App\Model;

class Source extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = "source";

    /**
     * 可填充字段
     *
     * @var array
     */
    protected $fillable = [
        'cover_image_url',
        'url',
        'category_id',
        'platform_id',
        'platform_sid',
        'status',
        'view_count'
    ];


}

