<?php

namespace App\EveOnline;

use App\EveSystem;

class EveMap
{
    public static function neighbours($system)
    {
        $system = EveSystem::where('system_id', "$system")->first();
        $idsraw = explode(';', $system->neighbours);
        return array_filter($idsraw, 'strlen');
    }

    public static function shortestPath($source, $destination, $avoidance_list = [])
    {
        if ($source == $destination) {
            return [$source];
        }

        $path = [];

        $visited = $avoidance_list;
        $visited[] = $source;
        $parent_map = [];
        $queue = new \SplQueue;
        $queue->enqueue($source);
     
        while (!$queue->isEmpty()) {
            $current_system = $queue->dequeue();

            if ($current_system == $destination) {
                $path[] = $destination;
                while (true) {
                    $parent = $parent_map[$current_system];
                    $path[] = $parent;
                    if ($parent != $source) {
                        $current_system = $parent_map[$current_system];
                    } else {
                        return array_reverse($path);
                    }
                }
            } else {
                foreach (array_diff(static::neighbours($current_system), $visited) as $neighbour) {
                    $parent_map[$neighbour] = $current_system;
                    $visited[] = $neighbour;
                    $queue->enqueue($neighbour);
                }
            }
        }

        return $path;
    }
}
