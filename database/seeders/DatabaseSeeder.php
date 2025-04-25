<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Yell;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Theme;
use App\Models\Origin;
use App\Models\Position;
use App\Models\SkillDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $yells = [
            ['item_no_1' => 'Lakukan SCW bila terjadi abnormal.','item_no_2' => 'Lakukan SCW bila terjadi abnormal.','item_no_3' => 'Lakukan SCW bila terjadi abnormal.','date' => '2025-05-01'],
            ['item_no_1' => 'Angkat benda berat dengan cara yang benar.', 'item_no_2' => 'Jangan gunakan api di area dilarang api.', 'item_no_3' => 'Lakukan "One Cycle Progress" sebelum berhenti bekerja.', 'date' => '2025-05-02'],
            ['item_no_1' => 'Lakukan cek safety device dan emergency stop sebelum bekerja.', 'item_no_2' => 'Kendaraan yang dipakai kerja sesuai dengan standart.', 'item_no_3' => 'Selalu berkonsentrasi dalam bekerja.', 'date' => '2025-05-03'],
            ['item_no_1' => 'Berjalan di jalur pejalan kaki.', 'item_no_2' => 'Tempatkan Bahan B3 pada tempat yang sudah ditentukan.', 'item_no_3' => 'Letakkan part sesuai dengan tempat dan name plate.', 'date' => '2025-05-05'],
            ['item_no_1' => 'Kunci kedua roda trolley saat berhenti.', 'item_no_2' => 'Matikan kipas angin dan lampu ketika tidak dipakai.', 'item_no_3' => 'Beri tag atau marking merah pada part NG.', 'date' => '2025-05-05'],
            ['item_no_1' => 'Lakukan pekerjaan sesuai dengan WI/S.', 'item_no_2' => 'Jangan menutupi APAR dengan benda lain.', 'item_no_3' => 'Tidak ngobrol saat melakukan proses produksi.', 'date' => '2025-05-06'],
            ['item_no_1' => 'Pekerjaan abnormal hanya dilakukan oleh MP yang sudah ditunjuk.', 'item_no_2' => 'Berdoa sebelum berkendara.', 'item_no_3' => 'Masukan part/packing ke dalam box NG.', 'date' => '2025-05-07'],
            ['item_no_1' => 'Tidak membawa part yang melebihi pandangan mata.', 'item_no_2' => 'Lapor atasan ketika ada kabel terkelupas.', 'item_no_3' => 'Tidak mencampur part NG dan OK dalam satu box.', 'date' => '2025-05-08'],
            ['item_no_1' => 'Tengok kanan kiri sebelum menyeberang.', 'item_no_2' => 'Bahan B3 harus ada MSDS, bila tidak ada segera SCW.', 'item_no_3' => 'Update papan hentikan setiap awal shift.', 'date' => '2025-05-09'],
            ['item_no_1' => 'Tidak menaiki kereta atau trolley.', 'item_no_2' => 'Matikan mesin ketika tidak dipakai.', 'item_no_3' => 'Gunakan lampu andon untuk memanggil atasan.', 'date' => '2025-05-10'],
            ['item_no_1' => 'Tidak berlari di dalam pabrik.', 'item_no_2' => 'Bersihkan tumpahan atau ceceran bahan B3.', 'item_no_3' => 'Next proses adalah customer.', 'date' => '2025-05-11'],
            ['item_no_1' => 'Menggunakan body harness ketika kerja di ketinggian.', 'item_no_2' => 'Jangan meletakkan benda lain di depan box panel.', 'item_no_3' => 'Lakukan pengecekan periodik sesuai standardnya.', 'date' => '2025-05-12'],
            ['item_no_1' => 'Tidak menumpuk barang melebihi standart ketinggiannya.', 'item_no_2' => 'Pastikan surat-surat kendaraan dan SIM masih berlaku.', 'item_no_3' => 'Tidak ngobrol saat berproduksi.', 'date' => '2025-05-13'],
            ['item_no_1' => 'Tidak memasuki area berpagar atau bahaya tanpa memasang LoTo.', 'item_no_2' => 'Laporkan atasan jika melihat kebocoran oli atau coolant.', 'item_no_3' => 'Beri marking pada part yang sudah dilakukan pengecekan.', 'date' => '2025-05-14'],
            ['item_no_1' => 'Tidak mengoperasikan HP sambil berjalan.', 'item_no_2' => 'Matikan laptop ketika tidak dipakai.', 'item_no_3' => 'Lakukan preventive mesin dan mould sesuai standard waktunya.', 'date' => '2025-05-15'],
            ['item_no_1' => 'Tidak duduk di chute atau kereta.', 'item_no_2' => 'Teriak yang kencang ketika melihat api.', 'item_no_3' => 'Lakukan pekerjaan sesuai dengan WI/S.', 'date' => '2025-05-16'],
            ['item_no_1' => 'Lakukan 3F bila ada keluhan atau kecemasan dalam bekerja.', 'item_no_2' => 'Hati-hati dalam berkendara saat hujan.', 'item_no_3' => 'Pastikan part OK sebelum dikirim ke next proses.', 'date' => '2025-05-17'],
            ['item_no_1' => 'Lakukan SCW bila terjadi abnormal.', 'item_no_2' => 'Lakukan SCW bila terjadi abnormal.', 'item_no_3' => 'Lakukan SCW bila terjadi abnormal.', 'date' => '2025-05-18'],
            ['item_no_1' => 'Gunakan APD yang sesuai ketika masuk area kerja.', 'item_no_2' => 'Segera lapor atasan jika terkena cipratan bahan B3 ke mata.', 'item_no_3' => 'Tidak menggunakan tool yang rusak.', 'date' => '2025-05-19'],
            ['item_no_1' => 'Jangan dibawah objek yang sedang loading atau tergantung.', 'item_no_2' => 'Improve line stop untuk meningkatkan efisiensi (hemat waktu - hemat listrik).', 'item_no_3' => 'Lakukan first quality check sebelum produksi dalam jumlah banyak.', 'date' => '2025-05-20'],
            ['item_no_1' => 'Tidak memasukkan tangan ke saku celana ketika berjalan.', 'item_no_2' => 'Bersihkan kipas angin sesuai standartnya.', 'item_no_3' => 'Isi cek sheet parameter di awal shift.', 'date' => '2025-05-21'],
            ['item_no_1' => 'Jangan menyentuh benda yang sedang bergerak.', 'item_no_2' => 'Pastikan paham kondisi jalan saat berkendara.', 'item_no_3' => 'Lakukan 3 point check sebelum mengambil atau melekatkan part.', 'date' => '2025-05-22'],
            ['item_no_1' => 'Jangan menyentuh benda yang akan bergerak.', 'item_no_2' => 'Tidak mencolok charger HP di sembarang tempat.', 'item_no_3' => 'Lakukan cek mesin secara berkala sesuai ketentuannya.', 'date' => '2025-05-23'],
            ['item_no_1' => 'Jangan palingkan mata dari tangan yang sedang bekerja.', 'item_no_2' => 'Gunakan Helm yang sesuai standart.', 'item_no_3' => 'Tidak menjalankan proses produksi yang bukan menjadi tugasnya.', 'date' => '2025-05-24'],
            ['item_no_1' => 'Pegang hand rail ketika naik turun tangga.', 'item_no_2' => 'Buang sampah sesuai dengan tempatnya.', 'item_no_3' => 'Lakukan pengecekan part secara periodik saat bekerja.', 'date' => '2025-05-25'],
            ['item_no_1' => 'Tidak berdiri atau berjalan di atas roller.', 'item_no_2' => 'Matikan kipas ketika tidak dipakai.', 'item_no_3' => 'Cuci muka bila mengantuk.', 'date' => '2025-05-26'],
            ['item_no_1' => 'Lakukan pengecekan sling tiap awal shift.', 'item_no_2' => 'Tidak meletakkan barang mudah terbakar di area panas.', 'item_no_3' => 'Lakukan cek alat ukur sebelum dipakai.', 'date' => '2025-05-27'],
            ['item_no_1' => 'Tidak mengoperasikan mesin yang bukan tugasnya.', 'item_no_2' => 'Utamakan keselamatan bukan kecepatan.', 'item_no_3' => 'Lakukan pekerjaan sesuai dengan WI/S.', 'date' => '2025-05-28'],
            ['item_no_1' => 'Tidak masuk jalur merah, jalur forklift dan truck (selain PIC).', 'item_no_2' => 'Tidak memakai bahan B3 bila belum mengerti MSDSnya.', 'item_no_3' => 'Utamakan kualitas bukan kuantitas.', 'date' => '2025-05-29'],
            ['item_no_1' => 'Irregular job harus mendapat pengarahan dari minimal leader.', 'item_no_2' => 'Tidak men-setting kipas terlalu kencang.', 'item_no_3' => 'Tidak mengoperasikan HP saat produksi.', 'date' => '2025-05-30'],
            ['item_no_1' => 'Tidak menggunakan cutter yang tidak teregistrasi.', 'item_no_2' => 'Membantu mencari APAR jika terjadi kebakaran di area kerja.', 'item_no_3' => 'Tidak melakukan repair part tanpa perintah atasan.', 'date' => '2025-05-31']
        ];
        
        foreach ($yells as $yell) {
            Yell::create($yell);
        }
    }
}
