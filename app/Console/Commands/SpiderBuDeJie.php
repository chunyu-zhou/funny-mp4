<?php

namespace App\Console\Commands;

use App\Business\SpiderBuDeJieBusiness;
use Illuminate\Console\Command;

class SpiderBuDeJie extends Command
{
    /**
     * 命令行执行命令
     *
     * @var string
     */
    protected $signature = 'command:spider-bu-de-jie';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = '抓取百思不得姐相关视频';

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
     * @param SpiderBuDeJieBusiness $business
     * @author jiangxianli
     * @created_at 2019-05-13 14:34
     */
    public function handle(SpiderBuDeJieBusiness $business)
    {
        $business->spider();
    }
}