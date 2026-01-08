<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportVehicle extends Model
{
    protected $table = 'report_vehicles';
    protected $guarded = [];

    protected $casts = [
        'report_month' => 'date',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
