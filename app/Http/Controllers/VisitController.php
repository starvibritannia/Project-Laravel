<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Item;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    // 1. Method untuk menampilkan Form (Halaman Utama)
    public function create()
    {
        // Ambil barang yang stoknya ada saja
        $items = Item::where('current_stock', '>', 0)->get();
        return view('visit.form', compact('items'));
    }

    // 2. Method untuk memproses data (Store/Tap In)
    public function store(Request $request)
    {
        // 1. Validasi Input Standar
        $request->validate([
            'visitor_name' => 'required',
            'visitor_id' => 'required',
            'purpose' => 'required',
            'item_id' => 'nullable|required_if:purpose,pinjam',
            'quantity' => 'nullable|required_if:purpose,pinjam|integer|min:1',
        ]);

        // --- LOGIKA PENGECEKAN STOK SAAT TAP IN ---
        if ($request->purpose == 'pinjam') {
            $item = Item::findOrFail($request->item_id);

            // Cek stok
            if ($item->current_stock < $request->quantity) {
                return redirect()->back()
                    ->withInput() 
                    ->with('error', 'Gagal Tap In! Stok barang ' . $item->name . ' hanya tersisa ' . $item->current_stock . ' unit.');
            }
        }
        // Logika peminjaman + update stok (di dalam transaksi)----------------

        DB::transaction(function () use ($request) {
            
            // Simpan Data Kunjungan (KEMBALI KE ASAL: Tanpa status 'active')
            $visit = Visit::create([
                'visitor_name' => $request->visitor_name,
                'visitor_id' => $request->visitor_id,
                'purpose' => $request->purpose,
            ]);

            // Logika Jika Meminjam Barang
            if ($request->purpose == 'pinjam') {
                $item = Item::lockForUpdate()->findOrFail($request->item_id); 

                Borrowing::create([
                    'visit_id' => $visit->id,
                    'item_id'  => $item->id,
                    'quantity' => $request->quantity,
                    'status'   => 'dipinjam',
                ]);

                // Kurangi Stok
                $item->decrement('current_stock', $request->quantity); 
            }
        });

        return redirect()->back()->with('success', 'Berhasil Tap In!');
    }

    // 3. Menampilkan Halaman Form Tap Out
    public function tapOutForm()
    {
        return view('visit.tap-out');
    }

    // 4. Proses Tap Out (Hapus Data Peminjaman & Kembalikan Stok, TAPI RIWAYAT TETAP ADA)
    public function tapOutProcess(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required'
        ]);

        // ROLLBACK: Ambil SEMUA data kunjungan berdasarkan NIM (Tanpa cek status)
        $visits = Visit::where('visitor_id', $request->visitor_id)->get();

        if ($visits->isEmpty()) {
            return back()->with('error', 'Data kunjungan tidak ditemukan untuk NIM tersebut.');
        }

        DB::transaction(function () use ($visits) {
            foreach ($visits as $visit) {
                
                // Ambil barang yang dipinjam
                $borrowings = \App\Models\Borrowing::where('visit_id', $visit->id)->get();

                foreach ($borrowings as $borrow) {
                    $item = \App\Models\Item::find($borrow->item_id);
                    
                    if ($item) {
                        // Kembalikan Stok (Dengan Safety Check)
                        $newStock = $item->current_stock + $borrow->quantity;
                        
                        $item->current_stock = min($newStock, $item->total_stock);
                        $item->save();

                    }
    
                }

                //jangan dihapus, biarkan sebagai riwayat
                $borrow->update([
                    'status'      => 'dikembalikan',
                    'returned_at' => now(),
                ]);

                // ROLLBACK: TIDAK ADA UPDATE STATUS MENJADI COMPLETED
                // Biarkan data visit tetap ada sebagai riwayat.
            }
        });

        return back()->with('success', 'Tap Out Berhasil! Tanggungan peminjaman telah dikembalikan.');
    }
}