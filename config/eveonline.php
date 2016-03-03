<?php

return [
    'id' => env('EVEONLINE_PROJECT_ID', ''),
    'secret' => env('EVEONLINE_PROJECT_SECRET', ''),
    'callback' => 'login/eveonline/callback',
	'scope' => [
        'publicData',
        'characterLocationRead',
        'characterNavigationWrite',
    ],
    'crest' => 'https://crest-tq.eveonline.com/',
    'public-crest' => 'https://public-crest.eveonline.com/',
    'eveserverip' => '',
];
