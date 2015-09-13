<?php

use Illuminate\Database\Seeder;

class NationalTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\League::where(['name' => 'National teams'])->count() > 0) {
            return false;
        }

        $league = \App\Models\League::firstOrNew([
            'name' => 'National teams',
            'logoPath' => 'leagues-logo/national-teams.png'
        ]);
        $league->save();

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Argentina',
            'logoPath' => 'teams-logo/argentina.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Brazil',
            'logoPath' => 'teams-logo/brazil.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Germany',
            'logoPath' => 'teams-logo/germany.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Italy',
            'logoPath' => 'teams-logo/italy.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Spain',
            'logoPath' => 'teams-logo/spain.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

    }
}
