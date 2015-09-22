<?php

use Illuminate\Database\Seeder;

class Ligue1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\League::where(['name' => 'Ligue 1'])->count() > 0) {
            return false;
        }

        $league = \App\Models\League::firstOrNew([
            'name' => 'Ligue 1',
            'logoPath' => 'leagues-logo/ligue1.png'
        ]);
        $league->save();

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'AS Monaco FC',
            'logoPath' => 'teams-logo/monaco.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Paris Saint-Germain',
            'logoPath' => 'teams-logo/psg.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
