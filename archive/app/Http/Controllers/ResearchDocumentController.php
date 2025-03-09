<?php

// app/Http/Controllers/ResearchDocumentController.php

namespace App\Http\Controllers;

use App\Models\ResearchDocument;
use Illuminate\Http\Request;

class ResearchDocumentController extends Controller
{
    // Index method to list research documents with search and department filters
    public function index(Request $request)
    {
        $documents = ResearchDocument::query();
    
        // Apply search filter if search parameter is provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $documents->where(function ($query) use ($searchTerm) {
                $query->where('project_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('members', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('abstract', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Apply department filter if department parameter is provided
        if ($request->filled('department')) {
            $documents->where('department', $request->department);
        }
    
        // Fetch the filtered documents
        $documents = $documents->get();
    
        // Return the view with the documents data
        return view('dashboard', compact('documents'));
    }
    

    // Method to approve a research document
    public function approve($id)
    {
        $research = ResearchDocument::findOrFail($id);
        $research->approved = true;
        $research->save();

        // Update the route to reflect the correct admin dashboard
        return redirect()->route('adminDashboard')->with('success', 'Research approved successfully!');
    }

    // Method to reject a research document
    public function reject($id)
    {
        $research = ResearchDocument::findOrFail($id);
        $research->approved = false;
        $research->save();

        // Update the route to reflect the correct admin dashboard
        return redirect()->route('adminDashboard')->with('success', 'Research rejected!');
    }

    // Store method to handle research document upload
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
    
        $documentPath = null;
        $bannerPath = null;
    
        // Handle document upload
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }
    
        // Handle banner upload
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }
    
        // Store in database
        $research = new ResearchDocument();
        $research->title = $request->title;
        $research->author = $request->author;
        $research->description = $request->description;
        $research->category = $request->category;
        $research->document = $documentPath;
        $research->banner = $bannerPath;
        $research->save();
    
        return redirect()->back()->with('success', 'Research document uploaded successfully!');
    }
    

    // Method to download a research document
    public function download($id)
    {
        $document = ResearchDocument::find($id);
        
        // Ensure the file exists before attempting to download
        if ($document && file_exists(storage_path('app/public/' . $document->file_path))) {
            return response()->download(storage_path('app/public/' . $document->file_path));
        } else {
            return redirect()->route('dashboard')->with('error', 'File not found.');
        }
    }

    // Admin Dashboard method to view all research documents
    public function adminDashboard()
    {
        // Retrieve all research documents (you can add filtering or pagination here)
        $researches = ResearchDocument::all();

        // Return the admin view and pass the research documents
        return view('admin.dashboard', compact('researches'));
    }


    
}
