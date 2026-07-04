<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Demo pages that showcase the kit's Blade components with sample data.
 * Read-only examples — no persistence — meant as a copy-paste reference.
 */
class SampleController extends Controller
{
    public function table(Request $request)
    {
        $members = $this->sampleMembers();

        $perPage = 8;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginator = new LengthAwarePaginator(
            $members->forPage($page, $perPage)->values(),
            $members->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()],
        );

        return view('samples.table', ['members' => $paginator]);
    }

    public function form()
    {
        return view('samples.form');
    }

    public function components()
    {
        return view('samples.components');
    }

    private function sampleMembers(): Collection
    {
        $names = [
            'Budi Santoso', 'Siti Aminah', 'Ahmad Fauzi', 'Dewi Lestari', 'Rizky Pratama',
            'Nurul Hidayah', 'Eko Prasetyo', 'Maya Sari', 'Andi Wijaya', 'Fitri Handayani',
            'Doni Kurniawan', 'Rina Melati', 'Hendra Gunawan', 'Lia Puspita', 'Bayu Aji',
            'Sri Wahyuni', 'Agus Salim', 'Indah Permata', 'Yoga Saputra', 'Tari Anggraini',
        ];
        $roles = ['Admin', 'Manajer', 'Staf', 'Editor'];
        $statuses = ['active', 'active', 'active', 'pending', 'inactive'];

        return collect($names)->map(fn ($name, $i) => [
            'id' => $i + 1,
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)).'@contoh.id',
            'role' => $roles[$i % count($roles)],
            'status' => $statuses[$i % count($statuses)],
            'joined' => now()->subDays(($i + 1) * 3)->format('d M Y'),
        ]);
    }
}
