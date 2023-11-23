<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Theme;
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
        Shift::create([
            'name' => 'Shift 1',
            'time_start' => '06:00:00',
            'time_end' => '14:15:00'
        ]);
        
        Shift::create([
            'name' => 'Shift 2',
            'time_start' => '14:10:00',
            'time_end' => '22:15:00'
        ]);

        Shift::create([
            'name' => 'Shift 3',
            'time_start' => '22:10:00',
            'time_end' => '06:05:00'
        ]);

        Shift::create([
            'name' => 'Shift 1 Long',
            'time_start' => '05:55:00',
            'time_end' => '18:00:00'
        ]);

        Shift::create([
            'name' => 'Shift 3 Long',
            'time_start' => '18:30:00',
            'time_end' => '07:00:00'
        ]);

        Shift::create([
            'name' => 'Non Shift',
            'time_start' => '07:15:00',
            'time_end' => '16:20:00'
        ]);
            
        // Line
        for($i=0; $i<8; $i++) {
            Line::create([
                'name' => 'DCAA0' . $i+1
            ]);
        }
        
        for($i=0; $i<2; $i++) {
            Line::create([
                'name' => 'DSAA0' . $i+1
            ]);
        }

        Theme::create([
            'name' => 'Gunakan Loto Saat Dandori'
        ]);
    }
}
