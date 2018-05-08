<?php

namespace App\Modules\Visitor\Repositories;

use App\Modules\Visitor\Models\Visitor;
use App\Modules\Visitor\Repositories\Interfaces\VisitorRepositoryInterface;
use App\Repositories\EloquentRepository;

class VisitorRepository extends EloquentRepository implements VisitorRepositoryInterface
{
    public function __construct(Visitor $model)
    {
        $this->model = $model;
    }
}
