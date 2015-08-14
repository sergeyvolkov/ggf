<?php

use Illuminate\Database\Seeder;

class BarclaysPremierLeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\League::where(['name' => 'Barclays Premier League'])->count() > 0) {
            return false;
        }

        $league = \App\Models\League::firstOrNew([
            'name' => 'Barclays Premier League',
            'logoPath' => 'leagues-logo/barclays-premier-league.png'
        ]);
        $league->save();

        $teams = [
            ['name' => 'Arsenal', 'logoPath' => 'teams-logo/arsenal.png'],
            ['name' => 'Aston Villa', 'logoPath' => 'teams-logo/aston-villa.png'],
            ['name' => 'Bournemouth', 'logoPath' => 'teams-logo/bournemouth.png'],
            ['name' => 'Chelsea', 'logoPath' => 'teams-logo/chelsea.png'],
            ['name' => 'Crystal Palace', 'logoPath' => 'teams-logo/crystal-palace.png'],
            ['name' => 'Everton', 'logoPath' => 'teams-logo/everton.png'],
            ['name' => 'Leicester', 'logoPath' => 'teams-logo/leicester.png'],
            ['name' => 'Liverpool', 'logoPath' => 'teams-logo/liverpool.png'],
            ['name' => 'Man City', 'logoPath' => 'teams-logo/manchester-city.png'],
            ['name' => 'Man Utd', 'logoPath' => 'teams-logo/manchester-utd.png'],
            ['name' => 'Newcastle', 'logoPath' => 'teams-logo/newcastle-utd.png'],
            ['name' => 'Norwich', 'logoPath' => 'teams-logo/norwich.png'],
            ['name' => 'Southampton', 'logoPath' => 'teams-logo/southampton.png'],
            ['name' => 'Stoke', 'logoPath' => 'teams-logo/stoke.png'],
            ['name' => 'Sunderland', 'logoPath' => 'teams-logo/sunderland.png'],
            ['name' => 'Swansea', 'logoPath' => 'teams-logo/swansea.png'],
            ['name' => 'Spurs', 'logoPath' => 'teams-logo/tottenham.png'],
            ['name' => 'Watford', 'logoPath' => 'teams-logo/watford.png'],
            ['name' => 'West Brom', 'logoPath' => 'teams-logo/west-brom.png'],
            ['name' => 'West Ham', 'logoPath' => 'teams-logo/west-ham.png'],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert([
                'leagueId' => $league->id,
                'name' => $team['name'],
                'logoPath' => $team['logoPath'],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
