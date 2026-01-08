<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapaTicket extends Model
{
    protected $guarded = [];

    protected $casts = [
        'finding_date' => 'date',
        'due_date' => 'date',
        'realization_date' => 'date',
        'is_late' => 'boolean',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    // Helper to colorize status in UI if needed manually
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'OPEN' => 'danger',
            'ON PROGRESS' => 'warning',
            'CLOSED' => 'success',
            default => 'gray',
        };
    }
}
