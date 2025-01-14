<?php

namespace Modules\CodeAnalyzer\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;
use Modules\CodeAnalyzer\Emails\CaMail;
use Modules\CodeAnalyzer\Services\OllamaService;
use Modules\CodeAnalyzer\Services\GithubService;
use Modules\CodeAnalyzer\Models\Jobs;

class OllamaPromptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Jobs $userjob)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ollama = app(OllamaService::class);
        $git = app(GithubService::class);
        $items = $this->userjob->Items()->get();

        foreach ($items as $item) {
            $code = $git->getBlob($this->userjob->owner, $this->userjob->repo, $item->blob_sha);
            $response = $ollama->findIssues($code);

            try {
                $array = json_decode($response);
            } catch (Exception $exception) {
                Mail::to(new Address("error@bronk-ict.nl"))->send(new CaMail("SHA: {$item->blob_sha} {$response}"));
            }
            $item->status = 1;
            $item->save();
            Mail::to(new Address("dennis@bronk-ict.nl"))->send(new CaMail("SHA: {$item->blob_sha} {$response}"));
            if (!$this->userjob->active) {
                break;
            }
        }

        $this->userjob->active = 0;
        $this->userjob->save();
    }
}
