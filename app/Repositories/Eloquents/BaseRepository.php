<?php

namespace App\Repositories\Eloquents;

use Exception;
use DB;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $app;

    public function __construct()
    {
        $this->app = new Application;
    }

    public abstract function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        return $this->model = $model;
    }

    public function resetModel()
    {
        $this->makeModel();
    }

    public function all()
    {
        try {
            $data = $this->model->all();
            if (!$data) {
                return [
                    'status' => false,
                    'message' => trans('messages.db_null'),
                ];
            }

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch(Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function get()
    {
        try {
            $data = $this->model->get();
            $this->resetModel();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function first()
    {   
        try {
            $data = $this->model->first();
            $this->resetModel();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function find($id)
    {
        try {
            $data = $this->model->findOrFail($id);

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function create($params)
    {
        try {
            $data = $this->model->create($params);
            if (!$data) {
                return [
                    'status' => false,
                    'message' => trans('messages.db_create_error'),
                ];
            }

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function update($params, $id)
    {
        try {
            $data = $this->model->find($id);
            if (!$data->update($params)) {
                return [
                    'status' => false,
                    'message' => trans('messages.db_update_error'),
                ];
            }

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function delete($ids)
    {
        try {
            DB::beginTransaction();
            if (is_array($ids)) {
                $data = $this->model->destroy($ids);
            } else {
                $data = $this->model->find($ids)->delete();
            }

            if (!$data) {
                return [
                    'status' => false,
                    'message' => trans('messages.db_delete_error'),
                ];
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function paginate($limit = null, $columns = ['*'])
    {
        $limit = is_null($limit) ? config('common.limit.page_limit') : $limit;
        $result = $this->model->paginate($limit, $columns);
        $this->resetModel();

        return $result;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function where($column, $value, $operator = '=')
    {   
        $this->model = $this->model->where($column, $operator, $value);

        return $this;
    }

    public function orWhere($column, $value, $operator = '=')
    {
        $this->model = $this->model->orWhere($column, $operator, $value);

        return $this;
    }
}
