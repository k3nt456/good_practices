<?php

namespace App\Models\Excercises;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Excercises extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tbl_excercises';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'idmuscles_exercise',
        'iddivision_execution',
        'idspecificity',
        'img_excercise',
        'vid_excercise',
        'iduser_added',
        'iduser_accepts',
        'status',
    ];

    # Relaciones
    public function muscles(): HasOne
    {
        return $this->hasOne(Muscles::class, 'id', 'idmuscles_exercise');
    }

    public function divisionExecution(): HasOne
    {
        return $this->hasOne(Muscles::class, 'id', 'iddivision_execution');
    }

    public function specificity(): HasOne
    {
        return $this->hasOne(Muscles::class, 'id', 'idspecificity');
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
    public function scopeExcercisesFilters($query)
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
