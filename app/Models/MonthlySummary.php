<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MonthlySummary extends Model
{
    protected $table = 'report_meals'; // This will be overridden in the resource by fromSub

    // Since we're using a subquery, we should tell Eloquent not to expect a real table
    // with its default behaviors like ordering by ID if we're not using it.

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id'; // We aliased report_month to id in the query
}
