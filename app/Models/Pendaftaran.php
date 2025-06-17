<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran';

    protected $fillable = ['user_id', 'nama', 'nisn', 'tempat', 'tanggal','alamat','no_hp','kode','status','file_kk','file_akta','kode_pembayaran',
        'status_pembayaran',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
