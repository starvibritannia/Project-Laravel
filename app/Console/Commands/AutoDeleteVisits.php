<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visit;
use Carbon\Carbon;

class AutoDeleteVisits extends Command
{
    // Nama perintah yang akan dipanggil sistem
    protected $signature = 'visits:cleanup';

    // Deskripsi
    protected $description = 'Menghapus riwayat kunjungan yang lebih lama dari 12 jam';

    public function handle()
    {
        // Logika Penghapusan
        // Hapus data yang 'created_at'-nya kurang dari (sekarang - 12 jam)
        $deleted = Visit::where('created_at', '<', Carbon::now()->subHours(12))->delete();

        $this->info("Berhasil menghapus {$deleted} data kunjungan lama.");
    }
}