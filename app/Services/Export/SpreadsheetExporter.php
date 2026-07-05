<?php

declare(strict_types=1);

namespace App\Services\Export;

use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\CSV\Writer as CsvWriter;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Menghasilkan unduhan spreadsheet (CSV / XLSX) secara streaming
 * menggunakan OpenSpout agar hemat memori untuk data besar.
 */
final class SpreadsheetExporter
{
    /**
     * @param  array<int, string>  $headers
     * @param  iterable<int, array<string, mixed>|array<int, mixed>>  $rows
     */
    public function csv(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($filename, $headers, $rows) {
            $writer = new CsvWriter;
            $writer->openToBrowser($filename);
            $writer->addRow(Row::fromValues($headers));

            foreach ($rows as $r) {
                $writer->addRow(Row::fromValues(array_values($r)));
            }

            $writer->close();
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * @param  array<int, string>  $headers
     * @param  iterable<int, array<string, mixed>|array<int, mixed>>  $rows
     */
    public function xlsx(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($filename, $headers, $rows) {
            $writer = new XlsxWriter;
            $writer->openToBrowser($filename);
            $writer->addRow(Row::fromValues($headers));

            foreach ($rows as $r) {
                $writer->addRow(Row::fromValues(array_values($r)));
            }

            $writer->close();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
