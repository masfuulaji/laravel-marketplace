<?php

namespace App\Repositories\Base;

//use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

abstract class BaseAbstract implements BaseInterface
{
    protected Model $model;
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->bindModel();
    }

    public function bindModel(): \Exception|BindingResolutionException | Model
    {
        try {
            $model = $this->app->make($this->model());
            if (!$model instanceof Model) {
                throw new BindingResolutionException('Model not found.');
            }
            return $model;
        } catch (BindingResolutionException $e) {
            return $e;
        }
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

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function paginate(int $perPage = 15, array $columns = [], string $orderBy = 'id', string $sort = 'desc')
    {
        return $this->model->where($columns)->orderBy($orderBy, $sort)->paginate($perPage);
    }
}
