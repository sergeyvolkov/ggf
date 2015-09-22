<?php

use Illuminate\Database\Seeder;

class BundesligaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\League::where(['name' => 'Bundesliga'])->count() > 0) {
            return false;
        }

        $league = \App\Models\League::firstOrNew([
            'name' => 'Bundesliga',
            'logoPath' => 'leagues-logo/bundesliga.png'
        ]);
        $league->save();

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'FC Bayern Munich',
            'logoPath' => 'teams-logo/bayern.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Borussia Dortmund',
            'logoPath' => 'teams-logo/dortmund.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
