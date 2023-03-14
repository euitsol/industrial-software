<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsvData extends Model
{
    protected $table = 'csv_data';


    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
