<?php

namespace App\Dao;

use App\Exceptions\AppException;

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
     * 新增或更新数据
     *
     * @param array $params
     * @return mixed
     * @throws AppException
     * @author jiangxianli
     * @created_at 2019-05-07 17:56
     */
    public function createOrUpdate(array $params = [])
    {
        if (!empty($rules)) {
            //参数校验
            $validate = app('validator')->make($params, $rules);
            //参数校验失败
            if ($validate->fails()) {
                throw new AppException(10000, $validate->messages());
            }
        }
        //实例化模型
        $model = $this->model->firstOrCreate([
            'platform_id'  => $params['platform_id'],
            'platform_sid' => $params['platform_sid'],
        ]);
        //填充数据
        $model->fill($params);
        //保存到数据库
        $model->save();

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