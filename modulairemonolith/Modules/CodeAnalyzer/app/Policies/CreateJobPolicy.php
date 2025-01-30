<?php

namespace Modules\CodeAnalyzer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use Modules\CodeAnalyzer\Models\Jobs;

class CreateJobPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function noActiveJobs(User $user)
    {
        return Jobs::where('user_id', '=', $user->id)->where('active', '=', '1')->count() == 0;
    }
}
