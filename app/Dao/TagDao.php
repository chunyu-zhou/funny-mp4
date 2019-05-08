<?php

namespace App\Dao;

class TagDao extends BaseDao
{
    /**
     * 模型实例
     *
     * @var
     */
    protected $model;

    /**
     * TagDao constructor.
     */
    public function __construct()
    {
        $this->model = app("TagModel");
    }

    /**
     * 获取或新增
     *
     * @param $name
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 10:52
     */
    public function firstOrCreate($name)
    {
        //实例化模型
        $model = $this->model->firstOrCreate([
            'name' => $name,
        ]);

        return $model;
    }

    /**
     * 数据列表
     *
     * @param array $condition
     * @param array $columns
     * @param array $relatives
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 9:42
     */
    public function search($condition = [], $columns = ['*'], $relatives = [])
    {
        $model = $this->searchFilter($condition, $columns, $relatives);

        return $this->fetchRows($model);
    }
}