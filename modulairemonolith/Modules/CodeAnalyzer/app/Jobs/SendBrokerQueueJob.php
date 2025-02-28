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
    public function __construct(private readonly Jobs $userjob)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GithubService $git, MessageBroker $broker): void
    {
        foreach ($this->userjob->items as $item) {
            $code = $git->getBlob($this->userjob->owner, $this->userjob->repo, $item->blob_sha);
            $task = new JobDTO($this->userjob->id, $this->userjob->user_id, $item->id, $code);
            $broker->addJob($task->toJson());
        }
    }
}
