<?php

namespace App\Business;

use App\Dao\CategoryDao;
use App\Dao\PlatformDao;
use App\Exceptions\AppException;
use GuzzleHttp\Client;

class SpiderBusiness extends BaseBusiness
{
    /**
     * 平台DAO
     *
     * @var PlatformDao
     */
    protected $platform_dao;

    /**
     * 分类DAO
     *
     * @var CategoryDao
     */
    protected $category_dao;

    /**
     * 构造函数
     *
     * SpiderBusiness constructor.
     * @param PlatformDao $platform_dao
     * @param CategoryDao $category_dao
     */
    public function __construct(PlatformDao $platform_dao, CategoryDao $category_dao)
    {
        $this->platform_dao = $platform_dao;
        $this->category_dao = $category_dao;
    }

    /**
     * 接口请求
     *
     * @param $url
     * @param $method
     * @param array $options
     * @return string
     * @throws AppException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author jiangxianli
     * @created_at 2019-05-08 10:11
     */
    public function apiRequest($url, $method, $options = [])
    {
        //实例化客户端
        $client = new Client();
        //发送请求
        $response = $client->request($method, $url, $options);
        //请求状态判断
        if ($response->getStatusCode() != 200) {
            throw new AppException(30000, [$url, $method]);
        }

        //响应数据
        $contents = $response->getBody()->getContents();

        return $contents;
    }

    /**
     * 获取平台
     *
     * @param $name
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 10:30
     */
    public function getPlatform($name)
    {
        return $this->platform_dao->firstOrCreate($name);
    }

    /**
     * 获取分类
     *
     * @param $name
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 10:30
     */
    public function getCategory($name)
    {
        return $this->category_dao->firstOrCreate($name);
    }
}