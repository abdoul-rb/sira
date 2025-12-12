<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermission
{
    public function check(string $permission, ?string $errorMessage = null): void
    {
        if (! Auth::user()->can($permission)) {
            $this->dispatch('notify', "Impossible pour vous d'ajouter un produit");
            $this->dispatch('close-modal', id: 'create-product');

            return;
        }
    }
}
