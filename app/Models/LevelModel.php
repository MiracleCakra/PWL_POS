<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level'; // Nama tabel dalam database
    protected $primaryKey = 'level_id'; // Nama primary key

    public $timestamps = false; // Matikan timestamps jika tidak ada created_at & updated_at

    protected $fillable = ['level_id', 'level_kode', 'level_nama']; // Perbaikan level_code -> level_kode

    public function user(): HasMany
    {
        return $this->hasOne(UserModel::class, 'level_id', 'level_id');
    }
}
