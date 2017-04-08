<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TempPhone extends Model
{
    public $table = 'temp_phone';
    public $primaryKey = 'id';

    public $timestamps = false;
}
