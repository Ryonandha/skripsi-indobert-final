<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'google_id', 'password', 'role', 'nim', 'prodi', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    public function isMahasiswa(): bool { return $this->role === 'mahasiswa'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPsikolog(): bool { return $this->role === 'psikolog'; }

    public function hasCompleteProfile(): bool
    {
        if ($this->isMahasiswa()) {
            return !empty($this->nim) && !empty($this->prodi);
        }
        return true;
    }
}
