<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Empleado extends Model
{
    /**
     * Get the user associated with the Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }
    /**
     * Get all of the especialidades for the Empleado
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function especialidades(): HasMany
    {
        return $this->hasMany(Especialidad::class);
    }
}
