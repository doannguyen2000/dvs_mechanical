<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    public static function getTables()
    {
        $tables = [];

        $databaseName = DB::connection()->getDatabaseName();
        $tablesQuery = DB::select("SHOW TABLES FROM $databaseName");

        foreach ($tablesQuery as $table) {
            $tableName = reset($table);
            $tables[] = $tableName;
        }

        return $tables;
    }
}
