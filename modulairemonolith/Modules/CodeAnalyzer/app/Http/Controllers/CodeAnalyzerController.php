<?php

namespace Modules\CodeAnalyzer\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Modules\CodeAnalyzer\Services\OllamaService;

use Modules\CodeAnalyzer\Jobs\OllamaPromptJob;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\CodeAnalyzer\Models\Jobs;

use Modules\CodeAnalyzer\Services\GithubService;

//use App\Services\GitHubService;

use Modules\CodeAnalyzer\Services\RabbitMqService
;
class CodeAnalyzerController extends Controller
{
    public function createStepOne(Request $request)
    {
        return view('codeanalyzer::createjob1');
    }

    public function createStepTwo(Request $request, GitHubService $git, OllamaService $lama)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
        ]);

        $repo = $data['repository'];
        $owner = $data['owner'];
        // TODO: Proper error handling in both getPhpFilesFromTree and here
        $items = $git->getPhpFilesFromTree($owner, $repo);

        // dd($this->buildTree($items));

        return view('codeanalyzer::createjob2', [
            'owner' => $request['owner'],
            'repository' => $request['repository'],
            'items' => $this->buildTree($items),
        ]);
    }

    public function postCreateStepOne(Request $request)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
        ]);

        $repo = $data['repository'];
        $owner = $data['owner'];

        return redirect()->route('codeanalyzer.create.step.two', [
            'repository' => $repo,
            'owner' => $owner
        ]);
    }

    private function buildTree($files)
    {
        $tree = [];

        foreach ($files as $file) {
            $parts = explode('/', $file['path']);
            $current = &$tree;

            foreach ($parts as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }
            $current['?'] = $file['sha'];
            $current['*'] = $file['path'];
        }

        return $tree;
    }

    public function postCreateStepTwo(Request $request)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
            'selectedItems.*' => 'required',
        ]);

        $repo = $data['repository'];
        $owner = $data['owner'];

        //    dd($request->selectedItems);

        $job = Jobs::create([
            'user_id' => $request->user()->id,
            'owner' => $owner,
            'repo' => $repo,
            'active' => 1
        ]);

        foreach ($request->selectedItems as $item) {
            $values = explode("|", $item);
            $job->items()->create([
                'path' => $values[1],
                'blob_sha' => $values[0],
                'status' => 0,
                'results' => "0"
            ]);
        }

        dispatch(new OllamaPromptJob($job));

        return redirect()->route("codeanalyzer.index");
        // return view('codeanalyzer::createjob2', ['repository' => $repo, 'owner' => $owner, 'items' => $items]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $jobs = Jobs::where('active', '=', 1, 'and', 'user_id', '=', $request->user()->id)->get();
        $jobs = Jobs::where('user_id', '=', $request->user()->id)->get();

        /*    if ($jobs->count() > 0) {
                $job = $jobs->first();
                $items = $job->items()->get();
                return view('codeanalyzer::activejob', ['items' => $items]);
            } */

        return view('codeanalyzer::jobdetails', ['items' => $jobs]);
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
    public function store(Request $request, GitHubService $git)
    {
        // $git = app(GithubService::class);
        $owner = "DOBronk";
        $repo = "laravel";

        $job = Jobs::create([
            'user_id' => $request->user()->id,
            'owner' => $owner,
            'repo' => $repo,
            'active' => 1
        ]);

        $kill = $git->getPhpFilesFromTree("DOBronk", "laravel"); // "1087afb04cfa349f6bbc397b0d14691176027315");

        $i = 0;
        foreach ($kill as $item) {
            $job->items()->create([
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
