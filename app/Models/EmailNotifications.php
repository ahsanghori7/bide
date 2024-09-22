<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class EmailNotifications extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }

    public function scopeOrganization($query, $organization_id)
    {
        return $query->where('organization_id', $organization_id);
    }
}
