<?php

namespace Modules\CodeAnalyzer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
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

    public function noActiveJobs()
    {
        return Jobs::query()->currentUser()->activeJobs()->count()
            ? Response::deny("Not allowed while a job is active.") : Response::allow();
    }
}
