<?php

namespace App\Dao;

use App\Exceptions\AppException;

abstract class BaseDao
{
    /**
     * 模型实例
     *
     * @var
     */
    protected $model;

    /**
     * 新增数据
     *
     * @param array $params
     * @param array $rules
     * @return mixed
     * @throws AppException
     * @author jiangxianli
     * @created_at 2019-05-07 17:56
     */
    public function create(array $params = [], $rules = [])
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
        $model = $this->model;
        //填充数据
        $model->fill($params);
        //保存到数据库
        $model->save();

        return $model;
    }

    /**
     * 更新数据
     *
     * @param $id
     * @param array $params
     * @param array $rules
     * @return mixed
     * @throws AppException
     * @author jiangxianli
     * @created_at 2019-05-07 18:04
     */
    public function update($id, array $params = [], $rules = [])
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
        $model = $this->model->find($id);

        if (empty($model)) {
            throw new AppException(10001);
        }

        //填充数据
        $model->fill($params);
        //保存到数据库
        $model->save();

        return $model;
    }

    /**
     * 搜索
     *
     * @param array $condition
     * @param array $columns
     * @param array $relatives
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 9:25
     */
    protected function searchFilter($condition = [], $columns = ['*'], $relatives = [])
    {
        //实例化模型
        $model = $this->model->select($columns);

        $where_filter = array_only($condition, $this->fillable);

        foreach ($where_filter as $key => $value) {
            $model->where($key, $value);
        }

        if (!empty($relatives)) {
            $model->with($relatives);
        }

        return $model;
    }

    /**
     * 获取数据
     *
     * @param array $condition
     * @param $model
     * @return mixed
     * @author jiangxianli
     * @created_at 2019-05-08 9:39
     */
    protected function fetchRows($condition = [], $model)
    {
        //获取一条数据
        if (!empty($condition['fetch_first'])) {
            return $model->first();
        }

        //获取分页数据
        if (!empty($condition['page'])) {
            $page_size = isset($condition['page_size']) ? $condition['page_size'] : 15;
            return $model->paginate($page_size, ['*'], 'page', $condition['page']);
        }

        //获取全部数据
        return $model->get();
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