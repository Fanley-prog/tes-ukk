<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class templates extends Model
{
    protected $primaryKey = 'id_template';

    protected $fillable = ['name_template'];
}
