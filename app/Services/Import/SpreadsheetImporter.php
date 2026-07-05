<?php

declare(strict_types=1);

namespace App\Services\Import;

use Illuminate\Http\UploadedFile;
use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\ReaderInterface;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;

/**
 * Membaca berkas spreadsheet (CSV / XLSX) menjadi array asosiatif.
 * Baris pertama diperlakukan sebagai header (kunci kolom).
 */
final class SpreadsheetImporter
{
    /**
     * Batas aman jumlah baris data yang diproses.
     */
    private const MAX_ROWS = 500;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function rows(UploadedFile $file): array
    {
        $reader = $this->readerFor($file);
        $reader->open($file->getRealPath());

        $header = [];
        $result = [];
        $isFirstRow = true;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->toArray();

                if ($isFirstRow) {
                    // Baris pertama = header / kunci kolom.
                    $header = array_map(
                        static fn ($value): string => trim((string) $value),
                        $cells,
                    );
                    $isFirstRow = false;

                    continue;
                }

                // Lewati baris yang benar-benar kosong.
                if ($this->isEmptyRow($cells)) {
                    continue;
                }

                $assoc = [];
                foreach ($header as $index => $key) {
                    if ($key === '') {
                        continue;
                    }
                    $assoc[$key] = $cells[$index] ?? null;
                }

                $result[] = $assoc;

                // Cap di MAX_ROWS baris demi keamanan/memori.
                if (count($result) >= self::MAX_ROWS) {
                    break 2;
                }
            }

            // Hanya proses sheet pertama.
            break;
        }

        $reader->close();

        return $result;
    }

    private function readerFor(UploadedFile $file): ReaderInterface
    {
        $extension = strtolower($file->getClientOriginalExtension());

        return match ($extension) {
            'xlsx' => new XlsxReader,
            default => new CsvReader,
        };
    }

    /**
     * @param  array<int, mixed>  $cells
     */
    private function isEmptyRow(array $cells): bool
    {
        foreach ($cells as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }
}
