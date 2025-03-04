<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Especialidad extends Model
{
    /**
     * Get the empleado that owns the Especialidad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }
}
