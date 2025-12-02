<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom-kolom ini boleh diisi
    protected $fillable = [
        'visitor_name', 
        'visitor_id', 
        'purpose',
    ];

    // Tambahkan relasi ini agar Visit bisa mengecek data peminjaman
    public function borrowing()
    {
        return $this->hasOne(Borrowing::class);
    }
}