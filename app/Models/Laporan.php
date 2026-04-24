<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_transaksi',
        'total_pendapatan',
        'keterangan',
    ];
}