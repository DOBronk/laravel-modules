<?php

namespace Modules\CodeAnalyzer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    // protected static function newFactory(): JobsFactory
    // {
    //     // return JobsFactory::new();
    // }
}
