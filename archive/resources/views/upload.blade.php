<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Research Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Upload Your Research Project</h3>
                    <form method="POST" action="{{ route('research-document.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Project Name -->
                        <div>
                            <label for="project_name" class="block font-medium text-sm text-gray-700">Project
                                Name</label>
                            <input type="text" name="project_name" id="project_name"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter project name" required>
                        </div>

                        <!-- Members -->
                        <div>
                            <label for="members" class="block font-medium text-sm text-gray-700">Members</label>
                            <input type="text" name="members" id="members"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter member names" required>
                        </div>

                        <!-- Abstract -->
                        <div>
                            <label for="abstract" class="block font-medium text-sm text-gray-700">Abstract</label>
                            <textarea name="abstract" id="abstract" rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Write a brief abstract" required></textarea>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block font-medium text-sm text-gray-700">File (PDF or DOCX)</label>
                            <input type="file" name="file" id="file" accept=".pdf,.docx"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="banner_image" class="block font-medium text-sm text-gray-700">Banner
                                Image</label>
                            <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block font-medium text-sm text-gray-700">Department</label>
                            <select name="department" id="department"
                                class="block mt-1 w-full border-gray-300 rounded-lg">
                                <option value="">All Departments</option>
                                <option value="Computer Science" {{ request('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                <option value="Biology" {{ request('department') == 'Biology' ? 'selected' : '' }}>Biology
                                </option>
                            </select>

                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-200 ease-in-out">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>