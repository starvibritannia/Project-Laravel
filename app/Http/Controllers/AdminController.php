<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil data peminjaman yang statusnya masih 'dipinjam'
        $activeBorrowings = Borrowing::where('status', 'dipinjam')
                            ->with(['visit', 'item'])
                            ->get();

        // 2. Ambil log kunjungan hari ini
        $todaysVisits = Visit::whereDate('created_at', now()->today())
                            ->orderBy('created_at', 'desc')
                            ->get();

        // 3. Identifikasi NIM Pengunjung
        $uniqueVisitorsCount = Visit::whereDate('created_at', now()->today())
                            ->distinct('visitor_id')
                            ->count('visitor_id');

        return view('admin.dashboard', compact('activeBorrowings', 'todaysVisits' , 'uniqueVisitorsCount'));
    }

    public function returnItem($borrowing_id)
    {
        DB::transaction(function () use ($borrowing_id) {
            // Cari data peminjaman
            $borrowing = Borrowing::with('item')->findOrFail($borrowing_id);

            if ($borrowing->status == 'dipinjam') {
                // 1. Ubah status jadi dikembalikan
                $borrowing->update([
                    'status' => 'dikembalikan',
                    'returned_at' => now(),
                ]);

                // 2. KEMBALIKAN STOK (Increment)
                $borrowing->item->increment('current_stock', $borrowing->quantity);
            }
        });

        return back()->with('success', 'Barang telah dikembalikan dan stok diperbarui.');
    }

    public function destroyVisit($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();
        return back()->with('success', 'Riwayat kunjungan berhasil dihapus.');
    }
}