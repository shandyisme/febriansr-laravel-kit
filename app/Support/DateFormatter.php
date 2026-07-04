<?php

declare(strict_types=1);

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Indonesian-aware date/time formatting helpers.
 *
 * Rather than depending on a system locale being installed, the Indonesian
 * month and day names are provided explicitly so output is deterministic
 * across environments.
 */
final class DateFormatter
{
    /**
     * Indonesian month names indexed 1–12.
     *
     * @var array<int, string>
     */
    private const MONTHS = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /**
     * Short Indonesian month names indexed 1–12.
     *
     * @var array<int, string>
     */
    private const MONTHS_SHORT = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
    ];

    /**
     * Indonesian day names indexed by Carbon dayOfWeek (0 = Sunday).
     *
     * @var array<int, string>
     */
    private const DAYS = [
        0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
        4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu',
    ];

    /**
     * Human, short date: "4 Jul 2026".
     */
    public static function human(CarbonInterface|string $date): string
    {
        $c = self::toCarbon($date);

        return $c->day.' '.self::MONTHS_SHORT[$c->month].' '.$c->year;
    }

    /**
     * Long date: "4 Juli 2026".
     */
    public static function long(CarbonInterface|string $date): string
    {
        $c = self::toCarbon($date);

        return $c->day.' '.self::MONTHS[$c->month].' '.$c->year;
    }

    /**
     * Date with time: "4 Jul 2026 14:30".
     */
    public static function withTime(CarbonInterface|string $date): string
    {
        $c = self::toCarbon($date);

        return self::human($c).' '.$c->format('H:i');
    }

    /**
     * Full date with weekday: "Sabtu, 4 Juli 2026".
     */
    public static function full(CarbonInterface|string $date): string
    {
        $c = self::toCarbon($date);

        return self::dayName($c).', '.self::long($c);
    }

    /**
     * Indonesian relative time: "5 menit yang lalu", "2 hari lagi".
     */
    public static function diffForHumansId(CarbonInterface|string $date): string
    {
        $c = self::toCarbon($date);
        $now = Carbon::now();

        $future = $c->isAfter($now);
        $seconds = (int) abs($now->diffInSeconds($c));

        [$value, $unit] = match (true) {
            $seconds < 60 => [$seconds, 'detik'],
            $seconds < 3600 => [intdiv($seconds, 60), 'menit'],
            $seconds < 86400 => [intdiv($seconds, 3600), 'jam'],
            $seconds < 2592000 => [intdiv($seconds, 86400), 'hari'],
            $seconds < 31536000 => [intdiv($seconds, 2592000), 'bulan'],
            default => [intdiv($seconds, 31536000), 'tahun'],
        };

        if ($value <= 0) {
            return 'baru saja';
        }

        return $future
            ? "{$value} {$unit} lagi"
            : "{$value} {$unit} yang lalu";
    }

    /**
     * Indonesian day name for the given date ("Senin").
     */
    public static function dayName(CarbonInterface|string $date): string
    {
        return self::DAYS[self::toCarbon($date)->dayOfWeek];
    }

    /**
     * Indonesian month name for the given date ("Juli").
     */
    public static function monthName(CarbonInterface|string $date): string
    {
        return self::MONTHS[self::toCarbon($date)->month];
    }

    /**
     * Normalise the incoming value to a Carbon instance.
     */
    private static function toCarbon(CarbonInterface|string $date): CarbonInterface
    {
        return $date instanceof CarbonInterface ? $date : Carbon::parse($date);
    }
}
