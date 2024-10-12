<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Classroom extends Model
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
        return $this->hasOne(User::class, 'id', 'mentor_id');
    }

    public function students(): BelongsToMany|Collection
    {
        $ret = $this->belongsToMany(User::class)->withTimestamps();
        if ($ret) {
            return $ret;
        }
        return collect([]);
    }

}

