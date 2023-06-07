<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsInTable implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $ids = explode(',', $value);

        return DB::table($this->table)->whereIn($this->column, $ids)->count() === count($ids);
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}
