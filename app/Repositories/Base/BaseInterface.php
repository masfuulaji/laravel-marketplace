<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseInterface{
    public function findById(string $id): ?Model;
    public function findAll(array $filter) : Collection;
    public function findWhere(array $filter) : ?Model;
    public function create(array $data) : Model;
    public function update(string $id, array $data) : ?Model;
    public function delete(string $id) : bool;
    public function paginate(int $perPage = 15, array $columns = [], string $orderBy = 'id', string $sort = 'desc') : LengthAwarePaginator;
}
