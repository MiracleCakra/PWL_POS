<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserModel extends Authenticatable implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'foto_profil',
        'image', //tambahan
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password']; // agar tidak ditampilkan saat select

    protected $casts = [
        'password' => 'hashed',
    ]; // casting agar password dienkripsi otomatis

    //relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //image
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => asset('storage/posts/' . $image),
        );
    }

    //mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    //validasi apakah ada yang user memiliki role tertentu
    public function hasRole(string $role): bool
    {
        return $this->level->level_nama == $role;
    }

    //mendapatkan kode role
    public function getRole(): string
    {
        return $this->level->level_kode;
    }
}
