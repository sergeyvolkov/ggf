<?php

use Illuminate\Database\Seeder;

class NationalTeamsFranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $league = \App\Models\League::where([
            'name' => 'National teams',
        ])->firstOrFail();

        if (\App\Models\Team::where(['name' => 'France'])->count() > 0) {
            return false;
        }

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'France',
            'logoPath' => 'teams-logo/france.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
