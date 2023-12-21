<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Line;
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
        // Shift::create([
        //     'name' => 'Shift 1',
        //     'time_start' => '06:00:00',
        //     'time_end' => '14:15:00'
        // ]);
        
        // Shift::create([
        //     'name' => 'Shift 2',
        //     'time_start' => '14:10:00',
        //     'time_end' => '22:15:00'
        // ]);

        // Shift::create([
        //     'name' => 'Shift 3',
        //     'time_start' => '22:10:00',
        //     'time_end' => '06:05:00'
        // ]);

        // Shift::create([
        //     'name' => 'Shift 1 Long',
        //     'time_start' => '05:55:00',
        //     'time_end' => '18:00:00'
        // ]);

        // Shift::create([
        //     'name' => 'Shift 3 Long',
        //     'time_start' => '18:30:00',
        //     'time_end' => '07:00:00'
        // ]);

        // Shift::create([
        //     'name' => 'Non Shift',
        //     'time_start' => '07:15:00',
        //     'time_end' => '16:20:00'
        // ]);
            
        // Line
        $origin = Origin::select('id')->where('name', 'DC')->first();
        $lines = Line::where('origin_id', $origin->id)->get();

        // Position::whereNull('size')->update([
        //     'size' => 80
        // ]);

        foreach ($lines as $line) {
            for($i=1; $i<=2; $i++) {
                if($i == 1){
                    Position::where('line_id',$line->id)
                    ->where('pos', $i)
                    ->update([
                        'top' => 59,
                        'left' => 28
                    ]);
                }else{
                    Position::where('line_id',$line->id)
                    ->where('pos', $i)
                    ->update([
                        'top' => 70,
                        'left' => 44
                    ]);
                }
            }
        }
        
        // for($i=1; $i<=2; $i++) {
        //         Line::create([
        //             'origin_id' => $origin->id,
        //             'name' => 'ASAN0' . $i
        //         ]);
        // }
        
        // for($i=0; $i<1; $i++) {
        //     Line::create([
        //         'origin_id' => $origin->id,
        //         'name' => 'ASIP0' . $i+1
        //     ]);
        // }
        
        // for($i=0; $i<1; $i++) {
        //     Line::create([
        //         'origin_id' => $origin->id,
        //         'name' => 'ASMP0' . $i+1
        //     ]);
        // }
        
        // for($i=0; $i<1; $i++) {
        //     Line::create([
        //         'origin_id' => $origin->id,
        //         'name' => 'ASVP0' . $i+1
        //     ]);
        // }

        // Origin::create([
        //     'name' => 'DC'
        // ]);
        // Origin::create([
        //     'name' => 'MA'
        // ]);
        // Origin::create([
        //     'name' => 'ASSY'
        // ]);
        // Origin::create([
        //     'name' => 'ELECTRIC'
        // ]);
    }
}
