<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'namaproduct',
        'id_kategori',
        'namakategori',
        'deskripsiproduct',
        'gambarproduct',
        'stok',
        'harga'
    ];
}
