<?php

namespace Bronk\CodeAnalyzer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileUploadController
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('uploads');

        $code = file_get_contents(Storage::path($path));

        $test = Http::timeout(1800)->post("http://localhost:11434/api/generate", [
            'model' => 'codellama:13b',
            'prompt' => 'Can you analyze the following php code: \n' . $code,
            'stream' => false,
        ]);

        $response = $test->json();

        return view('code-analyzer::show', ['summary' => $response['response']]);
    }
}
