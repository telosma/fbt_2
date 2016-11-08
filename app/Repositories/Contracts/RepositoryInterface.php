<?php

namespace  App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();
    public function get($columns = ['*']);
    public function first();
    public function find($id);
    public function lists($column, $key = null);
    public function create($params);
    public function update($params, $id);
    public function delete($ids);
    public function paginate($limit = null, $columns = ['*']);
    public function orderBy($column, $direction = 'asc');
    public function where($column, $value, $operator = '=');
    public function orWhere($column, $value, $operator = '=');
    public function whereIn($column, $values, $boolean = 'and', $not = false);
    public function withCount($relations);
    public function with($relations);
    public function remove();
    public function select($columns = ['*']);
    public function limit($value);
    public function whereBetween($column, array $values, $boolean = 'and', $not = false);
    public function whereRaw($sql, array $bindings = [], $boolean = 'and');
}
