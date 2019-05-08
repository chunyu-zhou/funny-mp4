<?php

namespace App\Model;

class Category extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = "category";

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

