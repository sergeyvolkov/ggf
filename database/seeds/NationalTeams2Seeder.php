<?php

use Illuminate\Database\Seeder;

class NationalTeams2Seeder extends Seeder
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
            'name' => 'Austria',
            'logoPath' => 'teams-logo/austria.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Denmark',
            'logoPath' => 'teams-logo/denmark.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Greece',
            'logoPath' => 'teams-logo/greece.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Portugal',
            'logoPath' => 'teams-logo/portugal.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Switzerland',
            'logoPath' => 'teams-logo/switzerland.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

    }
}
