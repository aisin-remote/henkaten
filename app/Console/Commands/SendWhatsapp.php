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
            env('ORIGIN_MA') => env('GROUP_ID_MA') . '@g.us',
            env('ORIGIN_DC') => env('GROUP_ID_DC') . '@g.us',
            env('ORIGIN_ELC') => env('GROUP_ID_ELC') . '@g.us',
            env('ORIGIN_SEAT') => env('GROUP_ID_BODY') . '@g.us',
            env('ORIGIN_HANDLE') => env('GROUP_ID_BODY') . '@g.us',
        ];
        
        $henkaten = []; // Initialize the result array

        foreach ($origins as $key => $value) {
            $baseQuery = Henkaten::with('line')
                                ->where('date', 'LIKE', $yesterday .'%')
                                ->whereHas('line', function ($query) use ($key) {
                                    $query->where('origin_id', $key);
                                });
                                
            $baseQueryTotal = Henkaten::with('line')
                                ->whereHas('line', function ($query) use ($key) {
                                    $query->where('origin_id', $key);
                                });
            
            // Clone the base query to apply different conditions
            $totalQuery = clone $baseQuery;
            $solvedQuery = clone $baseQuery;
            $unsolvedQuery = clone $baseQuery;
            $totalUnsolvedQuery = clone $baseQueryTotal;
            
            $henkaten[$key]['total'] = $totalQuery->count();
            $henkaten[$key]['solved'] = $solvedQuery->where('is_done', '1')->count();
            $henkaten[$key]['unsolved'] = $unsolvedQuery->where('is_done', '0')->count();
            $henkaten[$key]['total_unsolved'] = $totalUnsolvedQuery->where('is_done', '0')->get();
        }

        try {

            
            foreach ($origins as $key => $value) {
                $lineGroup = Origin::select('name')->where('id', $key)->first();

                $pendingIssuesMessage = "";

                if (isset($henkaten[$key]['total_unsolved']) && $henkaten[$key]['total_unsolved'] instanceof \Illuminate\Support\Collection && !$henkaten[$key]['total_unsolved']->isEmpty()) {
                    foreach ($henkaten[$key]['total_unsolved'] as $pending) { 

                        $status = $pending->troubleshoot == null ? 'Waiting Troubleshoot' : 'Waiting Approval';

                        $clean = function ($v) {
                            $v = (string) $v;
                            $v = str_replace(["```", "\r", "\n"], ["'''", ' ', ' '], trim($v));
                            return $v;
                        };

                        $pendingLine   = $clean($pending->line?->name ?? '-');
                        $desc          = $clean($pending->abnormality ?? '-');
                        $sts           = $clean($status ?? '-');
                        $dt            = \Carbon\Carbon::parse($pending->date ?? $pending->created_at)
                                            ->timezone('Asia/Jakarta')
                                            ->format('Y-m-d');

                        $pendingIssuesMessage .=
                            "- Line       : ```{$pendingLine}```\n" .
                            "  Description: ```{$desc}```\n" .
                            "  Status     : ```{$sts}```\n" .
                            "  Date       : ```{$dt}```\n\n";
                    }
                }else{
                    $pendingIssuesMessage = "- No pending issues\n";
                }

                $token = '793D30579A77D4A0E12648872BFBB085';
                $phone = $value;
                // Pass array elements as additional arguments to sprintf
                $message = "```------ ```*AIIA HENKATEN ALERT*``` ------\n\n"
                    . "LINE GROUP     : ```" . $lineGroup->name . "```\n"
                    . "DATE           : ```" . $yesterdayDate . "```\n"
                    . "TOTAL HENKATEN : ```" . $henkaten[$key]['total'] . "```\n"
                    . "SOLVED         : ```" . $henkaten[$key]['solved'] . "```\n"
                    . "UNSOLVED       : ```" . $henkaten[$key]['unsolved'] . "```\n"
                    . "\n"
                    . "PENDING ISSUES :\n"
                    . $pendingIssuesMessage . "\n"
                    . "------ BY AISIN BISA ------```";
            
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://app.fastwa.com/api/v1/4D9AF7CE224B91C9CE14FFDDB55D248D/send_text',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    // Use http_build_query to properly encode the POST fields
                    CURLOPT_POSTFIELDS => http_build_query([
                        'api_key' => $token,
                        'phone' => $phone,
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
