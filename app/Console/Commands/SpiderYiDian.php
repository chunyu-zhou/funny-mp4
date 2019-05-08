<?php

namespace App\Console\Commands;

use App\Business\SpiderYiDianZiXunBusiness;
use Illuminate\Console\Command;

class SpiderYiDian extends Command
{
    /**
     * 命令行执行命令
     *
     * @var string
     */
    protected $signature = 'command:spider-yi-dian';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = '抓取一点资讯相关视频';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param SpiderYiDianZiXunBusiness $business
     * @throws \App\Exceptions\AppException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author jiangxianli
     * @created_at 2019-05-08 11:22
     */
    public function handle(SpiderYiDianZiXunBusiness $business)
    {
        $business->spider();
    }
}