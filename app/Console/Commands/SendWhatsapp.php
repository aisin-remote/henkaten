<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\User;
use App\Models\Origin;
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
        
        $origins = [
            env('ORIGIN_MA') => env('GROUP_ID_MA'),
            env('ORIGIN_DC') => env('GROUP_ID_DC'),
            env('ORIGIN_ELC') => env('GROUP_ID_ELC'),
        ];
        
        $henkaten = []; // Initialize the result array

        foreach ($origins as $key => $value) {
            $baseQuery = Henkaten::with('line')
                                ->where('date', 'LIKE', $yesterday .'%')
                                ->whereHas('line', function ($query) use ($key) {
                                    $query->where('origin_id', $key);
                                });
            
            // Clone the base query to apply different conditions
            $totalQuery = clone $baseQuery;
            $solvedQuery = clone $baseQuery;
            $unsolvedQuery = clone $baseQuery;
            
            $henkaten[$key]['total'] = $totalQuery->count();
            $henkaten[$key]['solved'] = $solvedQuery->where('is_done', '1')->count();
            $henkaten[$key]['unsolved'] = $unsolvedQuery->where('is_done', '0')->count();
        }

        try {

            foreach ($origins as $key => $value) {
                $lineGroup = Origin::select('name')->where('id', $key)->first();

                $token = 'v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1';
                $phone = $value;
                // Pass array elements as additional arguments to sprintf
                $message = sprintf(
                    "```------ ```*AIIA HENKATEN ALERT*``` ------\n\nLINE GROUP     : ```%s```\nDATE           : ```%s```\nTOTAL HENKATEN : ```%d```\nTOTAL SOLVED   : ```%d```\nTOTAL UNSOLVED : ```%d```\n\n------ BY AISIN BISA ------```",
                    $lineGroup->name,
                    $yesterdayDate, // Assuming $yesterdayDate is defined elsewhere and is a string
                    $henkaten[$key]['total'],
                    $henkaten[$key]['solved'],
                    $henkaten[$key]['unsolved']
                );
            
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
                    // Use http_build_query to properly encode the POST fields
                    CURLOPT_POSTFIELDS => http_build_query([
                        'token' => $token,
                        'number' => $phone,
                        'message' => $message
                    ]),
                ]);
                $response = curl_exec($curl);
                curl_close($curl); // Don't forget to close the cURL session once done
            }
            
            $this->info('Whatsapp sent successfully!');
        } catch (\Throwable $th) {
            $this->info($th->getMessage());
        }
        
    }
}
