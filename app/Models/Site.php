<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    protected $guarded = [];

    // --- Monthly Reports Relationships ---

    public function mealReports(): HasMany
    {
        return $this->hasMany(ReportMeal::class);
    }

    public function generalOpsReports(): HasMany
    {
        return $this->hasMany(ReportGeneralOp::class);
    }

    public function vehicleReports(): HasMany
    {
        return $this->hasMany(ReportVehicle::class);
    }

    public function wasteReports(): HasMany
    {
        return $this->hasMany(ReportWaste::class);
    }

    public function auditReports(): HasMany
    {
        return $this->hasMany(ReportAudit::class);
    }

    public function hseReports(): HasMany
    {
        return $this->hasMany(ReportHse::class);
    }

    // --- Transactional Relationships ---

    public function capaTickets(): HasMany
    {
        return $this->hasMany(CapaTicket::class);
    }
}
