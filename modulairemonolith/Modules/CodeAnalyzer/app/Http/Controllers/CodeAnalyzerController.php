<?php

namespace Modules\CodeAnalyzer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CodeAnalyzer\Services\OllamaService;
use Modules\CodeAnalyzer\Jobs\OllamaPromptJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\CodeAnalyzer\Models\Jobs;
use Modules\CodeAnalyzer\Services\GithubService;
use Modules\CodeAnalyzer\Services\MessageBroker;
use Illuminate\Support\Facades\Gate;
;
class CodeAnalyzerController extends Controller
{
    public function createStepOne(Request $request)
    {
        return view('codeanalyzer::createjob1');
    }
    public function createStepTwo(Request $request, GitHubService $git)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
            'branch' => 'nullable|string',
        ]);

        $repo = $data['repository'];
        $owner = $data['owner'];
        $branch = $data['branch'] ?? 'main';

        // TODO: Proper error handling in both getPhpFilesFromTree and here
        $items = $git->getPhpFilesFromTree($owner, $repo, $branch);

        return view('codeanalyzer::createjob2', [
            'owner' => $owner,
            'repository' => $repo,
            'branch' => $branch,
            'items' => $this->buildTree($items),
        ]);
    }

    public function postCreateStepOne(Request $request)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
            'branch' => 'nullable|string'
        ]);

        return redirect()->route('codeanalyzer.create.step.two', [
            'repository' => $data['repository'],
            'owner' => $data['owner'],
            'branch' => $data['branch']
        ]);
    }
    public function postCreateStepTwo(Request $request)
    {
        $data = $request->validate([
            'owner' => 'required|string',
            'repository' => 'required|string',
            'selectedItems.*' => 'required',
        ]);

        DB::transaction(function () use ($request, $data) {
            $repo = $data['repository'];
            $owner = $data['owner'];

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
        });

        return redirect()->route("codeanalyzer.index");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MessageBroker $broker)
    {
        // TODO: Remove this line of code
        $broker->addJob("testbericht");

        $jobs = Jobs::where('user_id', '=', $request->user()->id)->get();

        return view('codeanalyzer::index', ['items' => $jobs]);
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
}
