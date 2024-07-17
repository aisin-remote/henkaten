<?php

namespace App\Console\Commands;

use App\Models\Skill;
use Illuminate\Console\Command;

class UpdateTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'for update only';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // update skill table ad origin id
        Skill::whereDate('created_at', '2024-03-18')
                ->update([
                    'origin_id' => '9ac7fcde-84b6-4076-9d9c-2eaa3486dcb8'
                ]);
    }
}
