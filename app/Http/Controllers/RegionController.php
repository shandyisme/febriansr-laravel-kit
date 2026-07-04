<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Autocomplete search over the combined kelurahan/kecamatan/kota/provinsi text.
     * Every query token must appear (AND), so "menteng jakarta" narrows correctly.
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        $tokens = array_slice(array_filter(preg_split('/\s+/', mb_strtolower($q))), 0, 5);

        $regions = Region::query()
            ->tap(function ($query) use ($tokens) {
                foreach ($tokens as $token) {
                    $query->where('search_text', 'like', '%'.$token.'%');
                }
            })
            ->orderByRaw('CHAR_LENGTH(label)')
            ->limit(15)
            ->get(['id', 'label', 'zip_code']);

        return response()->json(
            $regions->map(fn (Region $r) => [
                'id' => $r->id,
                'label' => $r->label,
                'zip' => $r->zip_code,
            ])
        );
    }
}
