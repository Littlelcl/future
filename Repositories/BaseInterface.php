<?php
/**
 * Created by PhpStorm.
 * User: zhaozemin
 * Date: 2018/11/15
 * Time: 17:22
 */

namespace Wind\Fool\Repositories;


interface BaseInterface
{
    //未审核
    const STATUS_UN_CHECK = 0;
    //审核通过
    const STATUS_PUBLISH = 1;
    public function all($columns = array('*'));
    public function select($columns = array('*'), $conditions = [], $orderBy = [], $limit);
    public function paginate($columns = array('*'), $conditions = [], $orderBy = [], $perPage = 15);
    public function create(array $data);
    public function update(array $data, $id);
    public function updateBy(array $data, $conditions = []);
    public function delete($id);
    public function find($id, $columns = '*');
    public function findBy($conditions = [], $column = '*');
    /**
     * 通过id和status找到model
     * @param $id
     * @param $status
     * @param string $columns
     * @return mixed
     */
    function findByIdAndStatus($id, $status, $columns = '*');

    /**
     * 条件搜索
     * @param array $conditions
     * @param int $offset
     * @param int $limit
     * @param array $orderBy
     * @return mixed
     */
    function searchByCondition(array $conditions, int $offset, int $limit, array $orderBy = ['id' => 'desc']);
}