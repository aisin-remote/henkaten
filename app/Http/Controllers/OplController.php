<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Opl;

class OplController extends Controller
{
    public function index()
    {
        $opls = Opl::all();

        return view('pages.website.opl', compact('opls'));
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
            $file->move(public_path('uploads/opl'), $fileName);

            // Create a new Opl instance
            $opl = new Opl();
            $opl->file = $fileName;
            $opl->save();
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
