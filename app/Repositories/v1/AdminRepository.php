<?php

namespace App\Repositories\v1;

use App\Models\Admin;
use App\Repositories\Base\BaseAbstract;

class AdminRepository extends BaseAbstract
{
    public function model(): string
    {
        return Admin::class;
    }
}
