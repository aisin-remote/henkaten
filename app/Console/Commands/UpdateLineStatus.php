<?php

namespace App\Console\Commands;

use App\Models\Line;
use Illuminate\Console\Command;

class UpdateLineStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-line-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update all column in line table where status is henkaten';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 
    }
}
