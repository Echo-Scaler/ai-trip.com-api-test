<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Define static exchange rates relative to USD.
     * In a production app, these would come from an API or Database.
     */
    const RATES = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'JPY' => 150.50,
    ];

    /**
     * Define symbols for each currency.
     */
    const SYMBOLS = [
        'USD' => '$',
        'EUR' => '€',
        'JPY' => '¥',
    ];

    /**
     * Convert and format a base USD price into the user's selected session currency.
     *
     * @param float $baseUsdPrice The price in USD
     * @return string Formatted string (e.g., "€120" or "¥15,000")
     */
    public static function format($baseUsdPrice)
    {
        $targetCurrency = session('currency', 'USD');

        // Fallback to USD if currency is not supported
        if (!array_key_exists($targetCurrency, self::RATES)) {
            $targetCurrency = 'USD';
        }

        $rate = self::RATES[$targetCurrency];
        $symbol = self::SYMBOLS[$targetCurrency];

        $convertedPrice = $baseUsdPrice * $rate;

        // JPY generally doesn't use decimals for everyday prices
        $decimals = ($targetCurrency === 'JPY') ? 0 : 0; // Keeping 0 decimals for clean UI like the current design

        return $symbol . number_format($convertedPrice, $decimals);
    }
}
