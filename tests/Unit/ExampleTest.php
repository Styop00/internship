<?php

namespace Tests\Unit;

use App\Http\Contracts\UserRepositoryInterface;
use App\Http\Repositories\UserRepository;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {

        $userRepository = app()->make(UserRepository::class);
        $userRepository->all();
        $this->assertTrue(true);
    }
}
