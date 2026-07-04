<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Formatting helpers for Indonesian Rupiah amounts.
 *
 * Rupiah has no fractional sub-unit in everyday use, so amounts are rendered
 * without decimals and grouped with a dot separator: "Rp 1.500.000".
 */
final class MoneyFormatter
{
    /**
     * Format an amount as Rupiah.
     *
     *   MoneyFormatter::rupiah(1500000)        → 'Rp 1.500.000'
     *   MoneyFormatter::rupiah(1500000, false) → '1.500.000'
     *
     * @param  int|float  $amount  Amount in whole Rupiah.
     * @param  bool  $withSymbol  Prefix with the "Rp " symbol.
     */
    public static function rupiah(int|float $amount, bool $withSymbol = true): string
    {
        $formatted = number_format((float) round($amount), 0, ',', '.');

        return $withSymbol ? 'Rp '.$formatted : $formatted;
    }

    /**
     * Generic number formatter using Indonesian conventions
     * (comma for decimals, dot for thousands).
     *
     * @param  int|float  $amount  The value to format.
     * @param  int  $decimals  Number of decimal places to keep.
     */
    public static function format(int|float $amount, int $decimals = 0): string
    {
        return number_format((float) $amount, $decimals, ',', '.');
    }

    /**
     * Convert a Rupiah amount to its integer "cents" representation
     * (multiplied by 100) — useful for payment gateways that expect the
     * smallest currency unit.
     */
    public static function toCents(int|float $amount): int
    {
        return (int) round($amount * 100);
    }

    /**
     * Convert an integer "cents" amount back to whole Rupiah (float).
     */
    public static function fromCents(int $cents): float
    {
        return $cents / 100;
    }

    /**
     * Parse a formatted Rupiah string back into a numeric value.
     *
     *   MoneyFormatter::parse('Rp 1.500.000') → 1500000.0
     */
    public static function parse(string $value): float
    {
        // Drop everything except digits, comma (decimal) and minus sign.
        $clean = preg_replace('/[^0-9,\-]/', '', $value) ?? '';
        $clean = str_replace(',', '.', $clean);

        return (float) $clean;
    }
}
