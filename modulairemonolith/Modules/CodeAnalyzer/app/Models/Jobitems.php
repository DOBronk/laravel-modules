<?php

namespace Modules\CodeAnalyzer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\CodeAnalyzer\Database\Factories\JobitemsFactory;

class Jobitems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['job_id', 'path', 'blob_sha', 'status'];
    protected $table = 'codeanalyzer_job_items';

    // protected static function newFactory(): JobitemsFactory
    // {
    //     // return JobitemsFactory::new();
    // }
}
