<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Actions\Auth\CreateUserAction;
use App\Actions\Company\CreateCompanyAction;
use App\Actions\Members\CreateOwnerMemberAction;
use Illuminate\Support\Facades\DB;

final class RegisterAndOnboardAction
{
    public function __construct(
        private CreateUserAction $createUserAction,
        private CreateCompanyAction $createCompanyAction,
        private CreateOwnerMemberAction $createOwnerMemberAction,
    ) {}

    public function handle(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = $this->createUserAction->handle($data);

            // Déduire le pays depuis le code indicatif choisi
            $countries = config('countries');
            $countryName = $countries[$data['countryCode'] ?? '']['name'] ?? $data['countryCode'] ?? '';

            $company = $this->createCompanyAction->handle([
                'companyName' => $data['companyName'],
                'country' => $countryName,
            ]);

            $this->createOwnerMemberAction->handle($company, $user);

            return compact('user', 'company');
        });
    }
}
