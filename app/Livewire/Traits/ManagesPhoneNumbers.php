<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

trait ManagesPhoneNumbers
{
    /**
     * Get the list of countries from config.
     */
    public function getCountriesProperty(): array
    {
        return config('countries');
    }

    /**
     * Extract country code from a phone number in E.164 format.
     */
    private function extractCountryCodeFromPhone(?string $phone): string
    {
        if (! $phone) {
            return 'CI'; // Default
        }

        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($phone, null);
            $regionCode = $phoneUtil->getRegionCodeForNumber($numberProto);

            return $regionCode ?: 'CI';
        } catch (NumberParseException $e) {
            return 'CI';
        }
    }

    /**
     * Extract local number from E.164 format.
     * Returns the number in national format with leading zero.
     */
    private function extractLocalNumber(?string $phone, string $countryCode): string
    {
        if (! $phone) {
            return '';
        }

        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($phone, $countryCode);

            // Utiliser le format national qui conserve le 0 initial et le formatage
            return $phoneUtil->format($numberProto, PhoneNumberFormat::NATIONAL);
        } catch (NumberParseException $e) {
            return $phone;
        }
    }

    /**
     * Format a phone number to E.164 international format.
     */
    private function formatToE164(string $phoneNumber, string $countryCode): string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($phoneNumber, $countryCode);

            return $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            // Si le parsing échoue, retourner le numéro tel quel
            return $phoneNumber;
        }
    }
}
