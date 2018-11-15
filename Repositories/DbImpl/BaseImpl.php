<?php
/**
 * Created by PhpStorm.
 * User: zhaozemin
 * Date: 2018/11/15
 * Time: 17:25
 */

namespace Wind\Fool\Repositories\DbImpl;


use Wind\Exception\RepositoryException;
use Wind\Fool\Repositories\BaseInterface;

abstract class BaseImpl implements BaseInterface
{
    protected  $model;

    public function __construct()
    {
        $this->makeModel();
    }

    abstract function model();

    public function makeModel()
    {
        $model = app($this->model());
        try{
            if (!$model instanceof Model)
                throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }catch (\Exception $e){
            return jsonReturn(ErrorConstant::ERR_MODEL_NOT_EXIST, [], $e->getMessage());
        }

        return $this->model = $model;
    }

    public function all($columns = array('*'))
    {
        return $this->model->select($columns)->all();
    }

    public function select($columns = array('*'), $conditions = [], $orderBy = [], $limit)
    {
        $model = $this->model;
        foreach ($conditions as $key => $condition)
        {
            if (is_array($condition))
            {
                $model->whereIn($key, $condition);
            } else {
                $model->whereIn($key, $condition);
            }
        }
        $model->sortBy($orderBy);
        $model->limitBy($limit);
        return $this->model->select($columns)->get();
    }

    public function paginate($columns = array('*'), $conditions = [], $orderBy = [], $perPage = 15)
    {
        $model = $this->model;
        foreach ($conditions as $key => $condition)
        {
            if (is_array($condition))
            {
                $model->whereIn($key, $condition);
            } else {
                $model->whereIn($key, $condition);
            }
        }
        $model->sortBy($orderBy);
        $model->limit($perPage);
        return $this->model->select($columns)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where($this->primaryKey, $id)->update($data);
    }

    public function updateBy(array $data, $conditions = [])
    {
        $model = $this->model;
        foreach ($conditions as $key => $condition)
        {
            if (is_array($condition))
            {
                $model->whereIn($key, $condition);
            } else {
                $model->whereIn($key, $condition);
            }
        }
        return $model->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id, $columns = '*')
    {
        return $this->model->select($columns)->findOrFail($id);
    }

    public function findBy($conditions = [], $columns = '*')
    {
        $model = $this->model;
        foreach ($conditions as $key => $condition)
        {
            if (is_array($condition))
            {
                $model->whereIn($key, $condition);
            } else {
                $model->where($key, $condition);
            }
        }
        return $model->select($columns)->first();
    }

    public function findByIdAndStatus($id, $status, $columns = '*')
    {
        $model = $this->model;
        return $model->where('id', $id)->status($status)->select($columns)->first();
    }

    public function searchByCondition(array $conditions, int $offset, int $limit, array $orderBy = ['id' => 'desc'])
    {
        $model = $this->model;
        foreach ($conditions as $key => $value)
        {
            $model->where($key, $value);
        }
        foreach ($orderBy as $key => $order)
        {
            $model->sortBy($orderBy);
        }
    }
}