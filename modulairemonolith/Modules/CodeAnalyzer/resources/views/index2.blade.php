<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Upload een PHP bestand om te analyzeren!') }}
                    <form action="{{ route('codeanalyzer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
