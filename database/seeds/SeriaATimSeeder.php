<?php

use Illuminate\Database\Seeder;

class SeriaATimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $league = \App\Models\League::firstOrNew([
            'name' => 'Seria A TIM',
            'logoPath' => 'leagues-logo/seriaa-tim.png'
        ]);
        $league->save();

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'AC Milan',
            'logoPath' => 'teams-logo/milan.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'AS Roma',
            'logoPath' => 'teams-logo/roma.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Atalanta',
            'logoPath' => 'teams-logo/atalanta.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Bologna',
            'logoPath' => 'teams-logo/bologna.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Carpi',
            'logoPath' => 'teams-logo/carpi.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Chievo',
            'logoPath' => 'teams-logo/chievo.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Empoli',
            'logoPath' => 'teams-logo/empoli.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Frosinone',
            'logoPath' => 'teams-logo/frosinone.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Fiorentina',
            'logoPath' => 'teams-logo/fiorentina.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Genoa',
            'logoPath' => 'teams-logo/genoa.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Hellas Verona',
            'logoPath' => 'teams-logo/verona.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Inter',
            'logoPath' => 'teams-logo/inter.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Juventus',
            'logoPath' => 'teams-logo/juventus.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Lazio',
            'logoPath' => 'teams-logo/lazio.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Napoli',
            'logoPath' => 'teams-logo/napoli.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Palermo',
            'logoPath' => 'teams-logo/palermo.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Sampdoria',
            'logoPath' => 'teams-logo/sampdoria.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Sassuolo',
            'logoPath' => 'teams-logo/sassuolo.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Torino',
            'logoPath' => 'teams-logo/torino.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'leagueId' => $league->id,
            'name' => 'Udinese',
            'logoPath' => 'teams-logo/udinese.png',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);


    }
}
