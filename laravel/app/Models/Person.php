<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    public function getDegreeWith($target_person_id)
    {
        $queue = [[$this->id, 0, [$this->id]]]; 
        $visited = []; 
    
        while (!empty($queue)) {
            [$current_id, $degree, $path] = array_shift($queue);
    
            if ($degree > 25) {
                return ['degree' => false, 'path' => []];
            }
    
            if (in_array($current_id, $visited)) {
                continue;
            }
            $visited[] = $current_id;
    
            if ($current_id == $target_person_id) {
                return ['degree' => $degree, 'path' => $path];
            }
    
            $related_ids = DB::select("
                SELECT DISTINCT related_id FROM (
                    SELECT parent_id AS related_id FROM relationships WHERE child_id = ?
                    UNION
                    SELECT child_id AS related_id FROM relationships WHERE parent_id = ?
                ) AS related_people
            ", [$current_id, $current_id]);
    
            $related_ids = array_column($related_ids, 'related_id'); // Extract related IDs
    
            foreach ($related_ids as $related_id) {
                if (!in_array($related_id, $visited)) {
                    $queue[] = [$related_id, $degree + 1, array_merge($path, [$related_id])];
                }
            }
        }
    
        return ['degree' => false, 'path' => []];
    }
}
