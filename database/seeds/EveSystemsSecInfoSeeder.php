<?php

use Illuminate\Database\Seeder;

class EveSystemsSecInfoSeeder extends Seeder
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
                $result = $db->table('mapSolarSystems')
                    ->where('solarSystemID', $system->system_id)
                    ->first();
     
                DB::table('eve_systems')
                    ->where('system_id', $system->system_id)
                    ->update([
                        'security_status' => $result->security,
                        'security_class' => $result->securityClass
                    ]);
            }
        });
    }
}
