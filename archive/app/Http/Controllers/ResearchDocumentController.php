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
        if ($request->has('search')) {
            $documents->where('project_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('members', 'LIKE', '%' . $request->search . '%')
                ->orWhere('abstract', 'LIKE', '%' . $request->search . '%');
        }
    
        // Apply department filter if department parameter is provided
        if ($request->has('department')) {
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
            'project_name' => 'required',
            'members' => 'required',
            'abstract' => 'required',
            'file' => 'required|mimes:pdf,docx',
            'department' => 'required',
        ]);

        // Store the uploaded file in the 'admin/admin_dashboard' directory
        $filePath = $request->file('file')->store('admin/admin_dashboard', 'public');

        // Create a new research document record
        ResearchDocument::create([
            'project_name' => $request->project_name,
            'members' => $request->members,
            'abstract' => $request->abstract,
            'file_path' => $filePath,
            'department' => $request->department,
        ]);

        return redirect()->route('dashboard');
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
