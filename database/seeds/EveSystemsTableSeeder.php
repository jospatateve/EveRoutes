<?php

use Illuminate\Database\Seeder;

use App\EveSystem;

use Evelabs\OAuth2\Client\Provider\EveOnline;

class EveSystemsTableSeeder extends Seeder
{
    private function getEveSystemsCREST()
    {
        $evesso = new EveOnline([
            'clientId'     => Config::get('eveonline.id'),
            'clientSecret' => Config::get('eveonline.secret'),
            'redirectUri'  => url(Config::get('eveonline.callback'))
        ]);

        $crestrequest = $evesso->getRequest(
            'GET',
            Config::get('eveonline.public-crest').'solarsystems/'
        );
        $crestresponse = $evesso->getResponse($crestrequest);
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
