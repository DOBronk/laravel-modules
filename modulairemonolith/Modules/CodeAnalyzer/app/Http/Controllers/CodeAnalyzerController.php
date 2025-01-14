<?php

namespace Modules\CodeAnalyzer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CodeAnalyzer\Services\OllamaService;

use Modules\CodeAnalyzer\Jobs\OllamaPromptJob;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\CodeAnalyzer\Models\Jobs;

use Modules\CodeAnalyzer\Services\GithubService;
use Modules\CodeAnalyzer\Services\RabbitMqService
;
class CodeAnalyzerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //    $rq = new RabbitMqService();
        //    $rq->createQueue("test", function ($msg) {
        //         $this->cb($msg);
        //     });

        $jobs = Jobs::where('active', '=', 1, 'and', 'user_id', '=', $request->user()->id)->get();

        if ($jobs->count() > 0) {
            $job = $jobs->first();
            $items = $job->Items()->get();
            return view('codeanalyzer::index3', ['items' => $items]);
        }
        //  Log::info("Issue: " . $git->createIssue("DOBronk", "laravel", "Test", "Testen van issue aanmaken"));
        return view('codeanalyzer::index2');
    }

    private function abc(Request $request)
    {
        $git = app(GithubService::class);

        $job = Jobs::create([
            'user_id' => $request->user()->id,
            'active' => 1
        ]);

        $owner = "DOBronk";
        $repo = "laravel";

        $kill = $git->getPhpFilesFromTree("DOBronk", "laravel", "1087afb04cfa349f6bbc397b0d14691176027315");
        foreach ($kill as $item) {
            $job->Items()->create([
                'owner' => $owner,
                'repo' => $repo,
                'path' => $item['path'],
                'blob_sha' => $item['sha'],
                'status' => 0
            ]);
        }
    }
    public function cb($msg)
    {
        Log::info("Rabbit MQ Message : {$msg}");
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('codeanalyzer::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $git = app(GithubService::class);
        $owner = "DOBronk";
        $repo = "laravel";

        $job = Jobs::create([
            'user_id' => $request->user()->id,
            'owner' => $owner,
            'repo' => $repo,
            'active' => 1
        ]);

        $kill = $git->getPhpFilesFromTree("DOBronk", "laravel", "1087afb04cfa349f6bbc397b0d14691176027315");

        $i = 0;
        foreach ($kill as $item) {
            $job->Items()->create([
                'path' => $item['path'],
                'blob_sha' => $item['sha'],
                'status' => 0
            ]);
            $i++;
            if ($i == 10) {
                break;
            }
        }

        dispatch(new OllamaPromptJob($job));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('codeanalyzer::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('codeanalyzer::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
