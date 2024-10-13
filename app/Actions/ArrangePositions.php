<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class ArrangePositions
{
    public static function run(int $id)
    {
        DB::update('
            UPDATE proposals AS p
            JOIN (
                SELECT id, 
                       ROW_NUMBER() OVER (ORDER BY hours ASC) AS position
                FROM proposals
                WHERE project_id = ?
            ) AS ranked
            ON p.id = ranked.id
            SET p.position = ranked.position
            WHERE p.project_id = ?
        ', [$id, $id]);
    }
}
