<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Models\Company;

/**
 * @deprecated La table shops a été supprimée. Cette action est conservée pour compatibilité
 * mais ne fait plus rien. Le concept de "boutique" est désormais la Company elle-même.
 */
final class CreateShopAction
{
    public function handle(Company $company, array $data): void
    {
        // La table shops a été supprimée — no-op.
    }
}
