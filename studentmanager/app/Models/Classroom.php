<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'year', 'mentor_id'];

    protected $table = 'classrooms';

    /**
     * Returns the mentor associated with this schoolclass
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mentor(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'mentor_id');
    }

    /**
     * Return students attached to this schoolclass
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}

