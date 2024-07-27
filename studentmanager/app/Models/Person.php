<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'first_name', 'last_name', 'dob', 'email', 'phone', 'role'];

    protected $table = 'persons';
}
