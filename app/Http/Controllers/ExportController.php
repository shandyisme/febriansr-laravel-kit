<?php

namespace App\Http\Controllers;

use App\Services\Export\PdfExporter;
use App\Services\Export\SpreadsheetExporter;
use App\Services\Import\SpreadsheetImporter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    /**
     * Header kolom untuk ekspor anggota.
     *
     * @var array<int, string>
     */
    private const HEADERS = ['Nama', 'Email', 'Peran', 'Status', 'Bergabung'];

    public function members(string $format): Response
    {
        $rows = $this->sampleRows();

        return match ($format) {
            'csv' => app(SpreadsheetExporter::class)->csv('anggota.csv', self::HEADERS, $rows),
            'xlsx' => app(SpreadsheetExporter::class)->xlsx('anggota.xlsx', self::HEADERS, $rows),
            'pdf' => app(PdfExporter::class)->fromView('exports.members', ['members' => $rows], 'anggota.pdf'),
            default => abort(404),
        };
    }

    public function importForm(): View
    {
        return view('samples.import');
    }

    public function importStore(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx'],
        ]);

        $rows = app(SpreadsheetImporter::class)->rows($request->file('file'));

        return back()->with('imported', $rows);
    }

    /**
     * Data contoh anggota untuk keperluan ekspor demo.
     *
     * @return array<int, array<int, string>>
     */
    private function sampleRows(): array
    {
        return [
            ['Budi Santoso', 'budi.santoso@contoh.id', 'Admin', 'Aktif', '01 Jul 2026'],
            ['Siti Aminah', 'siti.aminah@contoh.id', 'Manajer', 'Aktif', '28 Jun 2026'],
            ['Ahmad Fauzi', 'ahmad.fauzi@contoh.id', 'Staf', 'Aktif', '25 Jun 2026'],
            ['Dewi Lestari', 'dewi.lestari@contoh.id', 'Editor', 'Menunggu', '22 Jun 2026'],
            ['Rizky Pratama', 'rizky.pratama@contoh.id', 'Admin', 'Nonaktif', '19 Jun 2026'],
            ['Nurul Hidayah', 'nurul.hidayah@contoh.id', 'Manajer', 'Aktif', '16 Jun 2026'],
            ['Eko Prasetyo', 'eko.prasetyo@contoh.id', 'Staf', 'Aktif', '13 Jun 2026'],
            ['Maya Sari', 'maya.sari@contoh.id', 'Editor', 'Menunggu', '10 Jun 2026'],
        ];
    }
}
