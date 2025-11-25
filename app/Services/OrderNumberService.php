<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderNumberService
{
    /**
     * Génère un numéro de commande unique pour une entreprise
     * Pattern: YYYYMMDD-XX-HHH / 231125-99-001
     */
    public function generate(Company $company): string
    {
        $today = now()->format('ymd');
        $increment = $this->getDailyIncrement($company, $today);
        $tenantId = str_pad((string) $company->id, 2, '0', STR_PAD_LEFT);

        return "{$today}-{$tenantId}-{$increment}";
    }

    /**
     * Récupère l'incrément quotidien pour une entreprise
     */
    private function getDailyIncrement(Company $company, string $date): string
    {
        $key = "order_counter_daily_{$company->id}_{$date}";
        $daily = Cache::increment($key);

        if ($daily === false) {
            // Expire à minuit → repart à zéro le lendemain
            $daily = 1;
            Cache::put($key, $daily, now()->endOfDay());
        }

        return str_pad((string) $daily, 3, '0', STR_PAD_LEFT);
    }

    // compteur global par entreprise.
    private function getGlobalIncrement(Company $company): string
    {
        $global = DB::table('orders')
            ->where('company_id', $company->id)
            ->max('id') + 1;

        return str_pad((string) $global, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Génère un hash court unique basé sur l'entreprise
     */
    private function generateShortHash(Company $company): string
    {
        $data = "{$company->id} {$company->name}" . now()->timestamp;
        $hash = hash('sha256', $data);

        return strtoupper(substr($hash, 0, 6));
    }

    /**
     * Génère un numéro de commande avec une date spécifique
     * Utile pour les tests ou les corrections
     */
    public function generateForCompanyWithDate(Company $company, \DateTime $date): string
    {
        $dateString = $date->format('Ymd');
        $increment = $this->getDailyIncrement($company, $dateString);
        $hash = $this->generateShortHash($company);

        return sprintf('%s-%03d-%s', $dateString, $increment, $hash);
    }

    /**
     * Récupère les statistiques de génération pour une entreprise
     */
    public function getCompanyStats(Company $company): array
    {
        $today = now()->format('ymd');

        $todayOrders = Order::where('company_id', $company->id)
            ->where('order_number', 'like', $today . '-%')
            ->count();

        $totalOrders = Order::where('company_id', $company->id)->count();

        return [
            'today_orders' => $todayOrders,
            'total_orders' => $totalOrders,
        ];
    }
}
