<?php

namespace Modules\CodeAnalyzer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\CodeAnalyzer\Services\GithubService;
use Modules\CodeAnalyzer\Models\Jobs;
use Modules\CodeAnalyzer\DTO\JobDTO;
use Modules\CodeAnalyzer\Services\MessageBroker;

class SendBrokerQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Jobs $job)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GithubService $git, MessageBroker $broker): void
    {
        foreach ($this->job->items as $item) {
            $code = $git->getBlob($this->job->owner, $this->job->repo, $item->blob_sha);
            $task = new JobDTO($this->job->id, $this->job->user_id, $item->id, $code);
            $broker->addJob($task->toJson());
        }
    }
}
