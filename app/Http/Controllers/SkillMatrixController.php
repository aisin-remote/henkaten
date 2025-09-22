<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SkillMatrix;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class SkillMatrixController extends Controller
{
    public function index()
    {
        $skills = SkillMatrix::all();

        return view('pages.website.skillMatrix', compact('skills'));
    }
    

    // helper kecil untuk translate kode error ke pesan
    private function uploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE   => 'Ukuran file melebihi upload_max_filesize di php.ini',
            UPLOAD_ERR_FORM_SIZE  => 'Ukuran file melebihi MAX_FILE_SIZE di form',
            UPLOAD_ERR_PARTIAL    => 'File hanya ter-upload sebagian',
            UPLOAD_ERR_NO_FILE    => 'Tidak ada file yang di-upload',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder tmp tidak ditemukan (upload_tmp_dir)',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk (permission /tmp)',
            UPLOAD_ERR_EXTENSION  => 'Upload dihentikan ekstensi PHP',
            default               => 'Error upload tidak diketahui (code '.$code.')',
        };
    }

    public function handleFormSubmission(Request $request)
    {
        try {
            $request->validate([
                'repeater-group'        => 'required|array|min:1',
                'repeater-group.*.name' => 'required|file|mimes:pdf,xls,xlsx,csv|max:20480',
            ]);

            $rows = $request->allFiles()['repeater-group'] ?? [];
            if (!$rows) throw new \Exception('Tidak ada file yang diterima.');

            foreach ($rows as $i => $row) {
                /** @var UploadedFile|null $file */
                $file = $row['name'] ?? null;
                if (!$file) throw new \Exception("Item #$i: field file tidak ditemukan.");

                if (!$file->isValid()) {
                    $code = $file->getError();
                    $fname = $file->getClientOriginalName();
                    $msg = $this->uploadErrorMessage($code);
                    throw new \Exception("Gagal upload '{$fname}': {$msg}");
                }

                $path = $file->store('skill_matrix', 'public');
                SkillMatrix::create(['file' => $path]);
            }

            return back()->with('success', 'Form submitted successfully!');
        } catch (\Throwable $e) {
            \Log::error('SkillMatrix submission error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
