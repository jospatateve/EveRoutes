<?php

namespace App\Dotlan;

use Goutte\Client as WebScraper;

class Dotlan
{
    const URL = 'http://evemaps.dotlan.net/';

    function getRoute($type, array $waypoints)
    {
        $url = self::URL . "route/$type:" . implode(':', $waypoints);
        $route = [];

        $httpclient = new WebScraper;
        $crawler = $httpclient->request('GET', $url);
        $crawler->filter('div#navtools>table>tr>td:nth-of-type(3)>b>a')->each(function($node) use (&$route) {
            $route[] = $node->text();
        });

        return $route;
    }
}
