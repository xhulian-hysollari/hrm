<?php

namespace App\Modules\Settings\Repositories;

use App\Modules\Settings\Models\Currency;
use App\Modules\Settings\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Repositories\EloquentRepository;

class CurrencyRepository extends EloquentRepository implements CurrencyRepositoryInterface
{
    protected $allowedAttributes = ['model'];
    
    public function __construct(Currency $model)
    {
        $this->model = $model;
    }
}
