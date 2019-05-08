<?php

namespace App\Jobs;

use App\Dao\SourceDao;
use App\Dao\TagDao;

class SourceJob extends Job
{
    /**
     * 分类ID
     *
     * @var
     */
    protected $category_id;

    /**
     * 平台ID
     *
     * @var
     */
    protected $platform_id;

    /**
     * 平台资源ID
     *
     * @var
     */
    protected $platform_sid;

    /**
     * 标题
     *
     * @var
     */
    protected $title;

    /**
     * 封面图
     *
     * @var
     */
    protected $cover_image_url;

    /**
     * 播放地址
     *
     * @var
     */
    protected $url;

    /**
     * 浏览量
     *
     * @var
     */
    protected $view_count;

    /**
     * 标签
     *
     * @var array
     */
    protected $tags = [];


    /**
     * SourceJob constructor.
     * @param $category_id
     * @param $platform_id
     * @param $platform_sid
     * @param $title
     * @param $cover_image_url
     * @param $url
     * @param $view_count
     * @param array $tags
     */
    public function __construct($category_id, $platform_id, $platform_sid, $title, $cover_image_url, $url, $view_count, $tags = [])
    {
        $this->category_id = $category_id;
        $this->platform_id = $platform_id;
        $this->platform_sid = $platform_sid;
        $this->title = $title;
        $this->cover_image_url = $cover_image_url;
        $this->url = $url;
        $this->view_count = $view_count;
        $this->tags = array_filter($this->tags);
    }

    /**
     * @param SourceDao $source_dao
     * @param TagDao $tag_dao
     * @throws \App\Exceptions\AppException
     * @author jiangxianli
     * @created_at 2019-05-08 10:53
     */
    public function handle(SourceDao $source_dao, TagDao $tag_dao)
    {
        //存储资源
        $source_data = [
            'category_id'     => $this->category_id,
            'platform_id'     => $this->platform_id,
            'platform_sid'    => $this->platform_sid,
            'title'           => $this->title,
            'cover_image_url' => $this->cover_image_url,
            'url'             => $this->url,
            'view_count'      => $this->view_count,
        ];
        $source = $source_dao->createOrUpdate($source_data);

        //存储标签
        $tag_ids = [];
        foreach ($this->tags as $tag_name) {
            $tag_ids[] = $tag_dao->firstOrCreate($tag_name)->id;
        }

        //绑定关系
        if (!empty($tag_ids)) {
            $source->sync($tag_ids);
        }
    }
}
