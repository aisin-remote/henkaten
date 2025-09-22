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
            UPLOAD_ERR_INI_SIZE   => 'Melebihi upload_max_filesize (php.ini)',
            UPLOAD_ERR_FORM_SIZE  => 'Melebihi MAX_FILE_SIZE (form)',
            UPLOAD_ERR_PARTIAL    => 'Hanya ter-upload sebagian',
            UPLOAD_ERR_NO_FILE    => 'Tidak ada file diunggah',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder tmp hilang (upload_tmp_dir)',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis ke disk (permission/space tmp)',
            UPLOAD_ERR_EXTENSION  => 'Diblokir oleh ekstensi PHP',
            default               => 'Error upload tidak diketahui (code '.$code.')',
        };
    }

    public function handleFormSubmission(Request $request)
    {
        try {
            // Validasi dulu
            $request->validate([
                'repeater-group'        => 'required|array|min:1',
                'repeater-group.*.name' => 'required|file|mimes:pdf,xls,xlsx,csv|max:20480', // 20 MB
            ]);

            $rows = $request->allFiles()['repeater-group'] ?? [];
            if (!$rows) {
                return back()->with('error', 'Tidak ada file yang diterima (rows kosong).');
            }

            foreach ($rows as $i => $row) {
                /** @var UploadedFile|null $file */
                $file = $row['name'] ?? null;
                if (!$file) {
                    throw new \Exception("Item #$i: field file tidak ditemukan.");
                }

                if (!$file->isValid()) {
                    $code = $file->getError();
                    $fname = $file->getClientOriginalName();

                    // Kumpulkan diagnostik server
                    $diag = [
                        'upload_max_filesize' => ini_get('upload_max_filesize'),
                        'post_max_size'       => ini_get('post_max_size'),
                        'file_uploads'        => ini_get('file_uploads'),
                        'upload_tmp_dir'      => ini_get('upload_tmp_dir') ?: '(default)',
                        'sys_get_temp_dir'    => sys_get_temp_dir(),
                        // NB: is_writable bisa false-positif di sebagian hosting, tapi tetap berguna
                        'tmp_writable'        => @is_writable(sys_get_temp_dir()) ? 'yes' : 'no',
                    ];

                    $msg = "Gagal upload '{$fname}': ".$this->uploadErrorMessage($code)
                        . " | Diagnostik: ".json_encode($diag);

                    throw new \Exception($msg);
                }

                // Simpan ke storage/app/public/skill_matrix
                $path = $file->store('skill_matrix', 'public'); // symlink: php artisan storage:link
                SkillMatrix::create(['file' => $path]);
            }

            return back()->with('success', 'Form submitted successfully!');
        } catch (\Throwable $e) {
            \Log::error('SkillMatrix submission error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
