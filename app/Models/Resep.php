<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_resep',
        'foto_resep',
        'lama_memasak',
        'cara_memasak',
        'status',
        'user_id'
    ];
}
