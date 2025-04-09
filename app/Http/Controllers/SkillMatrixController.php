<?php

namespace App\Http\Controllers;

use App\Models\SkillMatrix;
use Illuminate\Http\Request;

class SkillMatrixController extends Controller
{
    public function index()
    {
        $skills = SkillMatrix::all();

        return view('pages.website.skillMatrix', compact('skills'));
    }
    
    public function handleFormSubmission(Request $request)
    {
        // Validate the form data
        $request->validate([
            'repeater-group.*.name' => 'required|mimes:pdf,xls,xlsx', // Adjust the file types and size as needed
        ]);

        $repeaterData = $request->file('repeater-group');

        foreach ($repeaterData as $fileData) {
            $file = $fileData['name'];
            $originalName = $file->getClientOriginalName();

            $fileName = $originalName;

            // Store or process each file as needed
            $file->move(public_path('uploads/skill_matrix'), $fileName);

            // Create a new Opl instance
            $skillMatrix = new SkillMatrix();
            $skillMatrix->file = $fileName;
            $skillMatrix->save();
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
