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
        Skill::whereDate('created_at', '2023-11-17')
                ->update([
                    'origin_id' => '9ac7fcde-7c45-43ee-9a3b-ea9a29de66db'
                ]);
    }
}
