

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
                            <label for="search" class="block font-medium text-sm text-gray-700">Search</label>
                            <input type="text" name="search" id="search" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="department" class="block font-medium text-sm text-gray-700">Department</label>
                            <select name="department" id="department" class="block mt-1 w-full">
                                <option value="">All Departments</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Biology">Biology</option>
                                <!-- Add more departments as needed -->
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                    </form>

                    @foreach($documents as $document)
                        <div class="bg-gray-100 p-4 mb-4">
                            <h3>{{ $document->project_name }}</h3>
                            <p>Members: {{ $document->members }}</p>
                            <p>Abstract: {{ $document->abstract }}</p>
                            <p>Department: {{ $document->department }}</p>
                            <a href="{{ route('research-document.download', $document->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
