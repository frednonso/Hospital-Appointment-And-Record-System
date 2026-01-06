<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\RegisterUserRepositoryInterface;


class RegisterUserService {

    protected $registerUserRepository;

    public function __construct(RegisterUserRepositoryInterface $registerUserRepository) {
        $this->registerUserRepository = $registerUserRepository;

    }

    public function registerUser(array $data) {
        
        return $this->registerUserRepository->create($data);

    }


}