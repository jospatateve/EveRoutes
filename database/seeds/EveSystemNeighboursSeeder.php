<?php

use Illuminate\Database\Seeder;

class EveSystemNeighboursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::set('database.connections.evedatadump', [
            'driver' => 'sqlite',
            'database' => storage_path('universeDataDx.db'),
            'prefix' => ''
        ]);
        $db = DB::connection('evedatadump');
 
        DB::table('eve_systems')->orderBy('id')->chunk(100, function($systems) use ($db) {
            foreach ($systems as $system) {
                $results = $db->table('mapSolarSystemJumps')
                    ->where('fromSolarSystemID', $system->system_id)
                    ->pluck('toSolarSystemID');
     
                DB::table('eve_systems')
                    ->where('system_id', $system->system_id)
                    ->update(['neighbours' => implode(';', $results)]);
            }
        });
    }
}
