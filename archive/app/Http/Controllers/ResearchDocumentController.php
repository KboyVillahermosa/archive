<?php

// app/Http/Controllers/ResearchDocumentController.php

namespace App\Http\Controllers;

use App\Models\ResearchDocument;
use Illuminate\Http\Request;

class ResearchDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ResearchDocument::query();

        // Apply search filter if provided
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('project_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('members', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('abstract', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Apply department filter if provided
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Fetch filtered documents
        $documents = $query->get();

        return view('dashboard', compact('documents'));
    }

    public function approve($id)
    {
        $research = ResearchDocument::findOrFail($id);
        $research->approved = true;
        $research->save();

        return redirect()->route('adminDashboard')->with('success', 'Research approved successfully!');
    }

    public function reject($id)
    {
        $research = ResearchDocument::findOrFail($id);
        $research->approved = false;
        $research->save();

        return redirect()->route('adminDashboard')->with('success', 'Research rejected!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'members' => 'required',
            'abstract' => 'required',
            'file' => 'required|mimes:pdf,docx',
            'department' => 'required',
        ]);

        $filePath = $request->file('file')->store('admin/admin_dashboard', 'public');

        ResearchDocument::create([
            'project_name' => $request->project_name,
            'members' => $request->members,
            'abstract' => $request->abstract,
            'file_path' => $filePath,
            'department' => $request->department,
        ]);

        return redirect()->route('dashboard')->with('success', 'Research document uploaded successfully!');
    }

    public function download($id)
    {
        $document = ResearchDocument::find($id);

        if ($document && file_exists(storage_path('app/public/' . $document->file_path))) {
            return response()->download(storage_path('app/public/' . $document->file_path));
        }

        return redirect()->route('dashboard')->with('error', 'File not found.');
    }

    public function adminDashboard()
    {
        $researches = ResearchDocument::all();

        return view('admin.dashboard', compact('researches'));
    }
}
