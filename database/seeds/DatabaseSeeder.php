<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeriaATimSeeder::class);
        $this->call(BarclaysPremierLeagueSeeder::class);
        $this->call(LigaBBVASeeder::class);
        $this->call(NationalTeamsSeeder::class);
        $this->call(NationalTeamsFranceSeeder::class);
        $this->call(BundesligaSeeder::class);
        $this->call(Ligue1Seeder::class);

        Model::reguard();
    }
}
