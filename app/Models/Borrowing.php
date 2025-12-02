<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi
    protected $fillable = [
        'visit_id', 
        'item_id', 
        'quantity', 
        'status', 
        'returned_at'
    ];

    // Relasi ke Item (Barang)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke Visit (Kunjungan)
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}