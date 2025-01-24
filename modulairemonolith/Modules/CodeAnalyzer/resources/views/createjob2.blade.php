<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Selecteer bestanden voor analyse') }}
                    <form action="{{ route('codeanalyzer.create.step.two.post') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $repository }}" name="repository" />
                        <input type="hidden" value="{{ $owner }}" name="owner" />
                        <script>
                            var toggler = document.getElementsByClassName("caret");
                                var i;

                                for (i = 0; i < toggler.length; i++) {
                                    toggler[i].addEventListener("click", function () {
                                        this.parentElement.querySelector(".nested").classList.toggle("active");
                                        this.classList.toggle("caret-down");
                                    });
                                }
                                </script>
                        <x-codeanalyzer::rendertree :tree="$items" />

                        <x-primary-button>Job aanmaken</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>