<?php

namespace App\Repositories\Contracts;

interface RegisterUserRepositoryInterface{

    public function create(array $data);
    
}