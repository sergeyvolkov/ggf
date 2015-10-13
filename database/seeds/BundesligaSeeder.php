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
        $league = \App\Models\League::where(['name' => 'Bundesliga'])->first();

        if ($league) {

            if (\App\Models\Team::where(['leagueId' => $league->id])->count() > 2) {
                return false;
            }

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Schalke 04',
                'logoPath' => 'teams-logo/schalke04.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Hertha BSC',
                'logoPath' => 'teams-logo/hertha.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => '1. FC Köln',
                'logoPath' => 'teams-logo/koln.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'FC Ingolstadt 04',
                'logoPath' => 'teams-logo/ingolstadt.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Bayer Leverkusen',
                'logoPath' => 'teams-logo/leverkusen.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => '1. FSV Mainz 05',
                'logoPath' => 'teams-logo/mainz.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'VfL Wolfsburg',
                'logoPath' => 'teams-logo/wolfsburg.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'SV Darmstadt 98',
                'logoPath' => 'teams-logo/darmstadt.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Hamburger SV',
                'logoPath' => 'teams-logo/hamburger.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Eintracht Frankfurt',
                'logoPath' => 'teams-logo/eintracht.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Borussia Mönchengladbach',
                'logoPath' => 'teams-logo/munchengladbach.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Werder Bremen',
                'logoPath' => 'teams-logo/werder.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Hoffenheim',
                'logoPath' => 'teams-logo/hoffenheim.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'FC Augsburg',
                'logoPath' => 'teams-logo/augsburg.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'Hannover 96',
                'logoPath' => 'teams-logo/hannover.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => 'VfB Stuttgart',
                'logoPath' => 'teams-logo/stuttgart.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);


        } else {
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
}
