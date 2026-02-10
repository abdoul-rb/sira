<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Models\Company;
use App\Models\Shop;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateOrCreateShopAction
{
    /**
     * Met à jour ou crée une boutique pour une entreprise donnée.
     *
     * @param  Company  $company  L'entreprise propriétaire de la boutique
     * @param  Shop  $shop  La boutique à mettre à jour (ou nouvelle instance)
     * @param  array  $data  Les données validées de la boutique
     * @return Shop La boutique mise à jour ou créée
     */
    public function handle(Company $company, Shop $shop, array $data): Shop
    {
        return DB::transaction(function () use ($company, $shop, $data) {
            // Gérer l'upload du logo si fourni
            if (isset($data['newLogo']) && $data['newLogo'] instanceof UploadedFile) {
                $filename = $data['newLogo']->getClientOriginalName();
                $path = "{$company->id}/shop/";
                $data['logo_path'] = "{$path}{$filename}";

                // Supprimer l'ancien logo s'il existe
                if ($shop->logo_path && Storage::disk('public')->exists($shop->logo_path)) {
                    Storage::disk('public')->delete($shop->logo_path);
                }

                // Stocker le nouveau logo
                $data['newLogo']->storeAs($path, $filename, 'public');

                // Retirer newLogo des données avant sauvegarde
                unset($data['newLogo']);
            }

            // Mettre à jour ou créer la boutique
            if ($shop->exists) {
                $shop->update([
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'facebook_url' => $data['facebookUrl'] ?? null,
                    'instagram_url' => $data['instagramUrl'] ?? null,
                    'logo_path' => $data['logo_path'] ?? $shop->logo_path,
                    'active' => $data['active'] ?? $shop->active,
                ]);
            } else {
                $shop = Shop::create([
                    'company_id' => $company->id,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'facebook_url' => $data['facebookUrl'] ?? null,
                    'instagram_url' => $data['instagramUrl'] ?? null,
                    'logo_path' => $data['logo_path'] ?? null,
                    'active' => $data['active'] ?? true,
                ]);
            }

            return $shop->fresh();
        });
    }
}
