<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\User;
use App\Models\Henkaten;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send henkaten summary daily via Whatsapp';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        $yesterdayDate = Carbon::yesterday()->format('d-m-Y');

        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $henkaten = Henkaten::where('date', 'LIKE', $yesterday .'%');
        
        // get total henkaten
        $totalHenkaten = $henkaten->count();
        
        // get total solved
        $totalSolved = $henkaten->where('is_done', '1')->count();
        $totalUnsolved =  Henkaten::where('date', 'LIKE', $yesterday .'%')->where('is_done', '0')->count();

        try {
            $token = 'v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1';
            $phone = '120363233997432617';
            $message = sprintf("```------ ```*AIIA HENKATEN ALERT*``` ------ %c%cDATE           : ```$yesterdayDate```%cTOTAL HENKATEN : ```$totalHenkaten```%cTOTAL SOLVED   : ```$totalSolved```%cTOTAL UNSOLVED : ```$totalUnsolved```%c%c------ BY AISIN BISA ------```",10,10,10,10,10,10,10);
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $phone . '&message=' . $message,
            ]);
            $response = curl_exec($curl);
            $this->info('Whatsapp sent successfully!');
        } catch (\Throwable $th) {
            $this->info($th->getMessage());
        }
        
    }
}
