<?php

namespace  App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();
    public function get();
    public function first();
    public function find($id);
    public function create($params);
    public function update($params, $id);
    public function delete($ids);
    public function paginate($limit = null, $columns = ['*']);
    public function orderBy($column, $direction = 'asc');
    public function where($column, $value, $operator = '=');
    public function orWhere($column, $value, $operator = '=');
}
