<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Indonesian language / locale text helpers.
 *
 * The headline feature is `terbilang()`, which spells an integer out in
 * Indonesian words — commonly needed on invoices and receipts.
 */
final class IndonesianFormatter
{
    /**
     * Base number words for 0–11 used by the recursive speller.
     *
     * @var array<int, string>
     */
    private const UNITS = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima',
        'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas',
    ];

    /**
     * Spell an integer in Indonesian words.
     *
     *   IndonesianFormatter::terbilang(1500)    → 'seribu lima ratus'
     *   IndonesianFormatter::terbilang(21)      → 'dua puluh satu'
     *   IndonesianFormatter::terbilang(-5)      → 'minus lima'
     */
    public static function terbilang(int $number): string
    {
        if ($number < 0) {
            return 'minus '.self::terbilang(abs($number));
        }

        // Collapse the incidental double spaces produced by the recursion.
        $words = trim((string) preg_replace('/\s+/', ' ', self::spell($number)));

        return $words !== '' ? $words : 'nol';
    }

    /**
     * Recursive core of {@see terbilang()}.
     */
    private static function spell(int $n): string
    {
        if ($n < 12) {
            return self::UNITS[$n];
        }

        if ($n < 20) {
            return self::spell($n - 10).' belas';
        }

        if ($n < 100) {
            return self::spell(intdiv($n, 10)).' puluh '.self::spell($n % 10);
        }

        if ($n < 200) {
            return 'seratus '.self::spell($n - 100);
        }

        if ($n < 1000) {
            return self::spell(intdiv($n, 100)).' ratus '.self::spell($n % 100);
        }

        if ($n < 2000) {
            return 'seribu '.self::spell($n - 1000);
        }

        if ($n < 1_000_000) {
            return self::spell(intdiv($n, 1000)).' ribu '.self::spell($n % 1000);
        }

        if ($n < 1_000_000_000) {
            return self::spell(intdiv($n, 1_000_000)).' juta '.self::spell($n % 1_000_000);
        }

        if ($n < 1_000_000_000_000) {
            return self::spell(intdiv($n, 1_000_000_000)).' miliar '.self::spell($n % 1_000_000_000);
        }

        return self::spell(intdiv($n, 1_000_000_000_000)).' triliun '.self::spell($n % 1_000_000_000_000);
    }

    /**
     * Spell a Rupiah amount: "seribu lima ratus rupiah".
     */
    public static function terbilangRupiah(int $amount): string
    {
        return trim(self::terbilang($amount).' rupiah');
    }

    /**
     * Title-case a string using Indonesian conventions, keeping common
     * connector words ("dan", "di", "ke", "yang", …) lowercase unless they
     * appear as the first word.
     */
    public static function titleCase(string $value): string
    {
        $minor = ['dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'atau', 'pada', 'dengan', 'the', 'of'];
        $words = preg_split('/\s+/', trim(mb_strtolower($value))) ?: [];

        $result = array_map(
            static function (string $word, int $index) use ($minor): string {
                if ($index > 0 && in_array($word, $minor, true)) {
                    return $word;
                }

                return mb_strtoupper(mb_substr($word, 0, 1)).mb_substr($word, 1);
            },
            $words,
            array_keys($words),
        );

        return implode(' ', $result);
    }

    /**
     * Loosely validate an Indonesian NIK (national ID) — 16 numeric digits.
     */
    public static function isValidNik(string $nik): bool
    {
        return (bool) preg_match('/^\d{16}$/', $nik);
    }
}
