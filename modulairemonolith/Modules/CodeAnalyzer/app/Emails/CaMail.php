<?php

namespace Modules\CodeAnalyzer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly string $summary)
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('codeanalyzer::mail', ['code' => $this->summary]);
    }
}
