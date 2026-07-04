<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Normalise Indonesian phone numbers to a canonical E.164-style form.
 *
 * Indonesian mobile numbers are commonly written in many shapes:
 *   0812-3456-7890, +62 812 3456 7890, 62 812 3456 7890, 812 3456 7890.
 * All of these are normalised to the digits-only form "628123456789".
 */
final class PhoneNormalizer
{
    /**
     * Normalise a phone number to "62xxxxxxxxxx" (no plus sign).
     *
     *   PhoneNormalizer::toE164('0812-3456-7890') → '6281234567890'
     *   PhoneNormalizer::toE164('+62 812 3456 7890') → '6281234567890'
     *
     * @param  string  $phone  The raw phone number.
     * @param  string  $default  Country calling code to assume for local numbers.
     */
    public static function toE164(string $phone, string $default = '62'): string
    {
        // Keep digits only (this also strips a leading "+").
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if ($digits === '') {
            return '';
        }

        // 00xx international prefix → drop the leading zeros.
        if (str_starts_with($digits, '00')) {
            $digits = ltrim($digits, '0');
        }

        // Already prefixed with the country code.
        if (str_starts_with($digits, $default)) {
            return $digits;
        }

        // Local format "08xxxx" → replace the leading 0 with the country code.
        if (str_starts_with($digits, '0')) {
            return $default.substr($digits, 1);
        }

        // Bare national number "8xxxx" → prepend the country code.
        return $default.$digits;
    }

    /**
     * Validate that a value is a plausible Indonesian mobile number.
     *
     * After normalisation an Indonesian mobile number is "628" followed by
     * 7–12 further digits (total length 11–14).
     */
    public static function isValid(string $phone, string $default = '62'): bool
    {
        $normalized = self::toE164($phone, $default);

        return (bool) preg_match('/^628[1-9][0-9]{6,11}$/', $normalized);
    }

    /**
     * Format a number for display with a leading "+": "+6281234567890".
     */
    public static function toDisplay(string $phone, string $default = '62'): string
    {
        $normalized = self::toE164($phone, $default);

        return $normalized === '' ? '' : '+'.$normalized;
    }

    /**
     * Mask the middle digits of a number for privacy.
     *
     *   PhoneNormalizer::mask('081234567890') → '6281****7890'
     */
    public static function mask(string $phone, string $default = '62'): string
    {
        $normalized = self::toE164($phone, $default);
        $len = strlen($normalized);

        if ($len <= 8) {
            return $normalized;
        }

        $start = substr($normalized, 0, 4);
        $end = substr($normalized, -4);
        $masked = str_repeat('*', $len - 8);

        return $start.$masked.$end;
    }
}
