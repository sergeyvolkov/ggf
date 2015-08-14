<?php

use Illuminate\Database\Seeder;

class LigaBBVASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\League::where(['name' => 'Liga BBVA'])->count() > 0) {
            return false;
        }

        $league = \App\Models\League::firstOrNew([
            'name' => 'Liga BBVA',
            'logoPath' => 'leagues-logo/liga-bbva.png'
        ]);
        $league->save();

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Athletic Club',
            'logoPath' => 'teams-logo/athletic.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Atlético Madrid',
            'logoPath' => 'teams-logo/atletico.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Celta de Vigo',
            'logoPath' => 'teams-logo/celta.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Deportivo La Coruña',
            'logoPath' => 'teams-logo/deportivo.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Eibar',
            'logoPath' => 'teams-logo/eibar.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'FC Barcelona',
            'logoPath' => 'teams-logo/barcelona.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Getafe CF',
            'logoPath' => 'teams-logo/getafe.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Granada CF',
            'logoPath' => 'teams-logo/granada.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Las Palmas',
            'logoPath' => 'teams-logo/las-palmas.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Levante UD',
            'logoPath' => 'teams-logo/levante.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Málaga CF',
            'logoPath' => 'teams-logo/malaga.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Rayo Vallecano',
            'logoPath' => 'teams-logo/rayo.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'RCD Espanyol',
            'logoPath' => 'teams-logo/espanyol.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Real Betis',
            'logoPath' => 'teams-logo/betis.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Real Madrid CF',
            'logoPath' => 'teams-logo/real-madrid.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Real Sociedad',
            'logoPath' => 'teams-logo/sociedad.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Sevilla FC',
            'logoPath' => 'teams-logo/sevilla.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Sporting Gijón',
            'logoPath' => 'teams-logo/sporting.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Valencia',
            'logoPath' => 'teams-logo/valencia.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);


        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Villarreal CF',
            'logoPath' => 'teams-logo/villarreal.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

    }
}
