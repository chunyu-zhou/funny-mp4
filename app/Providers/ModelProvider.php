<?php

namespace App\Providers;

use App\Model\Category;
use App\Model\Platform;
use App\Model\Source;
use App\Model\SourceTag;
use App\Model\Tag;
use Illuminate\Support\ServiceProvider;

class ModelProvider extends ServiceProvider
{
    /**
     * 延迟加载
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 服务绑定
     *
     * @author jiangxianli
     * @created_at 2019-05-07 17:14
     */
    public function register()
    {
        $this->app->bind('SourceModel', Source::class);
        $this->app->bind('TagModel', Tag::class);
        $this->app->bind('SourceTagModel', SourceTag::class);
        $this->app->bind('CategoryModel', Category::class);
        $this->app->bind('PlatformModel', Platform::class);
    }

    /**
     * 服务注册
     *
     * @return array
     * @author jiangxianli
     * @created_at 2019-05-07 17:12
     */
    public function provides()
    {
        $provides_arr = array();
        $provides_arr[] = 'SourceModel';
        $provides_arr[] = 'TagModel';
        $provides_arr[] = 'SourceTagModel';
        $provides_arr[] = 'CategoryModel';
        $provides_arr[] = 'PlatformModel';
        return $provides_arr;
    }
}
