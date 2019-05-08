<?php

namespace App\Model;

class SourceTag extends BaseModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = "source_tag";

    /**
     * 可填充字段
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'tag_id',
    ];


}

