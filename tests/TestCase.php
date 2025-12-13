<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public Company $company;
    
    public User $user;

    public Warehouse $warehouse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}