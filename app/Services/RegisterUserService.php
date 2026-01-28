<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


use App\Repositories\Contracts\RegisterUserRepositoryInterface;


class RegisterUserService {

    protected $registerUserRepository;

    public function __construct(RegisterUserRepositoryInterface $registerUserRepository) {
        $this->registerUserRepository = $registerUserRepository;

    }

    public function registerUser(array $data) {
        
        $user = $this->registerUserRepository->create($data);

        Mail::to($user)->queue(new WelcomeEmail($user));

        return $user;

    }


}