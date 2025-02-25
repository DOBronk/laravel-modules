<?php

namespace Modules\CodeAnalyzer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
// use Modules\CodeAnalyzer\Database\Factories\JobsFactory;

class Jobs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'owner', 'repo', 'active'];
    protected $table = 'codeanalyzer_jobs';

    public function items()
    {
        return $this->hasMany(Jobitems::class, "job_id");
    }

    public function scopeActiveJobs(Builder $query): Builder
    {
        return $query->where('active', '=', '1');
    }

    public function scopeCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', '=', auth()->id());
    }
    // protected static function newFactory(): JobsFactory
    // {
    //     // return JobsFactory::new();
    // }
}
