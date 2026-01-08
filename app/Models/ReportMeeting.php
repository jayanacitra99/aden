<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMeeting extends Model
{
    protected $table = 'report_meetings';
    protected $guarded = [];

    protected $casts = [
        'report_month' => 'date',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
