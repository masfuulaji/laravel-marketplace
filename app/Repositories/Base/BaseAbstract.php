<?php

namespace App\Repositories\Base;

use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;

abstract class BaseAbstract implements BaseInterface
{
    protected $model;
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindModel(): Model
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new BindingResolutionException('Model not found.');
        }
        return $model;
    }

    abstract public function model(): string;

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findAll($filter = [])
    {
        return $this->model->where($filter)->get();
    }

    public function findWhere(array $filter)
    {
        return $this->model->where($filter)->first();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update($id, array $data){
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id){
        return $this->model->findOrFail($id)->delete();
    }

    public function paginate(int $perPage = 15, array $columns = [], string $orderBy = 'id', string $sort = 'desc'){
        return $this->model->where($columns)->orderBy($orderBy, $sort)->paginate($perPage);
    }
}
