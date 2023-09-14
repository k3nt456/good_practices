<?php

namespace App\Models\Excercises\TypeExcercises;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muscles extends Model
{
    use HasFactory;

    protected $table = 'tbl_muscles_exercise';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
