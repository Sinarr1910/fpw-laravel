<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom ini untuk diisi oleh Controller
    protected $fillable = [
        'invoice_number',
        'total_amount',
        'user_id',
        'total_price',
        'pay',
        'change',
    ];


    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Tambahan relasi 'details' yang dipanggil oleh view struk.blade.php
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Tambahan relasi 'user' untuk menampilkan nama kasir di struk
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
