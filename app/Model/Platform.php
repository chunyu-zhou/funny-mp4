<?php

namespace App\Model;

class Platform extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = "platform";

    /**
     * 可填充字段
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'site_url',
    ];


}

