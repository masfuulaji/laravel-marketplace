<?php

namespace App\Repositories\v1;
use App\Models\User;
use App\Repositories\Base\BaseAbstract;

class UserRepository extends BaseAbstract
{
    public function model(): string
    {
        return User::class;
    }

    public function count($filter = []){
        return $this->model->where($filter)->count();
    }
}
