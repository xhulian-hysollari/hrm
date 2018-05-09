<?php

namespace App\Modules\Settings\Repositories;

use App\Modules\Settings\Models\Forcontact;
use App\Modules\Settings\Repositories\Interfaces\ForcontactRepositoryInterface;
use App\Repositories\EloquentRepository;

class ForcontactRepository extends EloquentRepository implements ForcontactRepositoryInterface
{
    public function __construct(Forcontact $model)
    {
        $this->model = $model;
    }
}
