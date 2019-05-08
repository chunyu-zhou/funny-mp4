<?php

namespace App\Dao;

class SourceDao extends BaseDao
{
    /**
     * 模型实例
     *
     * @var
     */
    protected $model;

    /**
     * SourceDao constructor.
     */
    public function __construct()
    {
        $this->model = app("SourceModel");
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