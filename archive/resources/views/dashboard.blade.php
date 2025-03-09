<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <div class="mb-4">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block mt-1 w-full border-gray-300 rounded-lg">

                        </div>

                        <div class="mb-4">
                            <label for="department" class="block font-medium text-sm text-gray-700">Department</label>
                            <select name="department" id="department"
                                class="block mt-1 w-full border-gray-300 rounded-lg">
                                <option value="">All Departments</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Biology">Biology</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Filter</button>
                    </form>

                    <div id="document-container">
                        @foreach($documents as $index => $document)
                            <div
                                class="bg-gray-100 p-4 mb-4 rounded-lg shadow document-item {{ $index >= 4 ? 'hidden' : '' }}">
                                <h3 class="text-lg font-semibold">{{ $document->project_name }}</h3>
                                <p><strong>Members:</strong> {{ $document->members }}</p>
                                <p><strong>Abstract:</strong> {{ $document->abstract }}</p>
                                <p><strong>Department:</strong> {{ $document->department }}</p>

                                @if($document->banner_image)
                                    <img src="{{ asset('storage/' . $document->banner_image) }}" alt="Banner Image"
                                        class="mt-2 w-64 h-40 object-cover rounded-lg">
                                @else
                                    <p class="text-gray-500 mt-2">No banner image available</p>
                                @endif

                                @if($document->file_path)
                                    <button data-modal-target="pdfModal" data-modal-toggle="pdfModal"
                                        data-pdf-url="{{ asset('storage/' . $document->file_path) }}"
                                        class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg open-modal">
                                        View PDF
                                    </button>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('research-document.download', $document->id) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Download
                                        PDF</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button id="toggleButton"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg mt-4">
                        See More
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="pdfModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 right-0 left-0 z-50  justify-center items-center w-full h-[100]">
        <div class="relative p-4 w-full max-w-4xl h-[100]">
            <div class="relative bg-white w-full h-full rounded-lg shadow-sm dark:bg-gray-700 flex flex-col">
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">PDF Viewer</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="pdfModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5  h-[80vh] overflow-auto flex-grow">
                    <iframe id="pdfViewer" class="w-full h-full border rounded-lg"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.open-modal').forEach(button => {
                button.addEventListener('click', function () {
                    let pdfUrl = this.getAttribute('data-pdf-url');
                    document.getElementById('pdfViewer').src = pdfUrl;
                });
            });

            const toggleButton = document.getElementById("toggleButton");
            const documentItems = document.querySelectorAll(".document-item");

            toggleButton.addEventListener("click", function () {
                const hiddenItems = document.querySelectorAll(".document-item.hidden");

                if (hiddenItems.length > 0) {
                    hiddenItems.forEach(item => item.classList.remove("hidden"));
                    toggleButton.textContent = "See Less";
                } else {
                    documentItems.forEach((item, index) => {
                        if (index >= 4) item.classList.add("hidden");
                    });
                    toggleButton.textContent = "See More";
                }
            });
        });
    </script>

</x-app-layout>