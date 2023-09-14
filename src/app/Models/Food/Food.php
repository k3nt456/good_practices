<?php

namespace App\Models\Food;

use App\Models\Food\TypeFood\TypeFood;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Food extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tbl_food';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'idtype_food',
        'amount',
        'kcal',
        'protein',
        'fat',
        'hydrates',
        'iduser_added',
        'iduser_accepts',
        'status',
    ];

    # Relaciones
    public function typeFood(): HasOne
    {
        return $this->hasOne(TypeFood::class, 'id', 'idtype_food');
    }

    public function userAdded(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'iduser_added');
    }

    public function userAccepts(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'iduser_accepts');
    }

    # Query scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeActiveForID($query, $id)
    {
        return $query->where('id', $id)->where('status', 1);
    }

    # Filtros
    public function scopeFoodFilters($query)
    {
        #Filtro de busqueda
        $query->when(
            request('search'),
            function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
        );

        #Filtro de usuario que añadió el registro
        $query->when(
            request('iduser_added'),
            fn ($query) => $query->where('iduser_added', request('iduser_added'))
        );

        #Filtro de usuario que aceptó el registro
        $query->when(
            request('iduser_accepts'),
            fn ($query) => $query->where('iduser_accepts', request('iduser_accepts'))
        );

        #Filtro de estados
        $query->when(
            request('status') !== null,
            fn ($query) => $query->where('status', request('status'))
        )->when(
            request('status') === null,
            fn ($query) => $query->where('status', 1)
        );
    }
}
