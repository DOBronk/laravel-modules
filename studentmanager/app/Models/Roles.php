<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name'];

    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user', 'role_id')->withTimestamps();
    }

}
