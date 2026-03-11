<?php

declare(strict_types=1);

use App\Models\Order;
use Illuminate\Support\Number;

if (! function_exists('whatsapp_reminder_url')) {
    /**
     * Génère l'URL WhatsApp pour le rappel d'une créance.
     */
    function whatsapp_reminder_url(Order $order, float|int $remaining): string
    {
        $phone = preg_replace('/\D/', '', $order->customer?->phone_number ?? '');
        $customerName = $order->customer?->fullname ?? 'Cher(e) client(e)';
        $remainingFormatted = Number::currency($remaining, in: 'XOF', locale: 'fr');

        $message = "Bonjour {$customerName}, nous vous rappelons gentiment qu'il vous reste {$remainingFormatted} à régler pour votre commande #{$order->order_number}. Merci de votre confiance 🙏";

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}
