<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schoolclass extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'year', 'mentor_id'];

    protected $table = 'persons';
}
