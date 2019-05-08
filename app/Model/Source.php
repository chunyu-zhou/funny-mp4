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
        'title',
        'url',
        'category_id',
        'platform_id',
        'platform_sid',
        'status',
        'view_count'
    ];

    /**
     * 关联Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author jiangxianli
     * @created_at 2019-05-08 10:56
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'source_tag', 'tag_id', 'source_id');
    }


}

