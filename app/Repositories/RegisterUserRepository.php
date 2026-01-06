<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\RegisterUserRepositoryInterface;


class RegisterUserRepository implements RegisterUserRepositoryInterface
{

    protected $model;

    public function __construct(User $model)
    {

        $this->model = $model;

    }

    public function create(array $data)
    {
        return $this->model->create($data);

    }


}