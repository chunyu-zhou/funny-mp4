<?php

namespace App\Business;

use App\Jobs\SourceJob;
use QL\QueryList;
use SimpleHtml\SimpleHtml;

class SpiderBuDeJieBusiness extends SpiderBusiness
{
    /**
     * 平台名称
     *
     * @var string
     */
    protected $platform = "百思不得姐";

    /**
     * 频道列表
     *
     * @var array
     */
    protected $channels = [
        [
            "name" => "搞笑",
        ],
    ];

    /**
     * 抓取地址
     *
     * @var string
     */
    protected $url = "http://www.budejie.com/video/%s";

    /**
     * 抓取
     *
     * @author jiangxianli
     * @created_at 2019-05-13 11:34
     */
    public function spider()
    {
        $platform = $this->getPlatform($this->platform);

        //打乱数组
        shuffle($this->channels);

        foreach ($this->channels as $channel) {
            //创建分类
            $category = $this->getCategory($channel['name']);
            //偏移量
            $page = 1;

            while (true) {

                //抓取链接
                $url = sprintf($this->url, $page++);
                //获取页面内容
                $page_content = $this->apiRequest($url, "GET", [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
                        'Referer'    => 'http://www.budejie.com/video/'
                    ]
                ]);
                //解析HTML
                $html = SimpleHtml::str_get_html($page_content);

                $items = [];

                //抓取节点内容
                foreach ($html->find(".j-r-list>ul>li") as $li) {
                    $video_node = $li->find(".j-video-c", 0);
                    $tool_node = $li->find(".j-r-list-tool", 0);
                    if (empty($video_node) || empty($tool_node)) {
                        continue;
                    }
                    $items[] = [
                        'id'              => $video_node->getAttribute("data-id"),
                        'title'           => $tool_node->getAttribute("data-title"),
                        'cover_image_url' => $video_node->find(".j-video", 0)->getAttribute("data-poster"),
                        'url'             => $video_node->find(".j-video", 0)->getAttribute("data-mp4"),
                        'play_times'      => $tool_node->getAttribute("data-playcount"),
                    ];

                }

                //释放资源
                $html->clear();

                if (empty($items)) {
                    break;
                }

                //资源入库
                foreach ($items as $item) {
                    dispatch(new SourceJob(
                        $category->id,
                        $platform->id,
                        $item['id'],
                        $item['title'],
                        $item['cover_image_url'],
                        $item['url'],
                        $item['play_times'],
                        []
                    ));
                }

                sleep(2);
            }
        }
    }
}