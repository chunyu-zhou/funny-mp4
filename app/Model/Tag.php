<?php

namespace App\Model;

class Tag extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = "tag";

    /**
     * 可填充字段
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];


}

