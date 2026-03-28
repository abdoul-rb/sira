<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Actions\Company\CreateCompanyAction;
use App\Actions\Members\CreateOwnerMemberAction;
use App\Actions\Shop\CreateShopAction;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CompleteOnboardingAction
{
    public function __construct(
        private CreateCompanyAction $createCompanyAction,
        private CreateShopAction $createShopAction,
        private CreateOwnerMemberAction $createOwnerMemberAction
    ) {}

    public function handle(User $user, array $data, $companyLogo = null): Company
    {
        return DB::transaction(function () use ($user, $data, $companyLogo) {
            $company = $this->createCompanyAction->handle($data, $companyLogo);

            $this->createShopAction->handle($company, $data);

            $this->createOwnerMemberAction->handle($company, $user);

            return $company;
        });
    }
}
