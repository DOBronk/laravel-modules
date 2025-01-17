<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Geef een git repository op') }}
                    <form action="{{ route('codeanalyzer.create.step.one.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        Repository: <input type="text" name="repository" /> <br>
                        Eigenaar: <input type="text" name="owner" /> <br>
                        <button type="submit">Volgende stap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
