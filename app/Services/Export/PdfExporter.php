<?php

declare(strict_types=1);

namespace App\Services\Export;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

/**
 * Merender view Blade menjadi berkas PDF menggunakan dompdf.
 */
final class PdfExporter
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function fromView(string $view, array $data, string $filename): Response
    {
        return Pdf::loadView($view, $data)->download($filename);
    }
}
