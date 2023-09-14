<?php

namespace App\Models\Excercises\TypeExcercises;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionExecutionMuscle extends Model
{
    use HasFactory;

    protected $table = 'tbl_division_execution_excercises';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
