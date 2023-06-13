<?php

namespace App\Repositories\Base;

interface BaseInterface{
    public function findById($id);
    public function findAll(array $filter);
    public function findWhere(array $filter);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginate(int $perPage = 15, array $columns = [], string $orderBy = 'id', string $sort = 'desc');
}
