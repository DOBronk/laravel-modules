<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schoolclass extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'year', 'mentor_id'];

    protected $table = 'classrooms';

    /**
     * Returns the mentor associated with this classroom
     * @return User|null
     */
    public function mentor()
    {
        return $this->hasOne(User::class, 'id', 'mentor_id')->first();
    }

    public function students()
    {
        $ret = $this->belongsToMany(User::class)->withTimestamps();
        if ($ret) {
            return $ret;
        }
        return [];
    }

}

