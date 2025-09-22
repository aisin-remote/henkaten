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
        // 1) Validasi: pastikan list & tiap file valid
        $request->validate([
            'repeater-group'            => 'required|array|min:1',
            'repeater-group.*.name'     => 'required|file|mimes:pdf,xls,xlsx,csv|max:20480',
        ]);

        // 2) Ambil semua file secara aman (nested & hyphen friendly)
        $allFiles = $request->allFiles();
        $rows = $allFiles['repeater-group'] ?? []; // array: [ ['name' => UploadedFile], ... ]

        // 3) Simpan pakai Storage disk 'public'
        foreach ($rows as $row) {
            $file = $row['name'] ?? null;
            if (!$file || !$file->isValid()) {
                continue; // atau throw jika mau strict
            }

            // Simpan ke storage/app/public/skill_matrix
            $path = $file->store('skill_matrix', 'public'); // butuh `php artisan storage:link` saat setup pertama

            // Simpan ke DB
            $skillMatrix = new SkillMatrix();
            $skillMatrix->file = $path; // simpan PATH, bukan cuma nama file
            $skillMatrix->save();
        }

        return back()->with('success', 'Form submitted successfully!');
    }
}
