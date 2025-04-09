<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function index()
    {
        $standards = Standard::all();

        return view('pages.website.standard', compact('standards'));
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
            $file->move(public_path('uploads/standard'), $fileName);

            // Create a new Opl instance
            $standard = new Standard();
            $standard->file = $fileName;
            $standard->save();
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
