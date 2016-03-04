<?php

use Illuminate\Database\Seeder;

use App\EveOnline\EvePublicCREST;
use App\EveSystem;

class EveSystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evecrest = new EvePublicCREST();
        $crestresponse = $evecrest->getSystems();
        $evesystems = $crestresponse['items'];

        foreach ($evesystems as $evesystem) {
            $system = new EveSystem;
            $system->name = $evesystem['name'];
            $system->system_id = $evesystem['id_str'];
            $system->save();
        }
    }
}
