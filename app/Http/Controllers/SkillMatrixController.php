<?php

namespace App\Http\Controllers;

use Exception;
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
        try {
            // 1) Validasi
            $request->validate([
                'repeater-group'            => 'required|array|min:1',
                'repeater-group.*.name'     => 'required|file|mimes:pdf,xls,xlsx,csv|max:20480',
            ]);

            // 2) Ambil semua file
            $allFiles = $request->allFiles();
            $rows = $allFiles['repeater-group'] ?? [];

            if (empty($rows)) {
                throw new Exception('Tidak ada file yang diterima.');
            }

            // 3) Loop simpan
            foreach ($rows as $row) {
                $file = $row['name'] ?? null;
                if (!$file || !$file->isValid()) {
                    throw new Exception('File tidak valid.');
                }

                // Simpan file
                $path = $file->store('skill_matrix', 'public');

                // Simpan ke DB
                $skillMatrix = new SkillMatrix();
                $skillMatrix->file = $path;
                $skillMatrix->save();
            }

            return back()->with('success', 'Form submitted successfully!');
        } catch (Exception $e) {
            // Log error supaya bisa dicek di storage/logs/laravel.log
            \Log::error('SkillMatrix submission error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
