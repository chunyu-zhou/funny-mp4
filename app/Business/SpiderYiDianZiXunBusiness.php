<?php

namespace App\Business;

use App\Jobs\SourceJob;

class SpiderYiDianZiXunBusiness extends SpiderBusiness
{
    /**
     * 平台名称
     *
     * @var string
     */
    protected $platform = "一点资讯";

    /**
     * 频道列表
     *
     * @var array
     */
    protected $channels = [
        [
            "name"       => "搞笑",
            "channel_id" => "v24744"
        ],
        [
            "name"       => "社会",
            "channel_id" => "v25350"
        ],
        [
            "name"       => "生活",
            "channel_id" => "v25460"
        ],
        [
            "name"       => "影视",
            "channel_id" => "v25834"
        ],
        [
            "name"       => "综艺",
            "channel_id" => "v25328"
        ],
        [
            "name"       => "音乐",
            "channel_id" => "v25443"
        ],
        [
            "name"       => "明星",
            "channel_id" => "v25359"
        ],
        [
            "name"       => "草根",
            "channel_id" => "v33907"
        ],
        [
            "name"       => "猎奇",
            "channel_id" => "v25450"
        ],
        [
            "name"       => "科技",
            "channel_id" => "v25338"
        ],
        [
            "name"       => "游戏",
            "channel_id" => "v25430"
        ],
        [
            "name"       => "军事",
            "channel_id" => "v25352"
        ],
        [
            "name"       => "体育",
            "channel_id" => "v25362"
        ],
        [
            "name"       => "萌宠",
            "channel_id" => "t24745"
        ],
        [
            "name"       => "动物",
            "channel_id" => "v25456"
        ],
    ];

    /**
     * 抓取地址
     *
     * @var string
     */
    protected $url = "https://www.yidianzixun.com/home/q/news_list_for_channel";

    /**
     * 抓取
     *
     * @throws \App\Exceptions\AppException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author jiangxianli
     * @created_at 2019-05-08 11:19
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
            $c_start = 0;

            while (true) {

                $params = [
                    'channel_id' => $channel['channel_id'],
                    'cstart'     => $c_start,
                    'cend'       => $c_start + 10,
                    'infinite'   => 'true',
                    'refresh'    => 1,
                    '__from__'   => 'pc',
                    'multi'      => 5,
                    'appid'      => "web_yidian",
                    "_"          => time(),
                    '_spt'       => $this->makeSign($channel['channel_id'], $c_start, $c_start + 10)
                ];
                //抓取链接
                $url = $this->url . '?' . http_build_query($params);
                //抓取数据
                $result = $this->apiRequest($url, "GET", [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
                        'Referer'    => 'https://www.yidianzixun.com/channel/' . $channel['channel_id'] . '?s=13&appid=yidian&ver=4.9.6.1&utk=eyustbqb'
                    ]
                ]);
                $result = (array)json_decode($result, true);
                if (empty($result['result'])) {
                    break;
                }

                foreach ($result['result'] as $item) {
                    $tags = [];
                    if (!empty($item['vsct_show']) && is_array($item['vsct_show'])) {
                        $tags = $item['vsct_show'];
                    }
                    dispatch(new SourceJob(
                        $category->id,
                        $platform->id,
                        $item['wemedia_id'],
                        $item['title'],
                        sprintf("https://i1.go2yd.com/image.php?type=thumbnail_336x216&url=%s", $item['image']),
                        $item['video_url'],
                        $item['play_times'],
                        $tags
                    ));
                }

                $c_start += 10;

                sleep(rand(2, 5));
            }
        }
    }

    /**
     * 字符转码
     *
     * @param $string
     * @return null|string|string[]
     * @author jiangxianli
     * @created_at 2019-05-08 13:53
     */
    function mb_html_entity_decode($string)
    {
        if (extension_loaded('mbstring') === true) {
            mb_language('Neutral');
            mb_internal_encoding('UTF-8');
            mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));

            return mb_convert_encoding($string, 'UTF-8', 'HTML-ENTITIES');
        }

        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

    /**
     * 字符转Unicode编码
     *
     * @param $string
     * @return int
     * @author jiangxianli
     * @created_at 2019-05-08 13:52
     */
    function mb_ord($string)
    {
        if (extension_loaded('mbstring') === true) {
            mb_language('Neutral');
            mb_internal_encoding('UTF-8');
            mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));

            $result = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));

            if (is_array($result) === true) {
                return $result[1];
            }
        }

        return ord($string);
    }

    /**
     * unicode编码转字符
     *
     * @param $string
     * @return null|string|string[]
     * @author jiangxianli
     * @created_at 2019-05-08 13:53
     */
    function mb_chr($string)
    {
        return $this->mb_html_entity_decode('&#' . intval($string) . ';');
    }

    /**
     * 生成抓取签名
     *
     * @param $channel_id
     * @param $c_start
     * @param $c_end
     * @return string
     * @author jiangxianli
     * @created_at 2019-05-08 13:52
     */
    public function makeSign($channel_id, $c_start, $c_end)
    {
        $token = "sptoken" . $channel_id . $c_start . $c_end;

        $token_arr = str_split($token);

        $sign = "";

        for ($i = 0; $i < count($token_arr); $i++) {
            $code = 10 ^ $this->mb_ord($token_arr[$i]);
            $sign .= $this->mb_chr($code);
        }

        return $sign;
    }
}