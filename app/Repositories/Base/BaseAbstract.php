<?php

namespace App\Repositories\Base;

use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class BaseAbstract implements BaseInterface
{
    protected Model $model;
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->model = $this->bindModel();
    }

    public function bindModel(): \Exception|BindingResolutionException | Model
    {
        try {
            $bind_model = $this->app->make($this->model());
            if (!$bind_model instanceof Model) {
                throw new BindingResolutionException('Model not found.');
            }
            return $bind_model;
        } catch (BindingResolutionException $e) {
            return $e;
        }
    }

    abstract public function model(): string;

    public function findById(string $id) : ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function findAll($filter = []): Collection
    {
        return $this->model->where($filter)->get();
    }

    public function findWhere(array $filter) : ?Model
    {
        return $this->model->where($filter)->first();
    }

    public function create(array $data):Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): ?Model
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function paginate(int $perPage = 15, array $columns = [], string $orderBy = 'id', string $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model->where($columns)->orderBy($orderBy, $sort)->paginate($perPage);
    }
}
