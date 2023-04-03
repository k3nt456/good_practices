<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasUuids;

    protected $table = 'tbl_user';

    public $timestamps = false;

    protected $fillable = [
        'dni',
        'email',
        'password',
        'encrypted_password',
        'idtype_user',
        'email_confirmation',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'encrypted_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #Relaciones
    public function typeUser(): HasOne
    {
        return $this->hasOne(TypeUser::class, 'id', 'idtype_user');
    }


    #Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
