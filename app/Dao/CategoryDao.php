<?php

namespace App\Dao;

class CategoryDao extends BaseDao
{
    /**
     * 模型实例
     *
     * @var
     */
    protected $model;

    /**
     * CategoryDao constructor.
     */
    public function __construct()
    {
        $this->model = app("CategoryModel");
    }

    /**
     * 获取或创建新记录
     *
     * @param $name
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 10:29
     */
    public function firstOrCreate($name)
    {
        return $this->model->firstOrCreate(['name' => $name]);
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