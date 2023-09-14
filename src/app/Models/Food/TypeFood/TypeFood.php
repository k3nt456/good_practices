<?php

namespace App\Models\Food\TypeFood;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFood extends Model
{
    use HasFactory;

    protected $table = 'tbl_type_food';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
