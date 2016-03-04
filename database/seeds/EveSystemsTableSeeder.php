<?php

use Illuminate\Database\Seeder;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveCREST;
use App\EveSystem;

class EveSystemsTableSeeder extends Seeder
{
    private function getEveSystemsCREST()
    {
        $eveoauth = new EveOAuthProvider();
        $evecrest = new EveCREST($eveoauth);
        $crestresponse = $evecrest->getSystems();
        return $crestresponse['items'];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evesystems = $this->getEveSystemsCREST();
        foreach ($evesystems as $evesystem) {
            $system = new EveSystem;
            $system->name = $evesystem['name'];
            $system->system_id = $evesystem['id_str'];
            $system->save();
        }
    }
}
