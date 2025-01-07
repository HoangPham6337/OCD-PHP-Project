<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    // public function getDegreeWith($target_person_id)
    // {
    //     $queue = [[$this->id, 0]]; // [current_person_id, degree]
    //     $visited = [];

    //     while (!empty($queue)) {
    //         [$current_id, $degree] = array_shift($queue);

    //         if ($degree > 25) {
    //             return false;
    //         }

    //         if (in_array($current_id, $visited)) {
    //             continue;
    //         }
    //         $visited[] = $current_id;

    //         if ($current_id == $target_person_id) {
    //             return $degree;
    //         }

    //         // $related_ids = DB::table('relationships')
    //         //     ->where('parent_id', $current_id)
    //         //     ->orWhere('child_id', $current_id)
    //         //     ->pluck('parent_id', 'child_id')
    //         //     ->flatten()
    //         //     ->unique()
    //         //     ->toArray();

    //         $related_ids = DB::select("
    //         SELECT DISTINCT related_id FROM (
    //             SELECT parent_id AS related_id FROM relationships WHERE child_id = ?
    //             UNION
    //             SELECT child_id AS related_id FROM relationships WHERE parent_id = ?
    //         ) AS related_people
    //         ", [$current_id, $current_id]);

    //         $related_ids = array_column($related_ids, 'related_id');

    //         // Add unvisited related people to the BFS queue
    //         foreach ($related_ids as $related_id) {
    //             if (!in_array($related_id, $visited)) {
    //                 $queue[] = [$related_id, $degree + 1];
    //             }
    //         }
    //     }

    //     return false;
    // }

    public function getDegreeWith($target_person_id)
    {
        // Initialize the BFS queue with [current_person_id, degree, path]
        $queue = [[$this->id, 0, [$this->id]]]; // [current_person_id, degree, path]
        $visited = []; // Keep track of visited nodes
    
        while (!empty($queue)) {
            // Dequeue the first element
            [$current_id, $degree, $path] = array_shift($queue);
    
            // Stop searching if the degree exceeds 25
            if ($degree > 25) {
                return ['degree' => false, 'path' => []];
            }
    
            // Skip if already visited
            if (in_array($current_id, $visited)) {
                continue;
            }
            $visited[] = $current_id;
    
            // If we found the target person, return the degree and path
            if ($current_id == $target_person_id) {
                return ['degree' => $degree, 'path' => $path];
            }
    
            // Fetch related IDs using raw SQL query
            $related_ids = DB::select("
                SELECT DISTINCT related_id FROM (
                    SELECT parent_id AS related_id FROM relationships WHERE child_id = ?
                    UNION
                    SELECT child_id AS related_id FROM relationships WHERE parent_id = ?
                ) AS related_people
            ", [$current_id, $current_id]);
    
            $related_ids = array_column($related_ids, 'related_id'); // Extract related IDs
    
            // Add unvisited related people to the BFS queue
            foreach ($related_ids as $related_id) {
                if (!in_array($related_id, $visited)) {
                    $queue[] = [$related_id, $degree + 1, array_merge($path, [$related_id])];
                }
            }
        }
    
        // If no path is found, return false
        return ['degree' => false, 'path' => []];
    }
}
